<?php
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

public function getPairs($dept = 0)
{
    return $this->dao->select('*')->from(TABLE_USER)
        ->where('1=1')
        ->beginIF($dept != 0)->andWhere('dept')->in($dept)->fi()
        ->orderBy('id_asc')
        ->fetchPairs('account', 'realname');
}
