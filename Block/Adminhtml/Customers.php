<?php
class AAGlobal_Discount_Block_Adminhtml_Customers extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'aaglobal_discount';
        $this->_controller = 'adminhtml_discount';
        $this->_headerText = $this->__('Customers');
        parent::__construct();
        $this->_removeButton('reset');
    }
}
