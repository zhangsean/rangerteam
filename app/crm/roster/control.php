<?php
/**
 * The control file of roster module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     roster
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class roster extends control
{
    /** 
     * The index page, locate to the browse page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $this->locate(inlink('browse'));
    }

    /**
     * Browse contact.
     * 
     * @param string $orderBy     the order by
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function browse($mode = 'all', $origin = '',  $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        $this->loadModel('contact');
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $contacts = $this->contact->getList($customer = '', $relation = 'client', $mode, $status = 'wait', $origin, $orderBy, $pager);
        $this->session->set('contactQueryCondition', $this->dao->get());
        $this->session->set('contactList', $this->app->getURI(true));
        $this->session->set('customerList', $this->app->getURI(true));
        $this->app->user->canEditContactIdList = ',' . implode(',', $this->contact->getContactsSawByMe('edit', array_keys($contacts))) . ',';

        $customers = $this->loadModel('customer')->getPairs();

        /* Build search form. */
        $this->loadModel('search', 'sys');
        $this->config->contact->search['actionURL'] = $this->createLink('contact', 'browse', 'mode=bysearch');
        $this->config->contact->search['params']['t2.customer']['values'] = $customers;
        $this->search->setSearchParams($this->config->contact->search);

        $this->view->title     = $this->lang->contact->list;
        $this->view->mode      = $mode;
        $this->view->origin    = $origin;
        $this->view->contacts  = $contacts;
        $this->view->customers = $customers;
        $this->view->pager     = $pager;
        $this->view->orderBy   = $orderBy;
        $this->display();
    }   
}

