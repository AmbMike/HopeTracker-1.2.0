<?php

/**
 * File For: HopeTracker.com
 * File Name: FAQ.php.
 * Author: Mike Giammattei
 * Created On: 3/21/2017, 3:55 PM
 */
class FAQ
{
    function __construct(){

    }

    public static function version_1($array){
        $sanitize = new General();

        $answer = $array['Answer'];
        $question = $array['Question'];
        $return = <<< EOD
         <div id="faq_v_1">
        <div class="qa-pairs">
            <div class="faq-contain">
                <div class="faq-divider">
                    <dl>
                        <dd>{$answer}</dd>
                        <dt><span>{$question}</span>
                        <div class="faq-toggle">
                            <div class="circle">
                                <div class="minus"></div>
                                <div class="plus"></div>
                            </div>
                        </div>
                        </dt>
                    </dl>
                </div>
            </div>
        </div>
    </div>
EOD;
        $return = $sanitize->sanitize_output($return);
        echo $return;
    }
}