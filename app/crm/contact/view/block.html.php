<?php 
/**
 * The contact List block file of contact module of RanZhi.
 *
 * @copyright   Copyright 2013-2014 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     common 
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php foreach($contacts as $contact):?>
<div class='panel' <?php if($contact->left) echo "title='" . sprintf($lang->contact->leftAt, $contact->left) . "'";?>>
  <table class='table table-bordered table-contact'>
    <tr>
      <th class='w-120px text-center alert v-middle'>
        <?php $class = $contact->maker ? "class='text-red'" : "";?>
        <span class='lead'><?php echo html::a($this->createLink('contact', 'view', "contactID=$contact->id"), $contact->realname, $class);?></span>
        <?php if($contact->left):?>
        <span ><i class='icon-lock text-muted'></i></span>
        <?php endif;?>
        <div><?php echo $contact->dept . ' ' . $contact->title;?></div>
      </th>
      <td>
        <div class='text-right'>
          <i class='btn-vcard icon icon-qrcode icon-large text-info'> </i>
        </div>
        <div class='contact-info'>
          <?php if($contact->phone or $contact->mobile) echo "<div><i class='icon-phone-sign'></i> $contact->phone $contact->mobile</div>";?>
          <?php if($contact->qq) echo "<div class='f-14'><i class='icon-qq'></i> " . html::a("http://wpa.qq.com/msgrd?v=3&uin={$contact->qq}&site={$config->company->name}&menu=yes", $contact->qq, "target='_blank'") . "</div>";?>
          <?php if($contact->email) echo "<div class='f-14'><i class='icon-envelope-alt'></i> " . html::mailto($contact->email, $contact->email) . "</div>";?>
        </div>
        <p class='vcard text-center'><?php echo html::image(helper::createLink('contact', 'vcard', "contactID={$contact->id}"), "style='height:120px'");?></p>
      </td>
    </tr>
  </table>
</div>
<?php endforeach;?>
<?php if(isset($pageJS)) js::execute($pageJS);?>
