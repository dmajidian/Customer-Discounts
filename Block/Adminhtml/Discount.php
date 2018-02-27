<?php
class AAGlobal_Discount_Block_Adminhtml_Discount extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'aaglobal_discount';
        $this->_controller = 'adminhtml_discount';
        $this->_headerText = $this->__('Customer Discounts');
        parent::__construct();
        $this->_removeButton('reset');
    }
}
