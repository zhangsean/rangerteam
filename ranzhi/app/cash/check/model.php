<?php
/**
 * The model file of check module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     contact
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
class checkModel extends model
{
    /**
     * compute 
     * 
     * @param  int    $depositorID 
     * @access public
     * @return void
     */
    public function compute($depositorID = 0, $start = '', $end = '')
    {
        if($depositorID)
        {
            $depositor = $this->loadModel('depositor')->getByID($depositorID);
            if(empty($depositor)) return false;
            $depositorList = array($depositorID => $depositor);
        }
        else
        {
            $depositorList = $this->loadModel('depositor')->getList();
        }
        
        $depositorIdList = array_keys($depositorList);

        $balances = $this->dao->select('*')->from(TABLE_BALANCE)
            ->where('depositor')->in($depositorIdList)
            ->andWhere('date')->in("{$start}, {$end}")
            ->fetchGroup('depositor', 'date');

        $tradeList = $this->dao->select('*')->from(TABLE_TRADE)
            ->where('depositor')->in($depositorIdList)
            ->andWhere('date')->gt($start)
            ->andWhere('date')->lt($end)
            ->fetchGroup('depositor', 'id');

        foreach($depositorList as $id => $depositor)
        {
            $depositor->origin   = isset($balances[$id][$start]) ? $balances[$id][$start]->money : 0;
            $depositor->computed = $depositor->origin + $this->computeTrades($tradeList, $id);
            $depositor->actual   = isset($balances[$id][$end]) ? $balances[$id][$end]->money : 0;
        }

        return $depositorList;
    }

    /**
     * Compute Trades.
     * 
     * @param  int    $tradeList 
     * @param  int    $depositorID 
     * @access public
     * @return void
     */
    public function computeTrades($tradeList, $depositorID)
    {
        $money = 0;

        if(isset($tradeList[$depositorID]))
        {
            foreach($tradeList[$depositorID] as $item)
            {
                if($item->type == 'in')    $money += $item->money;    
                if($item->type == 'out')   $money -= $item->money;    
            }
        }

        return $money;
    }
}
