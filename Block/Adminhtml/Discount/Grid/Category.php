<?php
/**
 *
 * User: david.majidian
 * Date: 3/28/2017
 * Time: 11:05 AM
 */
 class AAGlobal_Discount_Block_Adminhtml_Discount_Grid_Category extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
 {
     public function render(Varien_Object $row)
     {
         $categories = @unserialize($row->getCategory());

         $names = [];
         $i=0;
         if(is_array($categories) && count($categories) > 0) {
             echo '<table>';
             foreach ($categories as $id => $values) {
                 echo '<tr>';
                 $category = Mage::getModel('catalog/category')->load($id);
                 $names[$i] = $category->getName();
                 $amount = ($values['value'] >= 0) ? (int)$values['value'] : 0;
                 echo '<td>' . $category->getName() . '</td>';

                 $dollar = ($values['type'] === 'amount') ? '$' : '';
                 $percent = ($values['type'] === 'percent') ? '%' : '';
                 $amount = ($values['type'] === 'amount') ? number_format($amount, 2) : $amount;
                 echo '<td>' . $dollar . $amount . $percent . '</td>';

                 echo '</tr>';

                 $i++;
             }

             echo '</table>';
         }

     }
 }
