<?php

/**
 * FileName: Layout.php
 * Description:
 *
 * Created by: Ambrosia Digital Team.
 * Author: Michael Giammattei
 * Date: 7/17/2019
 */

namespace Profile;


class Layout
{
    public function col6($content){
        $html = '<div class="col-md-6">';
        $html .= $content;
        $html .= '</div>';

        return $html;
    }
    public function col12($content){
        $html = '<div class="col-md-12">';
        $html .= $content;
        $html .= '</div>';

        return $html;
    }
    public function formField6($content,$ID){
        $html = '<div class="col-md-6">';
        $html .= '<textarea class="s-half" id="'.$ID.'">';
        $html .= $content;
        $html .= '</textarea>';
        $html .= '</div>';

        return $html;
    }
    public function formField12($content,$ID){
        $html = '<div class="col-md-12">';
        $html .= '<textarea id="'.$ID.'">';
        $html .= $content;
        $html .= '</textarea>';
        $html .= '</div>';

        return $html;
    }
    public function processor($arr){
        $returnValue = '';
        $tempArr = array();

        /**
         * @var  $key - textarea ID value
         * @var  $item - text area value
         * Description: put the textareas into an array grouping col width sizes
         */
        foreach ($arr as $key => $item) {

            if(preg_match('/6/',$key)){
                $tempArr[6][] = $this->formField6($item,$key);
            }
            if(preg_match('/12/',$key)){
                $tempArr[12][] = $this->formField12($item,$key);
            }
        }

        /** Handle col 6 arrays */
        $count = 0;
        foreach ($tempArr[6] as $key => $item2) {

            if($count == 0 || $count % 2 == 0){
                $returnValue .= '<div class="form-group"><div class="row">';
            }

            $returnValue .= $item2;
                if($count % 2 != 0 ){
                $returnValue .= '</div></div>';
            }
            $count++;
        }
        /** Handle col 12 arrays */
        $count = 0;
        foreach ($tempArr[12] as $key => $item2) {


            $returnValue .= '<div class="form-group"><div class="row">';

            $returnValue .= $item2;

            $returnValue .= '</div></div>';

            $count++;
        }

        return $returnValue;
    }
}