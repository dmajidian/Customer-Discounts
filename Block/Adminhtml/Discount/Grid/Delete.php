<?php
/**
 *
 * User: david.majidian
 * Date: 3/28/2017
 * Time: 11:05 AM
 */
 class AAGlobal_Discount_Block_Adminhtml_Discount_Grid_Delete extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
 {
     public function render(Varien_Object $row)
     {
         return '<a 
            href="'.
             $this->getUrl(
              '*/*/delete',
                     array(
                         'id' => $row->getId()
                     )
             )
             .'" 
            style="
                margin: auto;
                padding:2px; 
                text-decoration: none; 
                color:#FFF;
                text-align:center;
                background:#F55804;
                border-radius:1px;
                width: 90%;
            ">Remove</a>';
     }
 }
