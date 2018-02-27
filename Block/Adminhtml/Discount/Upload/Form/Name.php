<?php
class AAGlobal_Discount_Block_Adminhtml_Discount_Edit_Form_Name extends Varien_Data_Form_Element_Abstract
{

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

        $customerData = Mage::getModel('customer/customer')->load($products)->getData();
        $html = '<div id="containerCustomer" class="grid"><table cellspacing="2" cellpadding="2" border="1" width="100%">';
        $html .= '<tr class="headings">';
        $html .= '<th>';
        $html .= 'Name';
        $html .= '</th>';
        $html .= '<th>';
        $html .= 'Email';
        $html .= '</th>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>';
        $html .= $customerData['firstname'];
        $html .= ' ';
        $html .= $customerData['lastname'];
        $html .= '</td>';
        $html .= '<td>';
        $html .= $customerData['email'];
        $html .= '</td>';
        $html .= '</tr>';

        $html .= '</table></div>';

         $html .= '<input type="hidden" name="customer" id="customer" value="' . $products. '" />';
        $html .= '<div style="padding-top: 5px;">' . $this->getButtons() . '</div>';
        return $html;
    }

    private function getButtons()
    {
        $html  = "<button onclick=\"".$this->getCustomerChooserURL()."\" title=\"Select Customer\" type=\"button\" class=\"scalable\" style=\"\"><span><span><span>Select Customer</span></span></span></button>";
        $html  .= "<button onclick=\"aaglobalHideCustomers('containerCustomer')\" title=\"Done\" id='customerset' type=\"button\" class=\"scalable save\" style=\"visibility: hidden;\"><span><span><span>Set</span></span></span></button>";

        return $html;
    }

    private function getCustomerChooserURL()
    {
        return 'aaglobalGetCustomer(\'' . Mage::helper("adminhtml")->getUrl("*/*/customer") . '?isAjax=true\', \'containerCustomer\'); return false;';
    }
}
