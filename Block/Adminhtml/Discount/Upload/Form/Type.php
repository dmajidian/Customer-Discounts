<?php
class AAGlobal_Discount_Block_Adminhtml_Discount_Edit_Form_Type extends Varien_Data_Form_Element_Abstract
{
    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
    }

    public function getElementHtml()
    {
        if ($this->getEscapedValue() === 'amount')
        {
            $sel_1 = 'checked="checked"';
            $sel_2 = '';

        }
        else if($this->getEscapedValue() === 'percent') {
            $sel_1 = '';
            $sel_2 = 'checked="checked"';
        }
        else {
            $sel_1 = 'checked="checked"';
            $sel_2 = '';
        }

        $html = '<label for="amount">Amount</label> <input type="radio" value="amount" ' . $sel_1 . ' id="amount" name="' . $this->getName() . '" />';

        $html .= ' <label for="percent">Percent</label> <input type="radio" value="percent" ' . $sel_2 . ' id="percent" name="' . $this->getName() . '"  />';

        return $html;
    }
}
