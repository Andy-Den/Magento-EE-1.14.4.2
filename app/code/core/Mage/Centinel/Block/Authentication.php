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
 * @package     Mage_Centinel
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Centinel validation frame
 */
class Mage_Centinel_Block_Authentication extends Mage_Core_Block_Template
{
    /**
     * Strage for identifiers of related blocks
     *
     * @var array
     */
    protected $_relatedBlocks = array();

    /**
     * Flag - authentication start mode
     * @see self::setAuthenticationStartMode
     *
     * @var bool
     */
    protected $_authenticationStartMode = false;

    /**
     * Add identifier of related block
     *
     * @param string $blockId
     * @return Mage_Centinel_Block_Authentication
     */
    public function addRelatedBlock($blockId)
    {
        $this->_relatedBlocks[] = $blockId;
        return $this;
    }

    /**
     * Return identifiers of related blocks
     *
     * @return array
     */
    public function getRelatedBlocks()
    {
        return $this->_relatedBlocks;
    }

    /**
     * Check whether authentication is required and prepare some template data
     *
     * @return string
     */
    protected function _toHtml()
    {
        $method = Mage::getSingleton('checkout/session')->getQuote()->getPayment()->getMethodInstance();
        if ($method->getIsCentinelValidationEnabled()) {
            $centinel = $method->getCentinelValidator();
            if ($centinel && $centinel->shouldAuthenticate()) {
                $this->setAuthenticationStart(true);
                $this->setFrameUrl($centinel->getAuthenticationStartUrl());
                return parent::_toHtml();
            }
        }
        return parent::_toHtml();
    }
}
