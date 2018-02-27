<?php
class AAGlobal_Discount_Model_Mysql4_Discount
    extends Mage_Core_Model_Mysql4_Abstract
{
    //protected $_isPkAutoIncrement = false;
    protected function _construct()
    {  
        $this->_init('aaglobal_discount/discount', 'id');
    }  
}
