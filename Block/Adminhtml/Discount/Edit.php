<?php
class AAGlobal_Discount_Block_Adminhtml_Discount_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {  
        $this->_blockGroup = 'aaglobal_discount';
        $this->_controller = 'adminhtml_discount';

        $this->_updateButton('delete', 'label', $this->__('Delete Discount'));
        parent::__construct();
    }  

    public function getHeaderText()
    {
        if (Mage::registry('aaglobal_discount')->getId())
        {
            return $this->__('Edit Customer Discount');
        }
        else {
            return $this->__('New Customer Discount');
        }
    }  
}
