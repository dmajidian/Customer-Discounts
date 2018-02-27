<?php
class AAGlobal_Discount_Block_Adminhtml_Discount_Edit_Form_Products extends Varien_Data_Form_Element_Abstract
{
    public function __construct($attributes=array())
    {
        parent::__construct($attributes);
    }

    public function getElementHtml()
    {
        $products = $this->getValue();
        $skus = array();
        $products = unserialize($products);

        $html = '<div id="containerProducts" class="grid"><table cellspacing="2" cellpadding="2" border="1" width="100%">';
        $html .= '<tr class="headings">';
        $html .= '<th width="40%">';
        $html .= 'Product(s)';
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



                $id = Mage::getModel('catalog/product')->getIdBySku(trim(strtoupper($key)));

                //echo '<pre>'; print_r(get_class_methods($product)); echo '</pre>';

                if (false !== $id)
                {
                    $skus[$key] = $key;
                    $html .= '<tr>';
                    $html .= '<td>';
                    $product = Mage::getModel('catalog/product')->load($id);
                    $html .= trim(strtoupper($key)). ' - ';
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
                    $html .= 'Amount <input type="radio" value="amount" ' . $amount_sel . ' name="products[' . trim($key) . '][type]" /> Percent <input type="radio" value="percent" ' . $percent_sel . ' name="products[' . trim($key) . '][type]" />';
                    $html .= '</td>';
                    $html .= '<td>';
                    $html .= '<input type="text" value="' . $prod['value'] . '" name="products[' . trim($key) . '][value]" />';
                    $html .= '</td>';
                    $html .= '</tr>';
                }
            }
        } else {
            $html .= '<tr>';
            $html .= '<td colspan="3">';
                $html .= 'None Selected';

            $html .= '</td>';

            $html .= '</tr>';
        }
            $html .= '</table></div>';

            $html .= '<input type="hidden" name="sku" id="product_sku" value="' . implode(',', $skus) . '" />';

        $html .= '<div style="padding-top: 5px;">' . $this->getButtons() . '</div>';
        return $html;
    }

    private function getButtons()
    {
        $html  = "<button onclick=\"".$this->getProductChooserURL()."\" title=\"Select Customer\" type=\"button\" class=\"scalable\" style=\"\"><span><span><span>Select Product(s)</span></span></span></button>";
        $html .= " <button onclick=\"aaglobalClearProducts('containerProducts'); ".$this->getProductChooserURL()."\" title=\"Clear\" id='clearproducts' type=\"button\" class=\"scalable\" style=\"visibility: visible;\"><span><span><span>Clear</span></span></span></button>";
        $html  .= " <button onclick=\"". $this->getItemChooserURL() ."\" title=\"Set and Continue\" type=\"button\" id='productset' class=\"scalable save\" style=\"visibility: hidden;\"><span><span><span>Set and Continue</span></span></span></button>";

        return $html;
    }
    private function getProductChooserURL()
    {
        return 'aaglobalGetProducts(\'' . Mage::getUrl(
                'adminhtml/promo_widget/chooser/attribute/sku/form/rule_conditions_fieldset', array('_secure' => Mage::app()->getStore()->isAdminUrlSecure())
            ) . '?isAjax=true\', \'containerProducts\'); return false;';
    }

    private function getItemChooserURL()
    {
        return 'aaglobalCustomizeProducts(\'' . Mage::helper("adminhtml")->getUrl("*/*/items") . '?isAjax=true\', \'containerProducts\'); return false;';
    }
}
