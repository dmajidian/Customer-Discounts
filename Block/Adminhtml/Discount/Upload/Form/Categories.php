<?php

class AAGlobal_Discount_Block_Adminhtml_Discount_Edit_Form_Categories
    extends Varien_Data_Form_Element_Abstract
{
    protected $_countries;
    protected $_options;

    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
    }

    public function sortRegionCountries($a, $b)
    {
        return strcmp($this->_countries[$a], $this->_countries[$b]);
    }
    public function getElementHtml()
    {
        $products = $this->getValue();
        $skus = array();
        $products = unserialize($products);

        $html = '<div id="containerCategory"  class="grid"><table cellspacing="2" cellpadding="2" border="1" width="100%">';
        $html .= '<tr  class="headings">';
        $html .= '<th width="40%">';
        $html .= 'Category(s)';
        $html .= '</th>';
        $html .= '<th>';
        $html .= 'Type';
        $html .= '</th>';
        $html .= '<th>';
        $html .= 'Value';
        $html .= '</th>';
        $html .= '</tr>';
        if(is_array($products) && count($products) > 0) {
            foreach ($products as $key => $prod) {
                $html .= '<tr>';
                $html .= '<td>';
                $product = Mage::getModel('catalog/category')->load(trim($key));
                $html .= $product->getName();

                $html .= '</td>';
                $html .= '<td>';

                if ($prod['type'] === 'amount') {
                    $amount_sel = 'checked=checked';
                    $percent_sel = '';
                } elseif ($prod['type'] === 'percent') {
                    $amount_sel = '';
                    $percent_sel = 'checked=checked';
                }
                $html .= 'Amount <input type="radio" value="amount" ' . $amount_sel . ' name="category[' . trim($key) . '][type]" /> Percent <input type="radio" value="percent" ' . $percent_sel . ' name="category[' . trim($key) . '][type]" />';
                $html .= '</td>';
                $html .= '<td>';
                $html .= '<input type="text" value="' . $prod['value'] . '" name="category[' . trim($key) . '][value]" />';
                $html .= '</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr>';
            $html .= '<td colspan="3">';
            $html .= 'None Selected';

            $html .= '</td>';

            $html .= '</tr>';
        }
        $html .= '</table></div>';
       // $html .= '<input type="hidden" name="category" id="category" value="' . implode(',', $skus). '" />';
        $html .= '<div style="padding-top: 5px;">' . $this->getButtons() . '</div>';
        return $html;
    }

    private function getButtons()
    {
        $html  = "<button onclick=\"".$this->getCategoryChooserURL()."\" title=\"Category(s)\" type=\"button\" class=\"scalable\" style=\"\"><span><span><span>Select Category(s)</span></span></span></button>";
        $html .= " <button onclick=\"aaglobalClearCategory('containerCategory'); ".$this->getCategoryChooserURL()."\" title=\"Clear\" id='clearcategory' type=\"button\" class=\"scalable\" style=\"visibility: visible;\"><span><span><span>Clear</span></span></span></button>";
        $html  .= " <button onclick=\"". $this->getCategoriesChooserURL() ."\" title=\"Set and Continue\" type=\"button\" id='categoryset' class=\"scalable save\" style=\"visibility: hidden;\"><span><span><span>Set and Continue</span></span></span></button>";

        return $html;
    }

    private function getCategoryChooserURL()
    {
        return 'aaglobalGetCategories(\'' . Mage::helper("adminhtml")->getUrl("*/*/category") . '?isAjax=true\', \'containerCategory\'); return false;';
    }
    private function getCategoriesChooserURL()
    {
        return 'aaglobalCustomizeCategories(\'' . Mage::helper("adminhtml")->getUrl("*/*/categories") . '?isAjax=true\', \'containerCategory\'); return false;';
    }
}

//AAGlobal_Discount_Block_Adminhtml_Discount_Edit_Form_Category
