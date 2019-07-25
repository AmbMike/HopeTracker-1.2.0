<?php

/**
 * FileName: Processor.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/16/2019
 */

namespace Profile;


class Processor
{

    public function __construct(){

        $this->formHandler();
    }

    public function formHandler(){
        $data = $_POST['data']['courseSession'];
        switch ($data):
            case 0 :
                include_once(CLASSES . 'Profile/CommunityUpdate.php');
                $CommunityUpdate = new CommunityUpdate();
                $CommunityUpdate->storeNewPost($_POST['data']);
                break;

            case  1:
                //include_once(CLASSES . 'Profile/CommunityUpdate.php');
                include_once(CLASSES . 'Profile/ProfileForm.php');
                $ProfileForm = new \ProfileForm($_POST['data']['courseSession']);
                $ProfileForm->setSession1($_POST['data']);
                break;
            case   2 :
                include_once(CLASSES . 'Profile/CommunityUpdate.php');
                $CommunityUpdate = new CommunityUpdate();
                $CommunityUpdate->updatePost($_POST['data']);
                break;
            case   3 :
                include_once(CLASSES . 'Profile/Boundaries.php');
                $Boundaries = new Boundaries();
                $Boundaries->storePost($_POST['data']);
                break;
            case   4 :
                include_once(CLASSES . 'Profile/Intervention.php');
                $Intervention = new Intervention();
                $Intervention->storePost($_POST['data']);
                break;
            case   5 :
                include_once(CLASSES . 'Profile/Detachment.php');
                $Detachment = new Detachment();
                $Detachment->storePost($_POST['data']);
                break;
            case   6 :
                include_once(CLASSES . 'Profile/Review.php');
                $Review = new Review();
                $Review->storePost($_POST['data']);
                break;
            case   7 :
                include_once(CLASSES . 'Profile/Enabling.php');
                $Enabling = new Enabling();
                $Enabling->storePost($_POST['data']);
                break;
            case   8 :
                include_once(CLASSES . 'Profile/Grateful.php');
                $Grateful = new Grateful();
                $Grateful->storePost($_POST['data']);
                break;
            case   9 :
                include_once(CLASSES . 'Profile/Proactive.php');
                $Proactive = new Proactive();
                $Proactive->storePost($_POST['data']);
                break;
        endswitch;
        return true;
    }
}