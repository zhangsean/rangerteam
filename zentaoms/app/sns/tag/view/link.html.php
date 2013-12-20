<?php
/**
 * The link magange view file of tag of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan<guanxiying@xirangit.com>
 * @package     tag
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<div class='bg-white radius'>
  <form id='ajaxForm' action='<?php echo inlink('link', "tageID={$tag->id}")?>'  method='post'>
    <table class='table table-form'>
      <caption><?php echo $lang->tag->editLink;?></caption>
      <tr>
        <th><?php echo $tag->tag;?></th>
        <td><?php echo html::input('link', $tag->link, "class='text-1' placeholder='{$lang->tag->inputLink}'");?></td>
      </tr>
      <tr><td colspan='2' class='a-center'><?php echo html::submitButton();?></td></tr>
    </table>
  </form>
</div>
<?php if(isset($pageJS)) js::execute($pageJS);?>
