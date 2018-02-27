<?php
class AAGlobal_Discount_Block_Adminhtml_Discount_Edit_Form_Category
{
    protected $_countries;
    protected $_options;

    public function toOptionArray($isMultiselect=false, $firstoption = array())
    {
        $category = Mage::getModel('catalog/category');
        $tree = $category->getTreeModel();
        $tree->load();

        $ids = $tree->getCollection()->getAllIds();

        if (count($firstoption > 0))
        {
            $options = $firstoption;
        } else {
            $options = array();
        }

        if ($ids)
        {
            foreach ($ids as $id)
            {
                $cat = Mage::getModel('catalog/category');
                $cat->load($id);
                if ($cat->getLevel() >=3 && $cat->getIsActive()==1)
                {
                    $name = $cat->getName();
                    $options[$name]['label'] = $name;
                    $options[$name]['value'] = $id;
                }
            }
        }

        sort($options);

        return $options;
    }

    public function sortRegionCountries($a, $b)
    {
        return strcmp($this->_countries[$a], $this->_countries[$b]);
    }
}
