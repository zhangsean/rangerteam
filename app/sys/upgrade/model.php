<?php
/**
 * The model file of upgrade module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php
class upgradeModel extends model
{
    /**
     * Errors.
     * 
     * @static
     * @var array 
     * @access public
     */
    static $errors = array();

    /**
     * The execute method. According to the $fromVersion call related methods.
     * 
     * @param  string $fromVersion 
     * @access public
     * @return void
     */
    public function execute($fromVersion)
    {
        switch($fromVersion)
        {
            case '1_0_beta':
                $this->execSQL($this->getUpgradeFile('1.0.beta'));
                $this->createCashEntry();
            case '1_1_beta':
                $this->execSQL($this->getUpgradeFile('1.1.beta'));
                $this->createTeamEntry();
            case '1_2_beta':
                $this->execSQL($this->getUpgradeFile('1.2.beta'));
                $this->transformBlock();
                $this->changeBuildinName();
                $this->computeContactInfo();
            case '1_3_beta':
                $this->execSQL($this->getUpgradeFile('1.3.beta'));
                $this->setCompanyContent();
            case '1_4_beta':
                $this->upgradeContractName();
                $this->upgradeProjectMember();

                /* Exec sqls must after fix data. */
                $this->execSQL($this->getUpgradeFile('1.4.beta'));

            default: if(!$this->isError()) $this->loadModel('setting')->updateVersion($this->config->version);
        }

        $this->deletePatch();
    }

    /**
     * Create the confirm contents.
     * 
     * @param  string $fromVersion 
     * @access public
     * @return string
     */
    public function getConfirm($fromVersion)
    {
        $confirmContent = '';
        switch($fromVersion)
        {
            case '1_0_beta': $confirmContent .= file_get_contents($this->getUpgradeFile('1.0.beta'));
            case '1_1_beta': $confirmContent .= file_get_contents($this->getUpgradeFile('1.1.beta'));
            case '1_2_beta': $confirmContent .= file_get_contents($this->getUpgradeFile('1.2.beta'));
            case '1_3_beta': $confirmContent .= file_get_contents($this->getUpgradeFile('1.3.beta'));
        }
        return $confirmContent;
    }

    /**
     * Delete the patch record.
     * 
     * @access public
     * @return void
     */
    public function deletePatch()
    {
        return true;
        $this->dao->delete()->from(TABLE_EXTENSION)->where('type')->eq('patch')->exec();
    }

    /**
     * Get the upgrade sql file.
     * 
     * @param  string $version 
     * @access public
     * @return string
     */
    public function getUpgradeFile($version)
    {
        return $this->app->getBasepath() . 'db' . DS . 'upgrade' . $version . '.sql';
    }

    /**
     * Execute a sql.
     * 
     * @param  string  $sqlFile 
     * @access public
     * @return void
     */
    public function execSQL($sqlFile)
    {
        $mysqlVersion = $this->loadModel('install')->getMysqlVersion();

        /* Read the sql file to lines, remove the comment lines, then join theme by ';'. */
        $sqls = explode("\n", file_get_contents($sqlFile));
        foreach($sqls as $key => $line) 
        {
            $line       = trim($line);
            $sqls[$key] = $line;
            if(strpos($line, '--') !== false or empty($line)) unset($sqls[$key]);
        }
        $sqls = explode(';', join("\n", $sqls));

        foreach($sqls as $sql)
        {
            $sql = trim($sql);
            if(empty($sql)) continue;

            if($mysqlVersion <= 4.1)
            {
                $sql = str_replace('DEFAULT CHARSET=utf8', '', $sql);
                $sql = str_replace('CHARACTER SET utf8 COLLATE utf8_general_ci', '', $sql);
            }

            try
            {
                $this->dbh->exec($sql);
            }
            catch (PDOException $e) 
            {
                self::$errors[] = $e->getMessage() . "<p>The sql is: $sql</p>";
            }
        }
    }

    /**
     * Judge any error occers.
     * 
     * @access public
     * @return bool
     */
    public function isError()
    {
        return !empty(self::$errors);
    }

    /**
     * Get errors during the upgrading.
     * 
     * @access public
     * @return array
     */
    public function getError()
    {
        $errors = self::$errors;
        self::$errors = array();
        return $errors;
    }

    /**
     * create cash entry.
     * 
     * @access public
     * @return void
     */
    public function createCashEntry()
    {
        $entry = new stdclass();

        $entry->name     = 'cash';
        $entry->code     = 'cash';
        $entry->open     = 'iframe';
        $entry->order    = 2;
        $entry->ip       = '*';
        $entry->key      = '438d85f2c2b04372662c63ebfb1c4c2f';
        $entry->logo     = $this->config->webRoot . 'theme/default/images/ips/app-cash.png';
        $entry->login    = '../cash';
        $entry->ip       = '*';
        $entry->control  = 'simple';
        $entry->visible  = 1;
        $entry->size     = 'max';
        $entry->position = 'default';

        $block = REQUESTTYPE == 'GET' ? 'cash/index.php?m=block&f=index' : 'cash/block-index.html';
        $entry->block = $this->config->webRoot . $block;

        $this->dao->insert(TABLE_ENTRY)->data($entry)->exec();
    }

    /**
     * create team entry.
     * 
     * @access public
     * @return void
     */
    public function createTeamEntry()
    {
        $entry = new stdclass();

        $entry->name     = 'team';
        $entry->code     = 'team';
        $entry->open     = 'iframe';
        $entry->order    = 4;
        $entry->ip       = '*';
        $entry->key      = '6c46d9fe76a1afa1cd61f946f1072d1e';
        $entry->logo     = $this->config->webRoot . 'theme/default/images/ips/app-team.png';
        $entry->login    = '../team';
        $entry->ip       = '*';
        $entry->control  = 'simple';
        $entry->size     = 'max';
        $entry->position = 'default';

        $block = REQUESTTYPE == 'GET' ? 'team/index.php?m=block&f=index' : 'team/block-index.html';
        $entry->block = $this->config->webRoot . $block;

        $this->dao->insert(TABLE_ENTRY)->data($entry)->exec();
    }

    /**
     * Transform block from config to block table.
     * 
     * @access public
     * @return bool
     */
    public function transformBlock()
    {
        $blocks  = $this->dao->select('*')->from(TABLE_CONFIG)->where('section')->eq('block')->andWhere('module')->eq('index')->fetchAll('id');
        $entries = $this->dao->select('id,code')->from(TABLE_ENTRY)->fetchPairs('id', 'code');

        foreach($blocks as $block)
        {
            if(empty($block->owner)) continue;
            $block->value = json_decode($block->value);

            $source  = '';
            $blockID = $block->value->type;
            if($block->value->type == 'system')
            {
                if($block->app == 'sys' and isset($block->value->entryID) and !isset($entries[$block->value->entryID])) continue;
                $source  = $block->app == 'sys' ? $entries[$block->value->entryID] : $block->app;
                $blockID = $block->value->blockID;
            }

            if($blockID == 'html') $block->value->params = helper::jsonEncode(array('html' => $block->value->html));
            if(!isset($block->value->params)) $block->value->params = array();

            $data = new stdclass();
            $data->account = $block->owner;
            $data->app     = $block->app;
            $data->title   = $block->value->name;
            $data->source  = $source;
            $data->block   = $blockID;
            $data->params  = helper::jsonEncode($block->value->params);
            $data->order   = str_replace('b', '', $block->key);
            $data->grid    = 3;

            $this->dao->replace(TABLE_BLOCK)->data($data)->exec();
        }
        if(dao::isError()) return false;

        $this->dao->delete()->from(TABLE_CONFIG)->where('section')->eq('block')->andWhere('module')->eq('index')->exec();
        return true;
    }

    /**
     * Change buildin entry name.
     * 
     * @access public
     * @return bool
     */
    public function changeBuildinName()
    {
        $this->app->loadLang('install', 'sys');

        foreach($this->lang->install->buildinEntry as $code => $name)
        {
            $this->dao->update(TABLE_ENTRY)
                ->set('name')->eq($name['name'])
                ->set('abbr')->eq($name['abbr'])
                ->set('buildin')->eq(1)
                ->set('integration')->eq(1)
                ->set('visible')->eq(1)
                ->where('code')->eq($code)
                ->exec();
        }

        if(dao::isError()) return false;
        return true;
    }

    /**
     * Compute contacteddate and contactedby fields.
     * 
     * @access public
     * @return void
     */
    public function computeContactInfo()
    {
        $orders    = $this->dao->select('id')->from(TABLE_ORDER)->fetchAll();
        $customers = $this->dao->select('id')->from(TABLE_CUSTOMER)->fetchAll();
        $contracts = $this->dao->select('id')->from(TABLE_CONTRACT)->fetchAll();
        $contacts  = $this->dao->select('id')->from(TABLE_CONTACT)->fetchAll();

        foreach($orders as $order)
        {
            $lastContact = $this->dao->select('actor as contactedBy, date as contactedDate')->from(TABLE_ACTION)
                ->where('action')->eq('record')
                ->andWhere('objectType')->eq('order')
                ->andWhere('objectID')->eq($order->id)
                ->orderBY('date_desc')
                ->limit(1)
                ->fetch();
            if($lastContact) $this->dao->update(TABLE_ORDER)->data($lastContact)->where('id')->eq($order->id)->exec();
        }

        foreach($customers as $customer)
        {
            $lastContact = $this->dao->select('actor as contactedBy, date as contactedDate')->from(TABLE_ACTION)
                ->where('action')->eq('record')
                ->andWhere('customer')->eq($customer->id)
                ->orderBY('date_desc')
                ->limit(1)
                ->fetch();
            if($lastContact) $this->dao->update(TABLE_CUSTOMER)->data($lastContact)->where('id')->eq($customer->id)->exec();
        }

        foreach($contacts as $contact)
        {
            $lastContact = $this->dao->select('actor as contactedBy, date as contactedDate')->from(TABLE_ACTION)
                ->where('action')->eq('record')
                ->andWhere('contact')->eq($contact->id)
                ->orderBY('date_desc')
                ->limit(1)
                ->fetch();
            if($lastContact) $this->dao->update(TABLE_CONTACT)->data($lastContact)->where('id')->eq($contact->id)->exec();
        }

        foreach($contracts as $contract)
        {
            $lastContact = $this->dao->select('actor as contactedBy, date as contactedDate')->from(TABLE_ACTION)
                ->where('action')->eq('record')
                ->andWhere('objectType')->eq('contract')
                ->andWhere('objectID')->eq($contract->id)
                ->orderBY('date_desc')
                ->limit(1)
                ->fetch();
            if($lastContact) $this->dao->update(TABLE_CONTRACT)->data($lastContact)->where('id')->eq($contract->id)->exec();
        }

        return !dao::isError();

    }

    /**
     * Set content of company when upgrade from 1.3.beta.
     * 
     * @access public
     * @return void
     */
    public function setCompanyContent()
    {
        if(empty($this->config->company->content) and $this->config->company->desc)
        {
            $this->dao->update(TABLE_CONFIG)->set('value')->eq($this->config->company->desc)->where('`key`')->eq('content')->andWhere('section')->eq('company')->exec();
            $this->dao->delete()->from(TABLE_CONFIG)->where('`key`')->eq('desc')->andWhere('section')->eq('company')->exec();
        }
        return !dao::isError();
    }

    /**
     * Set name of contract when upgrade from 1.4.beta.
     * 
     * @access public
     * @return void
     */
    public function upgradeContractName()
    {
        $contracts = $this->dao->select('*')->from(TABLE_CONTRACT)->fetchAll();

        foreach($contracts as $contract)
        {
            $name = preg_replace('/^\[(\d+)\]/', '', $contract->name);
            $this->dao->update(TABLE_CONTRACT)->set('name')->eq($name)->where('id')->eq($contract->id)->exec();
        }

        return !dao::isError();
    }

    /**
     * Update project member.
     * 
     * @access public
     * @return void
     */
    public function upgradeProjectMember()
    {
        $projects = $this->loadModel('project')->getList();
        foreach($projects as $project)
        {
            $member = new stdclass();
            $member->type = 'project';
            $member->id   = $project->id;
 
            /* Move master to team table. */
            if(!empty($project->master))
            {
                $member->account = $project->master;
                $member->role    = 'role';
                $this->dao->replace(TABLE_TEAM)->data($member)->exec();
            }

            /* Move members to team table. */
            if(!empty($project->member))
            {
                $members = explode(',', $project->member);
                $member->role = 'member';
                foreach($members as $account)
                {
                    if($account == $project->master) continue;
                    if(!validater::checkAccount($account)) continue;

                    $member->account = $account;
                    $this->dao->replace(TABLE_TEAM)->data($member)->exec();
                }
            }

            return true;
        }
    }
}
