<?php
/**
 * The model file of my module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     my
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class myModel extends model
{
    public function createModuleMenu($method)
    {
        if(!isset($this->lang->my->$method->menu)) return false;

        $string = "<nav id='menu'><ul class='nav'>\n";

        /* Get menus of current module and current method. */
        $moduleMenus = $this->lang->my->$method->menu;  

        /* Cycling to print every menus of current module. */
        foreach($moduleMenus as $methodName => $methodMenu)
        {
            /* Split the methodMenu to label, module, method, vars. */
            list($label, $module, $method, $vars) = explode('|', $methodMenu);

            if(commonModel::hasPriv($module, $method))
            {
                $string .= "<li>" . html::a(helper::createLink($module, $method, $vars), $label) . "</li>\n";
            }
        }

        $string .= "</ul>\n";
        return $string;
    }
}
