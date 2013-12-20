<?php
/**
 * The model file of user module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php
class userModel extends model
{
    /**
     * Get users List.
     *
     * @param object  $pager
     * @param string  $userName
     * @param int|array  $dept
     * @access public
     * @return object 
     */
    public function getList($pager, $userName = '', $dept = 0)
    {
        return $this->dao->select('*')->from(TABLE_USER)
            ->where('1=1')         
            ->beginIF($userName != '')->andWhere('account')->like("%$userName%")->fi()
            ->beginIF($dept != 0)->andWhere('dept')->in($dept)->fi()
            ->orderBy('id_asc')    
            ->page($pager)         
            ->fetchAll();          
    }

    /**
     * Get the account=>relaname pairs.
     * 
     * @param  string    $params  admin|noempty
     * @param  int|array $dept
     * @access public
     * @return array
     */
    public function getPairs($params = '', $dept = 0)
    {
        $users = $this->dao->select('account, realname')->from(TABLE_USER) 
            ->where('1=1')         
            ->beginIF(strpos($params, 'admin') !== false)->where('admin')->ne('no')->fi()
            ->beginIF($dept != 0)->andWhere('dept')->in($dept)->fi()
            ->orderBy('id_asc')    
            ->fetchPairs();

        /* Append empty users. */
        if(strpos($params, 'noempty') === false) $users = array('' => '') + $users;

        return $users;
    }

    /**
     * Get the basic info of some user.
     * 
     * @param mixed $users 
     * @access public
     * @return void
     */
    public function getBasicInfo($users)
    {
        $users = $this->dao->select('account, realname, `join`, last, visits')->from(TABLE_USER)->where('account')->in($users)->fetchAll('account', false);
        if(!$users) return array();

        foreach($users as $account => $user)
        {
            $user->realname  = empty($user->realname) ? $account : $user->realname;
            $user->shortLast = substr($user->last, 5, -3);
            $user->shortJoin = substr($user->join, 5, -3);
        }

        return $users;
    }

    /**
     * Get user by his account.
     * 
     * @param mixed $account
     * @access public
     * @return object           the user.
     */
    public function getByAccount($account)
    {
        return $this->dao->select('*')->from(TABLE_USER)
            ->beginIF(validater::checkEmail($account))->where('email')->eq($account)->fi()
            ->beginIF(!validater::checkEmail($account))->where('account')->eq($account)->fi()
            ->fetch('', false);
    }

    /**
     * Get user list with email and real name.
     * 
     * @param  string|array $users 
     * @access public          
     * @return array           
     */
    public function getRealNameAndEmails($users)
    {
        $users = $this->dao->select('account, email, realname')->from(TABLE_USER)->where('account')->in($users)->fetchAll('account');
        if(!$users) return array();     
        foreach($users as $account => $user) if($user->realname == '') $user->realname = $account; 
        return $users;         
    }

    /**
     * Create a user.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $this->checkPassword();

        $user = fixer::input('post')
            ->setForce('join', date('Y-m-d H:i:s'))
            ->setForce('last', helper::now())
            ->setForce('visits', 1)
            ->setIF($this->post->password1 == false, 'password', '')
            ->setIF($this->cookie->referer != '', 'referer', $this->cookie->referer)
            ->setIF($this->cookie->referer == '', 'referer', '')
            ->remove('admin, ip')
            ->get();
        $user->password = $this->createPassword($this->post->password1, $user->account); 

        $this->dao->insert(TABLE_USER)
            ->data($user, $skip = 'password1,password2')
            ->autoCheck()
            ->batchCheck($this->config->user->register->requiredFields, 'notempty')
            ->check('account', 'unique')
            ->check('account', 'account')
            ->check('email', 'email')
            ->check('email', 'unique')
            ->exec();
    }

    /**
     * Update an account.
     * 
     * @param  string $account 
     * @access public
     * @return void
     */
    public function update($account)
    {
        /* If the user want to change his password. */
        if($this->post->password1 != false)
        {
            $this->checkPassword();
            if(dao::isError()) return false;

            $password  = $this->createPassword($this->post->password1, $account);
            $this->post->set('password', $password);
        }

        $user = fixer::input('post')->cleanInt('imobile, qq, zipcode')->remove('ip, account, join, visits');
        if(RUN_MODE != 'admin') $user = $user->remove('admin');
        $user = $user->get();

        return $this->dao->update(TABLE_USER)
            ->data($user, $skip = 'password1,password2')
            ->autoCheck()
            ->batchCheck($this->config->user->edit->requiredFields, 'notempty')
            ->check('email', 'email')
            ->check('email', 'unique', "account!='$account'")
            ->checkIF($this->post->gtalk != false, 'gtalk', 'email')
            ->where('account')->eq($account)
            ->exec();
    }

    /**
     * Check the password is valid or not.
     * 
     * @access public
     * @return bool
     */
    public function checkPassword()
    {
        if($this->post->password1 != false)
        {
            if($this->post->password1 != $this->post->password2) dao::$errors['password1'][] = $this->lang->error->passwordsame;
            if(!validater::checkReg($this->post->password1, '|(.){6,}|')) dao::$errors['password1'][] = $this->lang->error->passwordrule;
        }
        else
        {
            dao::$errors['password1'][] = $this->lang->user->inputPassword;
        }
        return !dao::isError();
    }
    
    /**     
     * Update password 
     *          
     * @param  string $account 
     * @access public          
     * @return void
     */     
    public function updatePassword($account)
    { 
        $this->checkPassword();
        if(dao::isError()) return false;

        $user = fixer::input('post')
            ->setIF($this->post->password1 != false, 'password', $this->createPassword($this->post->password1, $account))
            ->remove('password1, password2, ip, account, admin, join, visits')
            ->get();

        $this->dao->update(TABLE_USER)->data($user)->autoCheck()->where('account')->eq($account)->exec();
    }   

    /**
     * Try to login with an account and password.
     * 
     * @param  string    $account 
     * @param  string    $password 
     * @access public
     * @return bool
     */
    public function login($account, $password)
    {
        $user = $this->identify($account, $password);
        if(!$user) return false;

        $user->rights = $this->authorize($user);
        $this->session->set('user', $user);
        $this->app->user = $this->session->user;

        return true;
    }

    /**
     * Identify a user.
     * 
     * @param   string $account     the account
     * @param   string $password    the password    the plain password or the md5 hash
     * @access  public
     * @return  object              if is valid user, return the user object.
     */
    public function identify($account, $password)
    {
        if(!$account or !$password) return false;

        /* First get the user from database by account or email. */
        $user = $this->dao->select('*')->from(TABLE_USER)
            ->beginIF(validater::checkEmail($account))->where('email')->eq($account)->fi()
            ->beginIF(!validater::checkEmail($account))->where('account')->eq($account)->fi()
            ->fetch();

        /* Then check the password hash. */
        if(!$user) return false;

        /* Can not login before ten minutes when user is locked. */
        if($user->locked != '0000-00-00 00:00:00')
        {
            $dateDiff = (strtotime($user->locked) - time()) / 60;

            /* Check the type of lock and show it. */
            if($dateDiff > 0 && $dateDiff <= 10)
            {
                $this->lang->user->loginFailed = sprintf($this->lang->user->locked, '10' . $this->lang->date->minute);
                return false;
            }
            elseif($dateDiff > 10)
            {
                $dateDiff = ceil($dateDiff / 60 / 24);
                $this->lang->user->loginFailed = $dateDiff <= 30 ? sprintf($this->lang->user->locked, $dateDiff . $this->lang->date->day) : $this->lang->user->lockedForEver;
                return false;
            }
            else
            {
                $user->fails  = 0;
                $user->locked = '0000-00-00 00:00:00';
            }
        }

        /* The password can be the plain or the password after md5. */
        if(!$this->compareHashPassword($password, $user))
        {
            $user->fails ++;
            if($user->fails > 2 * 2) $user->locked = date('Y-m-d H:i:s', time() + 10 * 60);
            $this->dao->update(TABLE_USER)->data($user)->where('id')->eq($user->id)->exec();
            return false;
        }

        /* Update user data. */
        $user->ip     = $this->server->remote_addr;
        $user->last   = helper::now();
        $user->fails  = 0;
        $user->visits ++;

        /* Update password when create password by oldCreatePassword function. */
        $this->dao->update(TABLE_USER)->data($user)->where('account')->eq($account)->exec();

        $user->realname  = empty($user->realname) ? $account : $user->realname;
        $user->shortLast = substr($user->last, 5, -3);
        $user->shortJoin = substr($user->join, 5, -3);
        unset($_SESSION['random']);

        /* Return him.*/
        return $user;
    }

    /**
     * Authorize a user.
     * 
     * @param   object    $user   the user object.
     * @access  public
     * @return  array
     */
    public function authorize($user)
    {
        $rights = $this->config->rights->guest;
        if($user->account == 'guest') return $rights;

        foreach($this->config->rights->member as $moduleName => $moduleMethods)
        {
            foreach($moduleMethods as $method) $rights[$moduleName][$method] = $method;
        }

        return $rights;
    }

    /**
     * Juage a user is logon or not.
     * 
     * @access public
     * @return bool
     */
    public function isLogon()
    {
        return (isset($_SESSION['user']) and !empty($_SESSION['user']) and $_SESSION['user']->account != 'guest');
    }

    /**
     * Forbid the user
     *
     * @param string $date
     * @param int $userID
     * @access public
     * @return void
     */
    public function forbid($userID, $date)
    {
        $intdate = strtotime("+$date day");

        $format = 'Y-m-d H:i:s';

        $date = date($format,$intdate);
        $this->dao->update(TABLE_USER)->set('locked')->eq($date)->where('id')->eq($userID)->exec();

        return !dao::isError();
    }

    /**
     * Delete user.
     * 
     * @param  string    $account 
     * @param  null      $id          add this param to avoid the warning of php.
     * @access public
     * @return bool
     */
    public function delete($account, $id = null) 
    {
        $user = $this->getByAccount($account);
        if(!$user) return false;

        $this->dao->delete()->from(TABLE_USER)->where('account')->eq($account)->exec();

        return !dao::isError();
    }

    /**
     * update the resetKey.
     * 
     * @param  string   $account
     * @param  time     $resetTime 
     * @access public
     * @return void
     */
    public function resetKey($account, $resetKey)
    {
        $this->dao->update(TABLE_USER)->set('resetKey')->eq($resetKey)->set('resetTime')->eq(helper::now())->where('account')->eq($account)->exec(false);
    }

    /**
     * Check the resetKey.
     * 
     * @param  string   $resetKey 
     * @param  time     $resetTime 
     * @access public
     * @return void
     */
    public function checkResetKey($resetKey)
    {
        $user = $this->dao->select('*')->from(TABLE_USER)
            ->where('resetKey')->eq($resetKey)
            ->fetch('');
        return $user;
    }

    /**
     * Reset the forgotten password.
     * 
     * @param  string   $resetKey 
     * @param  time     $resetTime 
     * @access public
     * @return void
     */
    public function resetPassword($resetKey, $password)
    {
        $user = $this->dao->select('*')->from(TABLE_USER)
                ->where('resetKey')->eq($resetKey)
                ->fetch();
        
        $this->dao->update(TABLE_USER)
            ->set('password')->eq($this->createPassword($password, $user->account))
            ->set('resetKey')->eq('')
            ->set('resetTime')->eq('')
            ->where('resetKey')->eq($resetKey)
            ->exec();
    }

    /**
     * Create a strong password hash with md5.
     *
     * @param  string    $password 
     * @param  string    $account 
     * @access public
     * @return void
     */
    public function createPassword($password, $account)
    {
        return md5(md5($password) . $account);
    }

    /**
     * Compare hash password use random
     * 
     * @param  string    $password 
     * @param  object    $user 
     * @access public
     * @return void
     */
    public function compareHashPassword($password, $user)
    {
        return $password == md5($user->password . $this->session->random);
    }
}
