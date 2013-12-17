<?php
/**
 * The model file of forum category of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     forum
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class forumModel extends model
{
    /**
     * Get boards.
     * 
     * @access public
     * @return array
     */
    public function getBoards()
    {
        $boards = array();
        $rawBoards = $this->dao->select('*')
            ->from(TABLE_CATEGORY)
            ->where('type')->eq('forum')
            ->orderBy('grade, `order`')
            ->fetchGroup('parent');
        if(!isset($rawBoards[0])) return $boards;

        foreach($rawBoards[0] as $parentBoard)
        {
            if(isset($rawBoards[$parentBoard->id]))
            {
                $parentBoard->children = $rawBoards[$parentBoard->id];
                foreach($parentBoard->children as $childBoard) 
                {
                    $childBoard->lastPostReplies = isset($replies[$childBoard->postID]) ? $replies[$childBoard->postID] : 0;
                }
                $boards[] = $parentBoard;
            }
        }

        return $boards;
    }

    /**
     * Update stats of forum.
     * 
     * @access public
     * @return void
     */
    public function updateStats()
    {
        $boards = $this->dao->select('id')->from(TABLE_CATEGORY)->where('grade')->eq(2)->andWhere('type')->eq('forum')->fetchAll();
        foreach($boards as $board) $this->updateBoardStats($board->id);
    }

    /**
     * Update status of boards.
     * 
     * @param  int    $boardID 
     * @access public
     * @return void
     */
    public function updateBoardStats($boardID)
    {
        /* Get threads and replies. */
        $stats = $this->dao->select('COUNT(id) as threads, SUM(replies) as replies')->from(TABLE_THREAD)
            ->where('board')->eq($boardID)
            ->andWhere('hidden')->eq('0')
            ->fetch();

        /* Get postID and replyID. */
        $post = $this->dao->select('id as postID, replyID, repliedDate as postedDate, repliedBy, author')->from(TABLE_THREAD)
            ->where('hidden')->eq('0')
            ->orderBy('repliedDate desc')
            ->limit(1)
            ->fetch();

        $data = new stdclass();
        $data->threads    = $stats->threads;
        $data->posts      = $stats->threads + $stats->replies;
        $data->postID     = $post->postID;
        $data->replyID    = $post->replyID;
        $data->postedDate = $post->postedDate;
        $data->postedBy   = $post->repliedBy ? $post->repliedBy : $post->author;

        $this->dao->update(TABLE_CATEGORY)->data($data)->where('id')->eq($boardID)->exec();
    }

    /**
     * Judge a board is new or not.
     * 
     * @param string $board 
     * @access public
     * @return void
     */
    public function isNew($board)
    {
        return (time() - strtotime($board->postedDate)) < 24 * 60 * 60 * $this->config->forum->newDays;
    }

    /**
     * Judge a user can post thread to a board or not.
     * 
     * @param  object    $board 
     * @access public
     * @return void
     */
    public function canPost($board)
    {
        /* If the board is an open one, return true. */
        if($board->readonly == false) return true;

        /* Then check the user is admin or not. */
        if($this->app->user->admin == 'super') return true; 

        /* Then check the user is a moderator or not. */
        $user = ",{$this->app->user->account},";
        $moderators = ',' . str_replace(' ', '', $board->moderators) . ',';
        if(strpos($moderators, $user) !== false) return true;

        return false;
    }
}
