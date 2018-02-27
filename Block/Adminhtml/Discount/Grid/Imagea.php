<?php
/**
 *
 * User: david.majidian
 * Date: 3/28/2017
 * Time: 11:05 AM
 */
 class AAGlobal_Discount_Block_Adminhtml_Discount_Grid_Imagea
     extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
 {
     public function render(Varien_Object $row)
     {
         return (strlen($row->getData('imagea')) > 0) ? '<img height="30" src="' . $row->getData('imagea') . '" />' : '';
     }
 }
