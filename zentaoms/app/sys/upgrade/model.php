<?php
/**
 * The model file of upgrade module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id: model.php 5019 2013-07-05 02:02:31Z wyd621@gmail.com $
 * @link        http://www.chanzhi.org
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
     * Security: can execute upgrade or not.
     * 
     * @access public
     * @return array  array('result' => success|fail, 'okFile');
     */
    public function canUpgrade()
    {
        $okFile = dirname($this->app->getDataRoot()) . DS . 'ok';
        if(!file_exists($okFile) or time() - filemtime($okFile) > 600)
        {
            return array('result' => 'fail', 'okFile' => $okFile);
        }

        return array('result' => 'success');
    }

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
            case '1_0': $this->execSQL($this->getUpgradeFile('1.0'));
            case '1_1': $this->execSQL($this->getUpgradeFile('1.1'));
            case '1_2': $this->execSQL($this->getUpgradeFile('1.2'));
            case '1_3': $this->execSQL($this->getUpgradeFile('1.3'));
            case '1_4': $this->execSQL($this->getUpgradeFile('1.4'));
            case '1_5': 
                $this->execSQL($this->getUpgradeFile('1.5'));
                $this->processTag();
            case '1_6':
                $this->execSQL($this->getUpgradeFile('1.6'));
                $this->setEnabledModules();
                $this->setFeaturedProducts();
            case '1_7':
                $this->execSQL($this->getUpgradeFile('1.7'));
                $this->moveBooks();
                $this->setMessageBlocks();
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
            case '1_0': $confirmContent .= file_get_contents($this->getUpgradeFile('1.0'));
            case '1_1': $confirmContent .= file_get_contents($this->getUpgradeFile('1.1'));
            case '1_2': $confirmContent .= file_get_contents($this->getUpgradeFile('1.2'));
            case '1_3': $confirmContent .= file_get_contents($this->getUpgradeFile('1.3'));
            case '1_4': $confirmContent .= file_get_contents($this->getUpgradeFile('1.4'));
            case '1_5': $confirmContent .= file_get_contents($this->getUpgradeFile('1.5'));
            case '1_6': $confirmContent .= file_get_contents($this->getUpgradeFile('1.6'));
            case '1_7': $confirmContent .= file_get_contents($this->getUpgradeFile('1.7'));
        }
        return str_replace(array('xr_', 'eps_'), $this->config->db->prefix, $confirmContent);
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
     * Unify keywords of article, product and category, count tag's rank and save.
     *
     * @access public
     * @return void
     */
    public function processTag()
    {
        $tags = '';

        $articles = $this->dao->select('id, keywords')->from(TABLE_ARTICLE)->fetchPairs('id', 'keywords');  
        foreach($articles as $id => $keywords)
        {
            $keywords = seo::unify($keywords, ',');
            $this->dao->update(TABLE_ARTICLE)->set('keywords')->eq($keywords)->where('id')->eq($id)->exec();
            $tags = $keywords;
        }

        $products = $this->dao->select('id, keywords')->from(TABLE_PRODUCT)->fetchPairs('id', 'keywords');  
        foreach($products as $id => $keywords)
        {
            $keywords = seo::unify($keywords, ',');
            $this->dao->update(TABLE_PRODUCT)->set('keywords')->eq($keywords)->where('id')->eq($id)->exec();
            $tags .= ',' . $keywords;
        }

        $categories = $this->dao->select('id, keywords')->from(TABLE_CATEGORY)->fetchPairs('id', 'keywords');  
        foreach($categories as $id => $keywords)
        {
            $keywords = seo::unify($keywords, ',');
            $this->dao->update(TABLE_CATEGORY)->set('keywords')->eq($keywords)->where('id')->eq($id)->exec();
            $tags .= ',' . $keywords;
        }

        $this->loadModel('tag')->save($tags);
    }

    /**
     * Set enabled modules when upgrade V1.6
     * 
     * @access public
     * @return void
     */
    public function setEnabledModules()
    {
       $modules = array(); 
       $blog  = $this->dao->select("count(*) as count")->from(TABLE_CATEGORY)->where('type')->eq('blog')->fetch('count');
       if($blog)  $modules[] = 'blog';

       $forum = $this->dao->select("count(*) as count")->from(TABLE_CATEGORY)->where('type')->eq('forum')->fetch('count');
       if($forum) 
       {
           $modules[] = 'forum';
           $modules[] = 'user';
       }

       $books = $this->loadModel('book')->getBookList();
       if(!empty($books))  $modules[] = 'book';

       $setting = new stdclass();
       $setting->moduleEnabled = join($modules, ',');
       return $this->loadModel('setting')->setItems('system.common.site', $setting);
    }

    /**
     * Set featured products when upgrade v1.6
     * 
     * @access public
     * @return void
     */
    public function setFeaturedProducts()
    {
        $this->loadModel('block');
        $homeBlocks = $this->block->getRegionBlocks('index_index', 'bottom');
        if(count($homeBlocks) > 3)  return false;
        $products = $this->dao->select("id,name")->from(TABLE_PRODUCT)->orderBy('id_desc')->limit(3)->fetchPairs('id', 'name');

        $blocks = $this->dao->select('blocks')->from(TABLE_LAYOUT)
            ->where('page')->eq('index_index')
            ->andWhere('region')->eq('bottom')
            ->fetch('blocks');
        $blocks = trim($blocks, ',');

        foreach($products as $id => $name)
        {
            $block = new stdclass();
            $block->type       = 'featuredProduct';
            $block->title      = $name;
            $params['product'] = $id;
            $block->content    = json_encode($params);
            $this->dao->insert(TABLE_BLOCK)->data($block)->exec();

            if(!dao::isError()) $blocks = $this->dao->lastInsertID() . ',' . $blocks;
        }

        $this->dao->update(TABLE_LAYOUT)->set('blocks')->eq($blocks)
            ->where('page')->eq('index_index')
            ->andWhere('region')->eq('bottom')
            ->exec();

        return true;
    }

    /**
     * Move books data.
     * 
     * @access public
     * @return void
     */
    public function moveBooks()
    {
        $books = $this->dao->select('*')->from(TABLE_CONFIG)
            ->where('owner')->eq('system')
            ->andWhere('module')->eq('common')
            ->andWhere('section')->eq('book')
            ->fetchAll('key');

        foreach($books as $code => $book)
        {
            $book = json_decode($book->value);
            $this->dao->insert(TABLE_BOOK)
                ->set('alias')->eq($code)
                ->set('title')->eq($book->name)
                ->set('grade')->eq(1)
                ->set('summary')->eq($book->summary)
                ->exec();
            
            $bookID     = $this->dao->lastInsertID();
            $catalogues = $this->dao->select('*')->from(TABLE_CATEGORY)->where('type')->eq('book_' . $code)->fetchAll('id');
            $chapters   = array();

            foreach($catalogues as $catalogue)
            {
                $chapter = new stdclass();
                $chapter->id         = $catalogue->id;
                $chapter->title      = $catalogue->name;
                $chapter->alias      = $catalogue->alias;
                $chapter->keywords   = $catalogue->keywords;
                $chapter->summary    = $catalogue->desc;
                $chapter->type       = 'chapter';
                $chapter->parent     = $catalogue->parent == 0 ? $bookID : $catalogue->parent;
                $chapter->grade      = $catalogue->grade + 1;
                $chapter->addedDate  = $catalogue->addedDate;
                $chapter->editedDate = $catalogue->editedDate;
                $chapter->order      = $catalogue->order;

                $paths = explode(',', $catalogue->path);
                foreach($paths as $key => $value) 
                {
                    if(empty($value)) unset($paths[$key]);
                }
                $chapter->path = ",{$bookID}," . join($paths, ',') . ',';

                $this->dao->insert(TABLE_BOOK)->data($chapter)->exec();
                $chapter->id = $this->dao->lastInsertID();

                $chapters[$catalogue->id] = $chapter;
            }

            $articles = $this->dao->select('*')->from(TABLE_ARTICLE)
                ->where('type')->eq('book_' . $code)
                ->fetchAll('id');

            foreach($articles as $origin)
            {
                $article = new stdclass();
                $article->title      = $origin->title;
                $article->alias      = $origin->alias;
                $article->author     = $origin->author;
                $article->keywords   = $origin->keywords;
                $article->summary    = $origin->summary;
                $article->content    = $origin->content;
                $article->type       = 'article';
                $article->parent     = $origin->parent == 0 ? $book->id : $origin->parent;
                $article->addedDate  = $origin->addedDate;
                $article->editedDate = $origin->editedDate;
                $article->order      = $origin->order;
                $article->views      = $origin->views;
                
                $category = $this->dao->select('*')->from(TABLE_RELATION)->where('type')->eq("book_{$code}")->andWhere('id')->eq($origin->id)->fetch('category');

                $article->parent = $chapters[$category]->id;
                $article->grade  = $chapters[$category]->grade + 1;
                $path = $chapters[$category]->path;
                $paths = explode(',', $path);
                foreach($paths as $key => $value)
                {
                    if(empty($value)) unset($paths[$key]);
                }

                $article->path   = ',' . join($paths, ',') . ',';

                $this->dao->insert(TABLE_BOOK)->data($article)->exec();
                $articleID = $this->dao->lastInsertID();
                $this->dao->update(TABLE_FILE)
                    ->set('objectType')->eq('book')
                    ->set('objectID')->eq($articleID)
                    ->where('objectType')->like('book_%')
                    ->andWhere('objectID')->eq($origin->id)
                    ->exec();
            }
        }

        $this->dao->update(TABLE_BOOK)->set("path=concat(',', id, ',')")->where('type')->eq('book')->exec();
        $this->dao->update(TABLE_BOOK)->set("path=concat(path, id, ',')")->where('type')->eq('article')->exec();

        $this->dao->delete()->from(TABLE_CONFIG)->where('owner')->eq('system')->andWhere('module')->eq('common')->andWhere('section')->eq('book')->exec();
        $this->dao->delete()->from(TABLE_ARTICLE)->where('type')->like('book_%')->exec();
        $this->dao->delete()->from(TABLE_CATEGORY)->where('type')->like('book_%')->exec();

        return true;
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
        return $this->app->getAppRoot() . 'db' . DS . 'upgrade' . $version . '.sql';
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

            $sql = str_replace(array('eps_', 'xr_'), $this->config->db->prefix, $sql);
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
     * Set blocks of message page.
     * 
     * @access public
     * @return bool
     */
    public function setMessageBlocks()
    {
        $id = $this->dao->select('id')->from(TABLE_BLOCK)->where('type')->eq('contact')->fetch('id');
        $this->dao->insert(TABLE_LAYOUT)->set('page')->eq('message_index')->set('region')->eq('side')->set('blocks')->eq($block)->exec();
        return !dao::isError();
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
}
