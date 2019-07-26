<?php
    include_once(CLASSES . 'Sessions.php');

    switch($courseSession):
        case 1 :
            //include_once(VIEWS . 'components/profile/forms/session-1.php');
        break;
        default :
            //include_once(VIEWS . 'components/profile/forms/default.php');
    endswitch;


    $entry_value = ($_GET['entry_type']) ? : 10;

    if(isset($_GET['entry_type'])){
        $returnSessionVal = 0;
        switch ($_GET['entry_type']):
            case 'journalOutlet' :
                $entry_value = 1;

                break;
            case 'my_boundaries' :
                $entry_value = 3;

                break;
            case 'my_intervention' :
                $entry_value = 4;

                break;
            case 'refused_treatment' :
                $entry_value = 5;


                break;

            case 'my_progress' :
                $entry_value = 6;

                break;
            /*case 'stop_enabling' :
                $entry_value = 7;

                break;
            case 'grateful_for' :
                $entry_value = 8;

                break;
            case 'be_Proactive' :
                $entry_value = 9;

                break;*/
            default : $entry_value = 10;

        endswitch;

        include_once(VIEWS . 'components/profile/forms/session-' . $entry_value . '.php');
    }else{
        include_once(VIEWS . 'components/profile/forms/default.php');
        include_once(VIEWS . 'components/profile/forms/session-1.php');
        include_once(VIEWS . 'components/profile/forms/session-3.php');
        include_once(VIEWS . 'components/profile/forms/session-4.php');
        include_once(VIEWS . 'components/profile/forms/session-5.php');
        include_once(VIEWS . 'components/profile/forms/session-6.php');
    }

