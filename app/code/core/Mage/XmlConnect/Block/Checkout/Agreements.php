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
 * @package     Mage_XmlConnect
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * One page checkout agreements xml renderer
 *
 * @category    Mage
 * @package     Mage_XmlConnect
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_XmlConnect_Block_Checkout_Agreements extends Mage_Checkout_Block_Agreements
{
    /**
     * Render agreements xml
     *
     * @return string
     */
    protected function _toHtml()
    {
        /** @var $agreementsXmlObj Mage_XmlConnect_Model_Simplexml_Element */
        $agreementsXmlObj = Mage::getModel('xmlconnect/simplexml_element', '<agreements></agreements>');
        if ($this->getAgreements()) {
            foreach ($this->getAgreements() as $agreement) {
                $itemXmlObj = $agreementsXmlObj->addChild('item');
                $content = $agreement->getContent();
                if (!$agreement->getIsHtml()) {
                    $content = nl2br($agreementsXmlObj->escapeXml($content));
                } else {
                    $content = $agreementsXmlObj->xmlentities($content);
                }
                $agreementText = $agreementsXmlObj->escapeXml($agreement->getCheckboxText());
                $itemXmlObj->addChild('label', $agreementText);
                $itemXmlObj->addChild('content', $content);
                $itemXmlObj->addChild('code', 'agreement[' . $agreement->getId() . ']');
                $itemXmlObj->addChild('agreement_id', $agreement->getId());
            }
        }

        return $agreementsXmlObj->asNiceXml();
    }
}
