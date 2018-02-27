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
         $customer = $row->getData('customer');

         $id  = $this->getRequest()->getParam('id');
         $customerData = Mage::getModel('customer/customer')->load($customer)->getData();

         return $customerData['email'] . ' (' . $customerData['firstname'] . ' ' . $customerData['lastname'] . ')';
     }
 }
