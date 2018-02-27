<?php
/**
 *
 * User: david.majidian
 * Date: 3/28/2017
 * Time: 11:05 AM
 */
class AAGlobal_Discount_Block_Adminhtml_Discount_Grid_Products extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $categories = @unserialize($row->getSku());
        // echo $row->getSku();exit;

        $i=0;


        if(is_array($categories) && count($categories) > 0)
        {
            echo '<table>';
            foreach ($categories as $id => $values) {

                if (!empty($id)) {
                    $nid = Mage::getModel('catalog/product')->getIdBySku(trim(strtoupper($id)));
                    if (false !== $nid) {
                        echo '<tr>';
                        $category = Mage::getModel('catalog/product')->load($nid);
                        $amount = ($values['value'] >= 0) ? (float)$values['value'] : 0;
                        echo '<td style="background-color: #fff; font-size: 10px" width="70%">' . $id . ' - ' . $category->getName() . '</td>';

                        $dollar = ($values['type'] === 'amount') ? '$' : '';
                        $percent = ($values['type'] === 'percent') ? '%' : '';
                        $amount = ($values['type'] === 'amount') ? number_format($amount, 2) : $amount;
                        echo '<td style="background-color: #fff; font-size: 10px">' . $dollar . $amount . $percent . '</td>';

                        echo '</tr>';

                        $i++;
                    }
                }
            }
            echo '</table>';
        }

    }
}
