<?php
/**
 * ABTester business logic.
 * Author: David Majidian
 * Date: 03/28/2017
 */
class AAGlobal_Discount_Model_Discount
    extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('aaglobal_discount/discount');
    }

    public function init()
    {
        if (Mage::registry('discount') === null) {
            Mage::register('discount', $this);
        }
    }
}
