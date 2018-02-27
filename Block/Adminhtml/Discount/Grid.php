<?php
class AAGlobal_Discount_Block_Adminhtml_Discount_Grid
    extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultSort('name');
        $this->setId('aaglobal_discount_discount_grid');
        $this->setSaveParametersInSession(false);
        $this->setFilterVisibility(false);
        $this->setUseAjax(false);

    }

    protected function _getCollectionClass()
    {
        return 'aaglobal_discount/discount_collection';
    }

    protected function _prepareCollection()
    {
        $banners = Mage::getResourceModel('aaglobal_discount/discount_collection');

        $banners->getSelect();
        $mainCollection = new Varien_Data_Collection();

        foreach ($banners as $banner)
        {
            $rowObj = new Varien_Object();
            $rowObj->setData($banner->getData());
            $mainCollection->addItem($rowObj);
        }

        $this->setCollection($mainCollection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('customer',
            array(
                'header'   => $this->__('Customer'),
                'index'    => 'customer',
                'renderer' => 'AAGlobal_Discount_Block_Adminhtml_Discount_Grid_Name'
            )
        );

        $this->addColumn('sku',
            array(
                'header'   => $this->__('Products'),
                'index'    => 'sku',
                'renderer' => 'AAGlobal_Discount_Block_Adminhtml_Discount_Grid_Products'
            )
        );
       $this->addColumn('category',
            array(
                'header'   => $this->__('Category'),
                'index'    => 'category',
                'renderer' => 'AAGlobal_Discount_Block_Adminhtml_Discount_Grid_Category'
            )
        );

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    public function getMainButtonsHtml()
    {
        $html ='<form id="edit_form" action="'.$this->getUrl('*/*/uploadcsv').'" method="post" enctype="multipart/form-data">
        <input name="form_key" type="hidden" value="'. Mage::getSingleton('core/session')->getFormKey() . '" />
        <label for="file">Upload Fishbowl CSV: </label>
        <input id="file" name="file" value="" class="form-button" type="file"/>  
        <input type="submit" class="form-button" value="Upload" /></form>';

        return $html;
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('discounts');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('tax')->__('Delete'),
            'url'  => $this->getUrl('*/*/massdel', array('' => '')),
            'confirm' => Mage::helper('tax')->__('Are you sure?')
        ));

        return $this;
    }
}
