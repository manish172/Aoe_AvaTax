<?php

class Aoe_AvaTax_Model_Sales_Invoice extends Mage_Sales_Model_Order_Invoice
{
    /**
     * Register invoice
     *
     * NB: This override is used to trigger the AvaTax commit mode
     *
     * @return $this
     */
    public function register()
    {
        /** @var Aoe_AvaTax_Helper_Data $helper */
        $helper = Mage::helper('Aoe_AvaTax/Data');
        if ($helper->isActive($this->getStore())) {
            /* @var $entityType Mage_Eav_Model_Entity_Type */
            $entityType = Mage::getModel('eav/entity_type')->loadByCode('invoice');
            $this->setIncrementId($entityType->fetchNewIncrementId($this->getStoreId()));

            $this->setCommitTaxDocuments(true);

            $this->setSubtotal(0);
            $this->setBaseSubtotal(0);
            $this->setShippingAmount(0);
            $this->setBaseShippingAmount(0);
            $this->setDiscountAmount(0);
            $this->setBaseDiscountAmount(0);
            $this->setGrandTotal(0);
            $this->setBaseGrandTotal(0);
            $this->collectTotals();
        }

        return parent::register();
    }
}
