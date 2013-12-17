<?php
public function checkPriv()
{
    $module = $this->app->getModuleName();
    $method = $this->app->getMethodName();

    if($this->isOpenMethod($module, $method)) return true;

    /* If no $app->user yet, go to the login pae. */
    if($this->app->user->account == 'guest')
    {
        $referer  = helper::safe64Encode($this->app->getURI(true));
        die(js::locate(helper::createLink('user', 'login', "referer=$referer")));
    }

    /* Check the priviledge. */
    if(!commonModel::hasPriv($module, $method)) $this->deny($module, $method);
}

public function isOpenMethod($module, $method)
{   
    if($module == 'misc'  and $method == 'ping') return true;
    if($module == 'sso'  and strpos(',auth|check', $method)) return true;

    return parent::isOpenMethod($module, $method);
}   
