<?php

class AAGlobal_Discount_Model_Cart extends Mage_Checkout_Model_Cart
{
    private $customerId;
    private $discountCustomer;
    private $selected;
    private $productSku;
    private $product;
    private $newprice;
    private $discount;

    public function discount(Varien_Event_Observer $obs )
    {
        $this->customerId = self::getCustomerId();
        $quote = $obs->getEvent()->getQuote();
        $item = $obs->getQuoteItem();
        $this->productSku = $item->getSku();
        $productId = $item->getProductId();
        $this->product = Mage::getModel('catalog/product')->load($productId);

        $this->discount = 0;

        if ($this->getDiscountCustomer())
        {
            try
            {
                if ($this->validateDiscount())
                {
                    $this->getDiscountPrice();

                    $item->setDiscountAmount($this->discount);
                    $item->setBaseDiscountAmount($this->discount);
                    $item->setCustomPrice($this->newprice);
                    $item->setOriginalCustomPrice($this->newprice);

                    $item->getProduct()->setIsSuperMode(true);
                }
            } catch (Exception $e) {
                echo $e->getTraceAsString();
            }

        }
    }

    private function getDiscountPrice()
    {
        if(!empty($this->selected['type']) && $this->selected['type'] === 'amount')
        {
            $this->discount = (float) $this->selected['value'];
            $this->newprice = $this->discount;
        }
        if(!empty($this->selected['type']) && $this->selected['type'] === 'percent')
        {
            $percentage = (float) $this->selected['value'];
            $price = $this->product->getPrice();
            $this->discount = ($percentage / 100) * $price;
            $this->newprice = $this->product->getPrice() - $this->discount;
        }



        if($this->newprice <= 0)
        {
            $this->newprice = 0;
        }
    }

    private function validateDiscount()
    {
        $prods = @unserialize($this->discountCustomer['sku']);
        $cats = @unserialize($this->discountCustomer['category']);
        $this->selected = array();
        if (is_array($prods) && count($prods) > 0)
        {
            $discountSkus = array();
            foreach($prods as $prodkey=>$category)
            {
                $discountSkus[$prodkey] = $prodkey;
            }

            if (in_array($this->productSku, $discountSkus))
            {
                $this->selected = $prods[$this->productSku];

                return true;
            }
        }
        if (is_array($cats) && count($cats) > 0 )
        {
            $productCategoryIds = $this->product->getCategoryIds();

            $categories = @unserialize($this->discountCustomer['category']);
            $cats = array();
            foreach($categories as $catkey=>$category)
            {
                $cats[$catkey] = $catkey;
            }

            foreach($productCategoryIds as $productCategoryId)
            {
                if (in_array($productCategoryId, $cats))
                {
                    $this->selected = $categories[$productCategoryId];

                    return true;
                    break;
                }
            }
        }

        return false;
    }

    private function getDiscountCustomer()
    {
        $model = Mage::getModel('aaglobal_discount/discount');
        $model->load($this->customerId, 'customer');

        if($model->getId() !== null)
        {
            $this->discountCustomer = $model->getData();

            return true;
        }

        return false;
    }

    private static function getCustomerId()
    {
        if(Mage::getSingleton('customer/session')->isLoggedIn()) {
            $customerData = Mage::getSingleton('customer/session')->getCustomer();
            return $customerData->getId();
        }

        return null;
    }
}
