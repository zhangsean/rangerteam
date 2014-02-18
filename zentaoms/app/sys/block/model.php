<?php
/**
 * The model file of block module of ZenTaoMS.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件，非开源软件
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class blockModel extends model
{
    /**
     * Save params 
     * 
     * @param  int    $index 
     * @param  string $type 
     * @access public
     * @return void
     */
    public function save($index, $type)
    {
        $account = $this->app->user->account;
        $data    = fixer::input('post')->get();

        $data->type = $type;

        $this->loadModel('setting')->setItem($account . '.sys.index.block.b' . $index, json_encode($data));
    }

    /**
     * Get content for entry block.
     * 
     * @param  object    $block 
     * @access public
     * @return string
     */
    public function getEntry($block)
    {
        if(empty($block)) return false;
        $entry = $this->loadModel('entry')->getById($block->entryID);
        $http  = $this->app->loadClass('http');

        $block->params->account = $this->app->user->account;
        $block->params->uid     = $this->app->user->id;
        $params = base64_encode(json_encode($block->params));

        $query['mode']    = 'getblockdata';
        $query['blockid'] = $block->blockID;
        $query['param']   = $params;
        $query['hash']    = $entry->key;
        $query['lang']    = $this->app->getClientLang();
        $query['sso']     = base64_encode(commonModel::getSysURL() . helper::createLink('entry', 'visit', "entry=$entry->id"));

        $parseUrl = parse_url($entry->block);
        $query    = http_build_query($query);
        $parseUrl['query'] = empty($parseUrl['query']) ? $query : $parseUrl['query'] . "&" . $query;

        $link = '';
        if(!isset($parseUrl['scheme'])) 
        {
            $link  = commonModel::getSysURL() . $parseUrl['path'];
            $link .= '?' . $parseUrl['query'];
        }
        else
        {
            $link .= $parseUrl['scheme'] . '://' . $parseUrl['host'];
            if(isset($parseUrl['port'])) $link .= ':' . $parseUrl['port']; 
            if(isset($parseUrl['path'])) $link .= $parseUrl['path']; 
            $link .= '?' . $parseUrl['query'];
        }

        return $http->get($link);
    }

    /**
     * Get content when type is rss 
     * 
     * @param  object    $block 
     * @access public
     * @return string
     */
    public function getRss($block)
    {
        if(empty($block)) return false;
        $http = $this->app->loadClass('http');

        $xml = $http->get(htmlspecialchars_decode($block->params->link));

        $xpc = xml_parser_create();
        xml_parse_into_struct($xpc, $xml, $values);
        xml_parser_free($xpc);

        $channelTags   = array();
        $itemTags      = array();
        $inItem        = false;
        foreach($values as $value)
        {
            $tag = strtolower($value['tag']);
            if($value['tag'] == 'ITEM' and $value['type'] == 'open')  $inItem = true;
            if($value['tag'] == 'ITEM' and $value['type'] == 'close') $inItem = false;

            /* The level of text node is 3 in channel. */
            if(!$inItem and $value['type'] == 'complete' and $value['level'] == 3) $channelTags[$tag] = isset($value['value']) ? $value['value'] : '';
            /* The level of text node is 4 in item. */
            if($inItem  and $value['type'] == 'complete' and $value['level'] == 4) $itemTags[$tag][]  = isset($value['value']) ? $value['value'] : '';
        }

        $maxNum = $block->params->num == 0 ? count(current($itemTags)) : $block->params->num;
        $html   = "<div class='list-group'>";
        for($i = 0; $i < $maxNum; $i++)
        {
            $title = '';
            foreach(array_keys($itemTags) as $tag)
            {
                if($tag == 'title')
                {
                    $title = $itemTags[$tag][$i];
                }
                elseif($tag == 'pubdate')
                {
                    $time = date('n-j H:s',strtotime($itemTags[$tag][$i]));
                    $html .= "<a class='list-group-item' target='_blank' href='{$itemTags['link'][$i]}'><small class='text-muted pull-right'>{$time}</small><h5 class='list-group-item-heading small text-ellipsis'>{$title}</h5></a>";
                }
            }
        }

        return $html . '</div>';
    }

    /**
     * Get saved block config.
     * 
     * @param  int    $index 
     * @access public
     * @return object
     */
    public function getBlock($index)
    {
        return isset($this->config->personal->index->block->{'b' . $index}->value) ? json_decode($this->config->personal->index->block->{'b' . $index}->value) : array();
    }
}
