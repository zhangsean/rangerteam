<?php
/**
 * The article category zh-cn file of RanZhi.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id: zh-cn.php 4029 2016-08-26 06:50:41Z liugang $
 * @link        http://www.ranzhico.com
 */
$lang->article->common      = '文章维护';
$lang->article->createDraft = '保存草稿';

$lang->article->id          = '编号';
$lang->article->category    = '类目';
$lang->article->categories  = '类目';
$lang->article->title       = '标题';
$lang->article->alias       = '别名';
$lang->article->content     = '内容';
$lang->article->original    = '来源';
$lang->article->copySite    = '来源网站';
$lang->article->copyURL     = '来源URL';
$lang->article->keywords    = '关键字';
$lang->article->summary     = '摘要';
$lang->article->author      = '作者';
$lang->article->editor      = '编辑';
$lang->article->createdDate = '添加时间';
$lang->article->editedDate  = '编辑时间';
$lang->article->status      = '状态';
$lang->article->type        = '类型';
$lang->article->views       = '阅读';
$lang->article->stick       = '置顶级别';
$lang->article->order       = '排序';
$lang->article->private     = '设为私密';
$lang->article->users       = '授权用户';
$lang->article->groups      = '授权分组';
$lang->article->readers     = '已阅读用户';

$lang->article->list        = '文章列表';
$lang->article->admin       = '维护文章';
$lang->article->create      = '发布文章';
$lang->article->edit        = '编辑文章';
$lang->article->files       = '附件';

if(!isset($lang->blog)) $lang->blog = new stdclass();
$lang->blog->admin  = '维护博客';
$lang->blog->list   = '博客列表';
$lang->blog->create = '发布博客';
$lang->blog->edit   = '编辑博客';

if(!isset($lang->announce)) $lang->announce = new stdclass();
$lang->announce->admin  = '维护公告';
$lang->announce->list   = '公告列表';
$lang->announce->create = '发布公告';
$lang->announce->edit   = '编辑公告';

$lang->page = new stdclass();
$lang->page->admin  = '维护单页';
$lang->page->list   = '单页列表';
$lang->page->create = '添加单页';
$lang->page->edit   = '编辑单页';

$lang->article->originalList[1] = '原创';
$lang->article->originalList[0] = '转贴';

$lang->article->statusList['draft']  = '草稿';
$lang->article->statusList['normal'] = '正常';

$lang->article->confirmDelete = '您确定删除该文章吗？';

$lang->article->lblAddedDate = '<strong>添加时间：</strong> %s &nbsp;&nbsp;';
$lang->article->lblAuthor    = "<strong>作者：</strong> %s &nbsp;&nbsp;";
$lang->article->lblSource    = '<strong>来源：</strong>';
$lang->article->lblViews     = '<strong>阅读：</strong>%s';
$lang->article->lblEditor    = '<i>最后编辑：%s 于 %s</i>';
$lang->article->lblReaders   = '%s人已阅读';

$lang->article->prev      = '上一篇';
$lang->article->next      = '下一篇';
$lang->article->none      = '没有了';
$lang->article->directory = '返回目录';
$lang->article->back2Top  = '返回顶部';

$lang->article->note = new stdclass();
$lang->article->note->createdDate = '可以延迟到选定的时间发布。';
