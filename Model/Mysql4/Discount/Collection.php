<?php
class AAGlobal_Discount_Model_Mysql4_Discount_Collection
    extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {  
        $this->_init('aaglobal_discount/discount');
    }
}
