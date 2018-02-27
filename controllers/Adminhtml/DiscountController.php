<?php

class AAGlobal_Discount_Adminhtml_DiscountController
    extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_initAction()
            ->renderLayout();
    }

    public function deleteAction()
    {
        $var = $this->getRequest()->getParam('id');

        if (!empty($var))
        {
            try
            {
                $connection = Mage::getSingleton('core/resource')->getConnection('aaglobal_discount_write');
                $sql = 'DELETE FROM `aaglobal_discount_discount` WHERE `id` = ?';
                $connection->query($sql, $var);

                Mage::getSingleton('adminhtml/session')->addSuccess('successfully deleted');
                $this->_redirect('*/*/');
            }
            catch (Exception $e)
            {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                //  $this->_redirect('*/*/edit', array('name' => $this->getRequest()->getParam('name')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function uploadcsvAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
                try
                {
                    $path = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . 'uploads' . DS;
                    $fname = $_FILES['file']['name']; //file name
                    $fullname = $path.$fname;
                    $uploader = new Varien_File_Uploader('file'); //load class
                    $uploader->setAllowedExtensions(array('CSV','csv')); //Allowed extension for file
                    $uploader->setAllowCreateFolders(true); //for creating the directory if not exists
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    $result = $uploader->save($path, $fname); //save the
                }
                catch (Exception $e)
                {
                    $fileType = "Invalid file format";
                }
            }
        }

        $this->parseCSV($result);

        Mage::getSingleton('adminhtml/session')->addSuccess($this->__($fullname." All valid entries have been saved."));
        $this->_redirect('*/*/');
    }

    public function newAction()
    {
        $this->_redirect('*/*/edit');
    }

    public function customerAction()
    {
        $this->loadLayout();
        $this->_addContent(
            $this->getLayout()->createBlock('aaglobal_discount/adminhtml_customers_grid', 'customers_grid')
        );
        $this->renderLayout();
    }

    public function detailsAction()
    {
        $id  = $this->getRequest()->getParam('id');
        $customerData = Mage::getModel('customer/customer')->load($id)->getData();
        $html = '<div class="grid"><table cellspacing="2" cellpadding="2" border="1" width="100%">';
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

        echo $html;

    }

    public function massdelAction()
    {
        $post = $this->getRequest()->getPost();

        if(is_array($post['discounts']) && count($post['discounts']) > 0 )
        {
            foreach($post['discounts'] as $var)
            {
                if (!empty($var))
                {
                    $connection = Mage::getSingleton('core/resource')->getConnection('aaglobal_discount_write');
                    $sql = 'DELETE FROM `aaglobal_discount_discount` WHERE `id` = ?';
                    $connection->query($sql, $var);
                }
            }
        }

        Mage::getSingleton('adminhtml/session')->addSuccess('Discount(s) successfully deleted');
        $this->_redirect('*/*/');
    }

    public function categoryAction()
    {
        $options = Mage::getModel('AAGlobal_Discount_Block_Adminhtml_Discount_Edit_Form_Category')->toOptionArray(true, array(0=>['label'=>'(Select Category(s))', 'value'=>'']));

        echo '<select name="categoryfield" id="categoryfield" multiple size="10" class=" select multiselect">';
        foreach ($options as $key=>$value)
        {
            echo '<option value="'.$value['value'].'">'.$value['label'].'</option>';
        }
        echo '</select>';

        // echo '<input name="categoryfield" id="categoryfield" value="123" />';

    }
    public function categoriesAction()
    {
        $categories  = $this->getRequest()->getParam('categoryselected');
        $category = explode(',', $categories);

        $html = '<table cellspacing="2" cellpadding="2" border="1" width="100%">';
        $html .= '<tr class="headings">';
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
        foreach($category as $key=>$sku)
        {
            $product = Mage::getModel('catalog/category')->load(trim($sku));

            $html .= '<tr>';
            $html .= '<td>';
            $html .= $product->getName();
            $html .= '</td>';
            $html .= '<td>';
            $html .= 'Amount <input type="radio" checked=checked value="amount" name="category['. trim($sku) .'][type]" /> Percent <input type="radio" value="percent" name="category['. trim($sku) .'][type]" />';
            $html .= '</td>';
            $html .= '<td>';
            $html .= '<input type="text" value=""  name="category['. trim($sku) .'][value]" />';
            $html .= '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';

        echo $html;
    }

    public function itemsAction()
    {
        $skus  = $this->getRequest()->getParam('skus');

        $skus = explode(',', $skus);

        $html = '<table cellspacing="2" cellpadding="2" border="1" width="100%">';
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
        foreach($skus as $key=>$sku)
        {
            $html .= '<tr>';
            $html .= '<td>';
            $product = Mage::getModel('catalog/product')->loadByAttribute('sku', trim($sku));

            $html .= trim($sku) . ' - ' . $product->getName();
            $html .= '</td>';
            $html .= '<td>';
            $html .= 'Amount <input type="radio" value="amount" checked=checked name="products['. trim($sku) .'][type]" /> Percent <input type="radio" value="percent" name="products['. trim($sku) .'][type]" />';
            $html .= '</td>';
            $html .= '<td>';
            $html .= '<input type="text" value="" name="products['. trim($sku) .'][value]" />';
            $html .= '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';

        echo $html;
    }

    public function editAction()
    {
        $this->_initAction();
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('aaglobal_discount/discount');

        if ($id)
        {
            $model->load($id);

            if (!$model->getId())
            {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This Discount no longer exists.'));
                $this->_redirect('*/*/');

                return;
            }
        }

        $this->_title($model->getId() ? $this->__('Edit Discount') : $this->__('New Discount'));

        Mage::register('aaglobal_discount', $model);
        $this->_initAction()
            ->_addBreadcrumb($id ? $this->__('Edit Discount') : $this->__('New Discount'), $id ? $this->__('Edit Discount') : $this->__('New Discount'))
            ->_addContent($this->getLayout()->createBlock('aaglobal_discount/adminhtml_discount_edit')->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();
    }

    private  function parseCSV($result)
    {
        if($result['error'] !== 0)
        {
            return;
        }
        $file = $result['path'].$result['file'];
        $csv = new Varien_File_Csv();
        $data = $csv->getData($file);

        $discounts = array();
        $i=0;
        foreach($data as $key=>$value)
        {
            if(trim($value[0]) !== 'RULE')
            {
                $email = (string) trim(strtolower($value[1]));
                $sku = (string) trim(strtoupper($value[5]));
                $discounts[$email][$sku]['EMAIL']     = $email;
                $discounts[$email][$sku]['SKU']       = $sku;
                $discounts[$email][$sku]['PAAMOUNT']  = (float) trim($value[6]);
                $discounts[$email][$sku]['PAPERCENT'] = (float) trim($value[7]);
            }
            $i++;
        }

        $this->saveDiscounts($discounts);
        Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The discounts have been saved.'));
        $this->_redirect('*/*/');

    }

    private function saveDiscounts(array $discounts)
    {
        if(count($discounts) < 1)
        {
            return;
        }
       //

        foreach($discounts as $email=>$discount)
        {
            $customer = Mage::getModel("customer/customer");
            $customer->setWebsiteId(1);
            $customer->loadByEmail($email);
            $customerData = $customer->getData();

            if(count($customerData) > 0)
            {
                $data = array();
                $final['customer'] = $customerData['entity_id'];

                foreach($discount as $sku=>$discou)
                {
                    $item = Mage::getModel('catalog/product')->getIdBySku(trim(strtoupper($discou['SKU'])));

                    if (!empty($customerData['entity_id']) && (false !== $item))
                    {
                        if ($discou['PAAMOUNT'] > 0)
                        {
                            $data[$sku]['type'] = 'amount';
                            $data[$sku]['value'] = $discou['PAAMOUNT'];
                        }
                        elseif ($discount['PAPERCENT'] > 0)
                        {
                            $data[$sku]['type'] = 'percent';
                            $data[$sku]['value'] = $discou['PAPERCENT'];
                        }
                    }
                }

                $final['sku']      = serialize($data);
                $model = Mage::getSingleton('aaglobal_discount/discount');
                $model->setData($final);
                $model->save();

            }
        }

        return;
    }

    public function saveAction()
    {
        $postData = $this->getRequest()->getPost();

        //echo '<pre>'; print_r($postData); echo '</pre>';exit;

        if(isset($postData['products']) && is_array($postData['products']) && count($postData['products']) > 0)
        {
            foreach($postData['products'] as $key=>$products)
            {
                if(empty($products['type']))
                {
                    unset($postData['products'][$key]);
                }
                if(empty($products['value']) || $products['value'] <= 0 || !is_numeric($products['value']))
                {
                    unset($postData['products'][$key]);
                }
            }
            $postData['sku'] = serialize($postData['products']);

            unset($postData['products']);
        } else {
            $postData['products'] = '';
        }

        if(isset($postData['category']) && is_array($postData['category']) && count($postData['category']) > 0)
        {
            unset($postData['categories']);
            foreach($postData['category'] as $key=>$category)
            {
                if(empty($category['type']))
                {
                    unset($postData['category'][$key]);
                }
                if(empty($category['value']) || $category['value'] <= 0 || !is_numeric($category['value']))
                {
                    unset($postData['category'][$key]);
                }
            }
            $postData['category'] = serialize($postData['category']);
        } else {
            $postData['category'] = '';
        }

        // echo '<pre>'; print_r($postData); echo '</pre>';exit;
        if (!empty($postData['form_key'])) {
            unset($postData['form_key']);
            unset($postData['id']);
        }
        // print_r($postData); exit;
        $model = Mage::getSingleton('aaglobal_discount/discount');
        $model->setData($postData)->setId($this->getRequest()->getParam('id'));

        try
        {
            $model->save();

            Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The discount have been saved.'));
            $this->_redirect('*/*/');

            return;
        }
        catch (Mage_Core_Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
        catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this discount.'));
        }

        Mage::getSingleton('adminhtml/session')->setEntityData($postData);
        $this->_redirectReferer();
    }

    public function messageAction()
    {
        $data = Mage::getModel('')->load($this->getRequest()->getParam('name'));
        echo $data->getContent();
    }

    protected function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('sales/aaglobal_discount_discount');
        $this->_title($this->__('CMS'))->_title($this->__('Discount'));
        $this->_addBreadcrumb($this->__('CMS'), $this->__('CMS'));
        $this->_addBreadcrumb($this->__('Discount'), $this->__('Discount'));

        return $this;
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/aaglobal_discount_discount');
    }
}
