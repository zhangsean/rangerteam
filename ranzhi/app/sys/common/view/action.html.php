<?php
/**
 * The action view of common module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     common 
 * @version     $Id: chosen.html.php 7417 2013-12-23 07:51:50Z wwccss $
 * @link        http://www.ranzhi.org
 */
?>
<script language='Javascript'>
var fold   = '<?php echo $lang->fold;?>';
var unfold = '<?php echo $lang->unfold;?>';
function switchChange(historyID)
{
    changeClass = $('#switchButton' + historyID).attr('class');
    if(changeClass.indexOf('change-show') > 0)
    {
        $('#switchButton' + historyID).attr('class', changeClass.replace('change-show', 'change-hide'));
        $('#changeBox' + historyID).show();
        $('#changeBox' + historyID).prev('.changeDiff').show();
    }
    else
    {
        $('#switchButton' + historyID).attr('class', changeClass.replace('change-hide', 'change-show'));
        $('#changeBox' + historyID).hide();
        $('#changeBox' + historyID).prev('.changeDiff').hide();
    }
}

function toggleStripTags(obj)
{
    var diffClass = $(obj).attr('class');
    if(diffClass.indexOf('diff-all') > 0)
    {
        $(obj).attr('class', diffClass.replace('diff-all', 'diff-short'));
        $(obj).attr('title', '<?php echo $lang->action->textDiff?>');
    }
    else
    {
        $(obj).attr('class', diffClass.replace('diff-short', 'diff-all'));
        $(obj).attr('title', '<?php echo $lang->action->original?>');
    }
    var boxObj  = $(obj).next();
    var oldDiff = '';
    var newDiff = '';
    $(boxObj).find('blockquote').each(function(){
        oldDiff = $(this).html();
        newDiff = $(this).next().html();
        $(this).html(newDiff);
        $(this).next().html(oldDiff);
    })
}

function toggleShow(obj)
{
    var orderClass = $(obj).find('span').attr('class');
    if(orderClass == 'change-show')
    {
        $(obj).find('span').attr('class', 'change-hide');
    }
    else
    {
        $(obj).find('span').attr('class', 'change-show');
    }
    $('.changes').each(function(){
        var switchButtonID = $(this).closest('li').find('button[id^="switchButton"]').attr('id');
        switchChange(switchButtonID.replace('switchButton', ''));
    })
}

function toggleOrder(obj)
{
    var orderClass = $(obj).find('span').attr('class');
    if(orderClass == 'log-asc')
    {
        $(obj).find('span').attr('class', 'log-desc');
    }
    else
    {
        $(obj).find('span').attr('class', 'log-asc');
    }
    $("#historyItem li").reverseOrder();
}

function toggleComment(actionID)
{
    $('.comment' + actionID).toggle();
    $('#lastCommentBox').toggle();
}

$(function(){
    var diffButton = "<span onclick='toggleStripTags(this)' class='hidden changeDiff diff-all hand' title='<?php echo $lang->action->original?>'></span>";
    var newBoxID = ''
    var oldBoxID = ''
    $('blockquote').each(function(){
        newBoxID = $(this).parent().attr('id');
        if(newBoxID != oldBoxID) 
        {
            oldBoxID = newBoxID;
            if($(this).html() != $(this).next().html()) $(this).parent().before(diffButton);
        }
    });
    $.setAjaxForm('#ajaxFormComment');
})
</script>
<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<script src='<?php echo $jsRoot;?>jquery/reverseorder/raw.js' type='text/javascript'></script>

<div id='actionbox' class='panel'>
  <div class='panel-heading'>
    <i class='icon-time'></i> <?php echo $lang->history?>
    <div class='panel-actions'>
      <button class='btn btn-mini' onclick='toggleOrder(this)' class='hand'> <?php echo "<span title='$lang->reverse' class='log-asc'></span>";?></button>
      <button class='btn btn-mini' onclick='toggleShow(this);' class='hand'><?php echo "<span title='$lang->switchDisplay' class='change-show'></span>";?></button>
    </div>
    <div class='panel-actions pull-right'>
      <?php echo html::a($this->createLink('sys.action', 'createRecord', "objectType=order&objectID={$objectID}&customer={$customer}"), '<i class="icon-plus"></i> ' . $lang->action->record->create, "class='btn btn-primary btn-sm' data-toggle='modal'");?>
    </div>
  </div>
  <div class='panel-body'>
    <ol id='historyItem'>
      <?php $i = 1; ?>
      <?php foreach($actions as $action):?>
      <?php $canEditComment = ($action->action != 'record' and end($actions) == $action and $action->comment and $this->methodName == 'view' and $action->actor == $this->app->user->account);?>
      <li value='<?php echo $i ++;?>'>
      <?php
      if(isset($users[$action->actor])) $action->actor = $users[$action->actor];
      if($action->action == 'assigned' and isset($users[$action->extra]) ) $action->extra = $users[$action->extra];
      if(strpos($action->actor, ':') !== false) $action->actor = substr($action->actor, strpos($action->actor, ':') + 1);
      ?>
      <span>
        <?php $this->action->printAction($action);?>
        <?php if(!empty($action->history)) echo "<button id='switchButton$i' class='hand change-show btn btn-mini' onclick=switchChange($i)></button>";?>
      </span>
      <?php if(!empty($action->comment) or !empty($action->history)):?>
      <?php if(!empty($action->comment)) echo "<div class='history'>";?>
        <div class='changes' id='changeBox<?php echo $i;?>' style='display:none;'>
        <?php echo $this->action->printChanges($action->objectType, $action->history);?>
        </div>
        <?php if($canEditComment):?>
        <span class='link-button pull-right comment<?php echo $action->id;?>'><?php echo html::a('#lastCommentBox', '<i class="icon-edit-sign icon-large"></i>', "onclick='toggleComment($action->id)'")?></span>
        <?php endif;?>
        <?php if($action->action == 'record'):?>
        <span class='link-button pull-right'><?php echo html::a($this->createLink('action', 'editRecord', "id={$action->id}"), '<i class="icon-edit-sign icon-large"></i>', "data-toggle='modal'")?></span>
        <?php endif;?>

        <?php 
        if($action->comment) 
        {
            echo "<div class='comment$action->id'>";
            echo strip_tags($action->comment) == $action->comment ? nl2br($action->comment) : $action->comment; 
            echo "</div>";
        }
        ?>
        <?php if($canEditComment):?>
        <div id='lastCommentBox' style='display:none'>
          <form method='post' id='ajaxFormComment' action='<?php echo $this->createLink('action', 'editComment', "actionID=$action->id")?>'>
            <p><?php echo html::textarea('lastComment', $action->comment);?></p>
            <p><?php echo html::submitButton() . html::commonButton($lang->goback, 'btn btn-default', "onclick='toggleComment($action->id)'");?></p>
          </form>
        </div>
        <?php endif;?>

        <?php if(!empty($action->comment)) echo "</div>";?>
      <?php endif;?>
      </li>
      <?php endforeach;?>
    </ol>
  </div>
</div>
