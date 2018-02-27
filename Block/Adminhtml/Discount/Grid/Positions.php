<?php
/**
 *
 * User: david.majidian
 * Date: 3/28/2017
 * Time: 11:05 AM
 */
 class AAGlobal_Discount_Block_Adminhtml_Discount_Grid_Name extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
 {
     public function render(Varien_Object $row)
     {
         $position = $row->getData('position');

         if($position === '1')
         {
             $sel_1 = '#c4c4c4';
             $sel_2 = '';
             $sel_3 = '';
             $sel_4 = '';
         } else if($position === '2') {
             $sel_1 = '';
             $sel_2 = '#c4c4c4';
             $sel_3 = '';
             $sel_4 = '';
         } else if($position === '3') {
             $sel_1 = '';
             $sel_2 = '';
             $sel_3 = '#c4c4c4';
             $sel_4 = '';
         } else if($position === '4') {
             $sel_1 = '';
             $sel_2 = '';
             $sel_3 = '';
             $sel_4 = '#c4c4c4';
         } else {
             $sel_1 = '';
             $sel_2 = '';
             $sel_3 = '';
             $sel_4 = '';
         }

         $html = '<table border="0" cellspacing="2" style="text-align: center">';
         $html .= '<tr>';
         $html .= '<td bgcolor="' . $sel_1 . '" style="width: 50%; vertical-align: middle; border:1px solid #ccc;" rowspan="2">';
         $html .= '&nbsp;';
         $html .= '</td>';
         $html .= '<td bgcolor="' . $sel_2 . '" style="vertical-align: middle; border:1px solid #ccc;">';
         $html .= '&nbsp;';
         $html .= '</td>';
         $html .= '<td bgcolor="' . $sel_3. '" style="vertical-align: middle; border:1px solid #ccc;">';
         $html .= '&nbsp;';
         $html .= '</td>';
         $html .= '</tr>';
         $html .= '<tr>';
         $html .= '<td bgcolor="' . $sel_4 . '" style="vertical-align: middle; border:1px solid #ccc;" colspan="2">';
         $html .= '&nbsp;';
         $html .= '</td>';
         $html .= '</tr>';
         $html .= '</table>';
         return $html;
     }
 }
