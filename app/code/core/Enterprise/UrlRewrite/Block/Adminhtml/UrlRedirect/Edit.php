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
 * @category    Enterprise
 * @package     Enterprise_UrlRewrite
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Block for UrlRedirects edit form and selectors container
 *
 * @category   Enterprise
 * @package    Enterprise_UrlRewrite
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_UrlRewrite_Block_Adminhtml_UrlRedirect_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Set default params
     */
    public function __construct()
    {
        $this->_objectId   = 'id';
        $this->_controller = 'adminhtml_urlRedirect';
        $this->_blockGroup = 'enterprise_urlrewrite';
        $this->_headerText = $this->__('URL Redirect');
        parent::__construct();
    }

    /**
     * Provides url for Back button
     *
     * @return string
     */
    public function getBackUrl()
    {
        if ($this->getRequest()->getParam('custom')) {
            return $this->getUrl('*/*/select');
        } else {
            return parent::getBackUrl();
        }
    }
}
