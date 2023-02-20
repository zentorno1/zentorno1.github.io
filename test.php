<?php
namespace app\forms;

use php\jsoup\Element;
use std, gui, framework, app;


class test extends AbstractForm
{

    /**
     * @event showing 
     */
    function doShowing(UXWindowEvent $e = null)
    {    
        $this->form('Developer')->label->text = '123123';
    }



}
