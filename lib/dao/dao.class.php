<?php
/**
 * ZenTaoPHP的dao和sql类。
 * The dao and sql class file of ZenTaoPHP framework.
 *
 * The author disclaims copyright to this source code.  In place of
 * a legal notice, here is a blessing:
 * 
 *  May you do good and not evil.
 *  May you find forgiveness for yourself and forgive others.
 *  May you share freely, never taking more than you give.
 */

helper::import(dirname(dirname(__FILE__)) . '/base/dao/dao.class.php');
/**
 * DAO类。
 * DAO, data access object.
 * 
 * @package framework
 */
class dao extends baseDAO
{
    /**
     * 获取查询记录条数。
     * 扩展该方法以适应groupBy和pager同时存在的情况
     * The count method, call sql::select() and from().
     * use as $this->dao->select()->from(TABLE_BUG)->where()->count();
     *
     * @param  string $distinctField 
     * @access public
     * @return void
     */
    public function count($distinctField = '')
    {
        /* 获得SELECT，FROM的位置，使用count(*)替换其字段。 */
        /* Get the SELECT, FROM position, thus get the fields, replace it by count(*). */
        $sql     = $this->get();
        $fromPOS = strpos($sql, 'FROM');
        $sql     = "SELECT SQL_CALC_FOUND_ROWS * " . substr($sql, $fromPOS);
        self::$querys[] = $sql;

        /* 
         * 获取记录数。
         * Get the records count.
         **/
        try
        {
            $this->dbh->query($sql);
            $result = $this->dbh->query("SELECT FOUND_ROWS() as rowCount")->fetch(PDO::FETCH_OBJ);
        }
        catch (PDOException $e) 
        {
            $this->sqlError($e);
        }

        return $result->rowCount;
    }
}

/**
 * SQL类。
 * The SQL class.
 * 
 * @package framework
 */
class sql extends baseSQL
{
    /**
     * 创建ORDER BY部分。
     * Create the order by part.
     * 
     * @param  string $order 
     * @access public
     * @return object the sql object.
     */
    public function orderBy($order)
    {
        if(strpos($order, 'convert(') !== false)
        {
            if($this->inCondition and !$this->conditionIsTrue) return $this;

            $order = str_replace(array('|', '', '_'), ' ', $order);
            $this->sql .= ' ' . DAO::ORDERBY . " $order";
            return $this;
        }
        else
        {
            return parent::orderBy($order);
        }
    }
}
