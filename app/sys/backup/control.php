<?php
/**
 * The control file of backup of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     backup
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class backup extends control
{
    /**
     * __construct 
     * 
     * @access public
     * @return void
     */
    public function __construct($moduleName = '', $methodName = '')
    {
        parent::__construct($moduleName, $methodName);

        $this->backupPath = $this->app->getTmpRoot() . 'backup/';
        if(!is_dir($this->backupPath))
        {
            if(!mkdir($this->backupPath, 0777, true)) $this->view->error = sprintf($this->lang->backup->error->noWritable, dirname($this->backupPath));
        }
        else
        {
            if(!is_writable($this->backupPath)) $this->view->error = sprintf($this->lang->backup->error->noWritable, $this->backupPath);
        }
    }

    /**
     * Index 
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $backups = array();
        if(empty($this->view->error))
        {
            $sqlFiles = glob("{$this->backupPath}*.sql.php");
            if(!empty($sqlFiles))
            {
                foreach($sqlFiles as $file)
                {
                    $backupFile = new stdclass();
                    $backupFile->time  = filemtime($file);
                    $backupFile->name  = str_replace('.sql.php', '', basename($file));
                    $backupFile->files[$file] = filesize($file);
                    if(file_exists($this->backupPath . $backupFile->name . '.file.zip.php'))
                    {
                        $backupFile->files[$this->backupPath . $backupFile->name . '.file.zip.php'] = filesize($this->backupPath . $backupFile->name . '.file.zip.php');
                    }

                    $backups[$backupFile->name] = $backupFile;
                }
            }
        }
        krsort($backups);

        $this->view->title      = $this->lang->backup->common;
        $this->view->position[] = $this->lang->backup->common;
        $this->view->backups    = $backups;
        $this->display();
    }

    /**
     * Backup 
     * 
     * @access public
     * @return void
     */
    public function backup()
    {
        set_time_limit(0);
        $fileName = date('YmdHis') . mt_rand(0, 9);
        $result = $this->backup->backSQL($this->backupPath . $fileName . '.sql.php');
        if(!$result->result)
        {
            die(js::alert(sprintf($this->lang->backup->error->noWritable, $this->backupPath)) . js::locate(inlink('index')));
        }
        $this->backup->addFileHeader($this->backupPath . $fileName . '.sql.php');

        if(extension_loaded('zlib'))
        {
            $result = $this->backup->backFile($this->backupPath . $fileName . '.file.zip.php');
            if(!$result->result)
            {
                die(js::alert(sprintf($this->lang->backup->error->backupFile, $result->error)) . js::locate(inlink('index')));
            }
            $this->backup->addFileHeader($this->backupPath . $fileName . '.file.zip.php');
        }

        die(js::alert($this->lang->backup->success->backup) . js::locate(inlink('index')));
    }

    /**
     * Restore 
     * 
     * @param  string $fileName 
     * @param  string $confirm 
     * @access public
     * @return void
     */
    public function restore($fileName, $confirm = 'no')
    {
        if($confirm == 'no')
        {
            die(js::confirm($this->lang->backup->confirmRestore, inlink('restore', "fileName=$fileName&confirm=yes"), inlink('index'), 'self'));
        }

        set_time_limit(0);

        /* Restore database. */
        $this->backup->removeFileHeader($this->backupPath . $fileName . '.sql.php');
        $result = $this->backup->restoreSQL($this->backupPath . $fileName . '.sql.php');
        $this->backup->addFileHeader($this->backupPath . $fileName . '.sql.php');
        if(!$result->result)
        {
            echo js::alert(sprintf($this->lang->backup->error->restoreSQL, $result->error));
            die(js::locate(inlink('index')));
        }

        /* Restore attatchments. */
        if(file_exists($this->backupPath . $fileName . '.file.zip.php'))
        {
            $this->backup->removeFileHeader($this->backupPath . $fileName . '.file.zip.php');
            $result = $this->backup->restoreFile($this->backupPath . $fileName . '.file.zip.php');
            $this->backup->addFileHeader($this->backupPath . $fileName . '.file.zip.php');
            if(!$result->result)
            {
                echo js::alert(sprintf($this->lang->backup->error->restoreFile, $result->error));
                die(js::locate(inlink('index')));
            }
        }
        echo js::alert($this->lang->backup->success->restore);
        die(js::locate(inlink('index')));
    }

    /**
     * Delete 
     * 
     * @param  string $fileName 
     * @param  string $confirm 
     * @access public
     * @return void
     */
    public function delete($fileName)
    {
        /* Delete database file. */
        if(file_exists($this->backupPath . $fileName . '.sql.php') and !unlink($this->backupPath . $fileName . '.sql.php'))
        {
            $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->noDelete, $this->backupPath . $fileName . '.sql.php')));
        }

        /* Delete attatchments file. */
        if(file_exists($this->backupPath . $fileName . '.file.zip.php') and !unlink($this->backupPath . $fileName . '.file.zip.php'))
        {
            $this->send(array('result' => 'fail', 'mesage' => sprintf($this->lang->backup->error->noDelete, $this->backupPath . $fileName . '.file.zip.php')));
        }

        $this->send(array('result' => 'success'));
    }
}
