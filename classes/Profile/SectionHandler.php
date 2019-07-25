<?php

/**
 * FileName: SectionHandler.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/22/2019
 */

namespace Profile;


class SectionHandler
{

    public $getHandler, $hasHandler,$courseValue = 10;

    private $handlers = array(
        'journalOutlet',
        'stop_enabling',
        'my_boundaries',
        'my_intervention',
        'refused_treatment',
        'be_Proactive',
        'my_progress'
    );

    public function __construct($entry_title)
    {
        $this->getHandler = $entry_title;
        $this->getHandler();
    }

    public function getHandler(){

        $returnSessionVal = 0;
        switch ($this->getHandler):
            case 'journalOutlet' :
                $this->courseValue = 1;
                $this->hasHandler = true;
                break;
            case 'stop_enabling' :
                $this->courseValue = 7;
                $this->hasHandler = true;
                break;
            case 'my_boundaries' :
                $this->courseValue = 3;
                $this->hasHandler = true;
                break;
            case 'my_intervention' :
                $this->courseValue = 4;
                $this->hasHandler = true;
                break;
            case 'grateful_for' :
                $this->courseValue = 8;
                $this->hasHandler = true;
                break;
            case 'refused_treatment' :
                $this->courseValue = 5;
                $this->hasHandler = true;

                break;
            case 'be_Proactive' :
                $this->courseValue = 9;
                $this->hasHandler = true;
                break;
            case 'my_progress' :
                $this->courseValue = 6;
                $this->hasHandler = true;
                break;
            default : $this->courseValue = 10;
                $this->hasHandler = false;
        endswitch;
    }

}