<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition End User License Agreement
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magento.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Sales
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Billing Agreement abstract model
 *
 * @method Mage_Sales_Model_Resource_Billing_Agreement _getResource()
 * @method Mage_Sales_Model_Resource_Billing_Agreement getResource()
 * @method int getCustomerId()
 * @method Mage_Sales_Model_Billing_Agreement setCustomerId(int $value)
 * @method string getMethodCode()
 * @method Mage_Sales_Model_Billing_Agreement setMethodCode(string $value)
 * @method string getReferenceId()
 * @method Mage_Sales_Model_Billing_Agreement setReferenceId(string $value)
 * @method string getStatus()
 * @method Mage_Sales_Model_Billing_Agreement setStatus(string $value)
 * @method string getCreatedAt()
 * @method Mage_Sales_Model_Billing_Agreement setCreatedAt(string $value)
 * @method string getUpdatedAt()
 * @method Mage_Sales_Model_Billing_Agreement setUpdatedAt(string $value)
 * @method int getStoreId()
 * @method Mage_Sales_Model_Billing_Agreement setStoreId(int $value)
 * @method string getAgreementLabel()
 * @method Mage_Sales_Model_Billing_Agreement setAgreementLabel(string $value)
 *
 * @category    Mage
 * @package     Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Sales_Model_Billing_Agreement extends Mage_Payment_Model_Billing_AgreementAbstract
{
    const STATUS_ACTIVE     = 'active';
    const STATUS_CANCELED   = 'canceled';

    /**
     * Related agreement orders
     *
     * @var array
     */
    protected $_relatedOrders = array();

    /**
     * Init model
     *
     */
    protected function _construct()
    {
        $this->_init('sales/billing_agreement');
    }

    /**
     * Set created_at parameter
     *
     * @return Mage_Core_Model_Abstract
     */
    protected function _beforeSave()
    {
        $date = Mage::getModel('core/date')->gmtDate();
        if ($this->isObjectNew() && !$this->getCreatedAt()) {
            $this->setCreatedAt($date);
        } else {
            $this->setUpdatedAt($date);
        }
        return parent::_beforeSave();
    }

    /**
     * Save agreement order relations
     *
     * @return Mage_Core_Model_Abstract
     */
    protected function _afterSave()
    {
        if (!empty($this->_relatedOrders)) {
            $this->_saveOrderRelations();
        }
        return parent::_afterSave();
    }

    /**
     * Retrieve billing agreement status label
     *
     * @return string
     */
    public function getStatusLabel()
    {
        switch ($this->getStatus()) {
            case self::STATUS_ACTIVE:
                return Mage::helper('sales')->__('Active');
            case self::STATUS_CANCELED:
                return Mage::helper('sales')->__('Canceled');
        }
    }

    /**
     * Initialize token
     *
     * @return string
     */
    public function initToken()
    {
        $this->getPaymentMethodInstance()
            ->initBillingAgreementToken($this);
        return $this->getRedirectUrl();
    }

    /**
     * Get billing agreement details
     * Data from response is inside this object
     *
     * @return Mage_Sales_Model_Billing_Agreement
     */
    public function verifyToken()
    {
        $this->getPaymentMethodInstance()
            ->getBillingAgreementTokenInfo($this);
        return $this;
    }

    /**
     * Check for permissions
     *
     * @param int $customerIdSession
     * @return boolean
     */
    public function canPerformAction($customerIdSession)
    {
        // Get the customer id from billing agreement and compare to logged in customer id
        return ((int)$this->getCustomerId() === (int)$customerIdSession) ? true : false;
    }

    /**
     * Create billing agreement
     *
     * @return Mage_Sales_Model_Billing_Agreement
     */
    public function place()
    {
        $this->verifyToken();

        $paymentMethodInstance = $this->getPaymentMethodInstance()
            ->placeBillingAgreement($this);

        $this->setCustomerId($this->getCustomer()->getId())
            ->setMethodCode($this->getMethodCode())
            ->setReferenceId($this->getBillingAgreementId())
            ->setStatus(self::STATUS_ACTIVE)
            ->setAgreementLabel($paymentMethodInstance->getTitle())
            ->save();
        return $this;
    }

    /**
     * Cancel billing agreement
     *
     * @return Mage_Sales_Model_Billing_Agreement
     */
    public function cancel()
    {
        $this->setStatus(self::STATUS_CANCELED);
        $this->getPaymentMethodInstance()->updateBillingAgreementStatus($this);
        return $this->save();
    }

    /**
     * Check whether can cancel billing agreement
     *
     * @return bool
     */
    public function canCancel()
    {
        return ($this->getStatus() != self::STATUS_CANCELED);
    }

    /**
     * Retrieve billing agreement statuses array
     *
     * @return array
     */
    public function getStatusesArray()
    {
        return array(
            self::STATUS_ACTIVE     => Mage::helper('sales')->__('Active'),
            self::STATUS_CANCELED   => Mage::helper('sales')->__('Canceled')
        );
    }

    /**
     * Validate data
     *
     * @return bool
     */
    public function isValid()
    {
        $result = parent::isValid();
        if (!$this->getCustomerId()) {
            $this->_errors[] = Mage::helper('payment')->__('Customer ID is not set.');
        }
        if (!$this->getStatus()) {
            $this->_errors[] = Mage::helper('payment')->__('Billing Agreement status is not set.');
        }
        return $result && empty($this->_errors);
    }

    /**
     * Import payment data to billing agreement
     *
     * $payment->getBillingAgreementData() contains array with following structure :
     *  [billing_agreement_id]  => string
     *  [method_code]           => string
     *
     * @param Mage_Sales_Model_Order_Payment $payment
     * @return Mage_Sales_Model_Billing_Agreement
     */
    public function importOrderPayment(Mage_Sales_Model_Order_Payment $payment)
    {
        $baData = $payment->getBillingAgreementData();

        $this->_paymentMethodInstance = (isset($baData['method_code']))
            ? Mage::helper('payment')->getMethodInstance($baData['method_code'])
            : $payment->getMethodInstance();
        if ($this->_paymentMethodInstance) {
            $this->_paymentMethodInstance->setStore($payment->getMethodInstance()->getStore());
            $this->setCustomerId($payment->getOrder()->getCustomerId())
                ->setMethodCode($this->_paymentMethodInstance->getCode())
                ->setReferenceId($baData['billing_agreement_id'])
                ->setStatus(self::STATUS_ACTIVE);
        }
        return $this;
    }

    /**
     * Retrieve available customer Billing Agreements
     *
     * @param int $customer
     * @return Mage_Paypal_Controller_Express_Abstract
     */
    public function getAvailableCustomerBillingAgreements($customerId)
    {
        $collection = Mage::getResourceModel('sales/billing_agreement_collection');
        $collection->addFieldToFilter('customer_id', $customerId)
            ->addFieldToFilter('status', self::STATUS_ACTIVE)
            ->setOrder('agreement_id');
        return $collection;
    }

    /**
     * Check whether need to create billing agreement for customer
     *
     * @param int $customerId
     * @return bool
     */
    public function needToCreateForCustomer($customerId)
    {
        return $customerId ? count($this->getAvailableCustomerBillingAgreements($customerId)) == 0 : false;
    }

    /**
     * Add order relation to current billing agreement
     *
     * @param int|Mage_Sales_Model_Order $orderId
     * @return Mage_Sales_Model_Billing_Agreement
     */
    public function addOrderRelation($orderId)
    {
        $this->_relatedOrders[] = $orderId;
        return $this;
    }

    /**
     * Save related orders
     */
    protected function _saveOrderRelations()
    {
        foreach ($this->_relatedOrders as $order) {
            $orderId = $order instanceof Mage_Sales_Model_Order ? $order->getId() : (int) $order;
            $this->getResource()->addOrderRelation($this->getId(), $orderId);
        }
    }

}
