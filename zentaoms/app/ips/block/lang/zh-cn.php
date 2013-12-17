<?php
/**
 * The block module zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->block->common     = '区块维护';
$lang->block->id         = '编号';
$lang->block->title      = '名称';
$lang->block->limit      = '数量';
$lang->block->type       = '类型';
$lang->block->code       = '代码';
$lang->block->content    = '内容';
$lang->block->page       = '页面';
$lang->block->regionList = '区域列表';
$lang->block->select     = '请选择区块';
$lang->block->categories = '分类';
$lang->block->showImage  = '显示图片';
$lang->block->product    = '产品';

$lang->block->add          = "添加";
$lang->block->create       = '添加区块';
$lang->block->browseBlocks = '区块列表';
$lang->block->browseRegion = '布局设置';
$lang->block->edit         = '编辑区块';
$lang->block->view         = '查看区块';
$lang->block->setPage      = '配置页面';

$lang->block->typeList['html']     = '自定义区块';
$lang->block->typeList['code']     = '源代码';

$lang->block->typeList['latestArticle']   = '最新文章';
$lang->block->typeList['hotArticle']      = '热门文章';

$lang->block->typeList['latestProduct']   = '最新产品';
$lang->block->typeList['featuredProduct'] = '首页推荐产品';
$lang->block->typeList['hotProduct']      = '热门产品';

$lang->block->typeList['articleTree']     = '文章分类';
$lang->block->typeList['productTree']     = '产品分类';
$lang->block->typeList['blogTree']        = '博客分类';

$lang->block->typeList['contact']         = '联系我们';
$lang->block->typeList['about']           = '公司简介';
$lang->block->typeList['links']           = '友情链接';
$lang->block->typeList['slide']           = '幻灯片';

$lang->block->typeGroups = array();
$lang->block->typeGroups['html'] = 'input';
$lang->block->typeGroups['code'] = 'input';

$lang->block->typeGroups['latestArticle'] = 'article';
$lang->block->typeGroups['hotArticle']    = 'article';

$lang->block->typeGroups['latestProduct']   = 'product';
$lang->block->typeGroups['featuredProduct'] = 'product';
$lang->block->typeGroups['hotProduct']      = 'product';

$lang->block->typeGroups['articleTree'] = 'category';
$lang->block->typeGroups['productTree'] = 'category';
$lang->block->typeGroups['blogTree']    = 'category';

$lang->block->typeGroups['contact'] = 'system';
$lang->block->typeGroups['about']   = 'system';
$lang->block->typeGroups['links']   = 'system';
$lang->block->typeGroups['slide']   = 'system';

$lang->block->category = new stdclass();
$lang->block->category->showChildren = '显示子分类';

$lang->block->category->showChildrenList[1] = '是';
$lang->block->category->showChildrenList[0] = '否';

$lang->block->pages['all']            = '全部页面';
$lang->block->pages['index_index']    = '首页';

$lang->block->pages['article_browse'] = '文章列表页面';
$lang->block->pages['article_view']   = '文章详情页面';

$lang->block->pages['product_browse'] = '产品列表页面';
$lang->block->pages['product_view']   = '产品详情页面';

$lang->block->pages['blog_index']     = '博客列表页面';
$lang->block->pages['blog_view']      = '博客详情页面';

$lang->block->pages['forum_index']    = '论坛首页';
$lang->block->pages['forum_board']    = '帖子列表页面';
$lang->block->pages['thread_view']    = '帖子察看页面';
$lang->block->pages['search_list']    = '搜索结果页';

$lang->block->pages['book_index']     = '手册中心';
$lang->block->pages['book_browse']    = '手册首页';
$lang->block->pages['book_read']      = '手册章节';

$lang->block->pages['message_index']  = '留言';

$lang->block->pages['page_view']      = '页面';

/* page layout list. */
$lang->block->regions = new stdclass();
$lang->block->regions->all['header'] = '头部';
$lang->block->regions->all['footer'] = '底部';
$lang->block->regions->all['end']    = '结束部分';

$lang->block->regions->index_index['header']  = '上部';
$lang->block->regions->index_index['bottom']  = '下部';
$lang->block->regions->index_index['footer']  = '底部';
$lang->block->regions->article_browse['side'] = '侧边';
$lang->block->regions->article_view['side']   = '侧边';
$lang->block->regions->product_browse['side'] = '侧边';
$lang->block->regions->product_view['side']   = '侧边';
$lang->block->regions->message_index['side']  = '侧边';
$lang->block->regions->page_view['side']      = '侧边';
