<?php
/**
 * The setbasic view file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      xiying Guang <guanxiying@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php foreach($lang->user->oauth->providers as $providerCode => $providerName):?>
<?php $oauth = json_decode($this->config->oauth->$providerCode);?>
<form method='post' id="<?php echo $providerCode;?>AjaxForm">
  <table class='table table-form'>
    <caption><?php echo $providerName;?><span class='pull-right mr-10px'><?php echo html::a("http://www.chanzhi.org/help-read-23.html", $lang->site->oauthHelp, "target='_blank'");?></span></caption> 
    <tr>
      <th class='w-100px'><?php echo $lang->user->oauth->verification;?></th> 
      <td><?php echo html::input('verification', $oauth->verification, "class='text-5'");?></td> 
    </tr>
    <tr>
      <th class='w-100px'><?php echo $lang->user->oauth->clientID;?></th> 
      <td><?php echo html::input('clientID', $oauth->clientID, "class='text-5'");?></td> 
    </tr>
    <tr>
      <th><?php echo $lang->user->oauth->clientSecret;?></th> 
      <td><?php echo html::input('clientSecret', $oauth->clientSecret, "class='text-5'");?></td> 
    </tr>
    <?php if($providerCode == 'sina'):?>
    <tr>
      <th class='w-100px'><?php echo $lang->user->oauth->widget;?></th> 
      <td><?php echo html::input('widget', $oauth->widget, "class='text-5'");?></td> 
    </tr>
    <?php endif;?>
    <tr>
      <th></th>
      <td><?php echo html::submitButton() . html::hidden('provider', $providerCode);?></td>
    </tr>
  </table>
</form>
<?php endforeach;?>

<?php include '../../common/view/footer.admin.html.php';?>
