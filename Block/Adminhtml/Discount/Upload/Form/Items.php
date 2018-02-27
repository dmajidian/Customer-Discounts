<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AAGlobal_Discount_Block_Adminhtml_Discount_Edit_Form_Items
{
    protected $_countries;
    protected $_options;

    public function toOptionArray($isMultiselect=false, $firstoption = array())
    {
        $products = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToSelect('*');
        //process your product collection as per your bussiness logic
        $productName = array();

        foreach($products as $p)
        {
            $productName[$p->getId()]['value'] =$p->getId();
            $productName[$p->getId()]['label'] ='[' . $p->getSku() . '] ' . $p->getName();
        }

        return $productName;
    }

    public function sortRegionCountries($a, $b)
    {
        return strcmp($this->_countries[$a], $this->_countries[$b]);
    }
}
