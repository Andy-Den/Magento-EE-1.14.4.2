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
 * Sales Billing Agreement form block
 *
 * @author Magento Core Team <core@magentocommerce.com>
 */
class Mage_Sales_Block_Payment_Form_Billing_Agreement extends Mage_Payment_Block_Form
{
    /**
     * Set custom template
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('sales/payment/form/billing/agreement.phtml');
        $this->setTransportName(Mage_Sales_Model_Payment_Method_Billing_AgreementAbstract::TRANSPORT_BILLING_AGREEMENT_ID);
    }

    /**
     * Retrieve available customer billing agreements
     *
     * @return array
     */
    public function getBillingAgreements()
    {
        $data = array();
        $quote = $this->getParentBlock()->getQuote();
        if (!$quote || !$quote->getCustomer()) {
            return $data;
        }
        $collection = Mage::getModel('sales/billing_agreement')->getAvailableCustomerBillingAgreements(
            $quote->getCustomer()->getId()
        );

        foreach ($collection as $item) {
            $data[$item->getId()] = $item->getReferenceId();
        }
        return $data;
    }
}
