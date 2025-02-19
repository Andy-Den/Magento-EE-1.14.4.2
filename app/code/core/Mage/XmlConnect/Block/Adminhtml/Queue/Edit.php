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
 * Xmlconnect queue edit block
 *
 * @category    Mage
 * @package     Mage_XmlConnect
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_XmlConnect_Block_Adminhtml_Queue_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_objectId    = 'id';
        $this->_controller  = 'adminhtml_queue';
        $this->_blockGroup  = 'xmlconnect';
        parent::__construct();

        $message = Mage::registry('current_message');
        if ($message && $message->getStatus() != Mage_XmlConnect_Model_Queue::STATUS_IN_QUEUE) {
            $this->_removeButton('reset');
            $this->_removeButton('save');
        } else {
            $this->_updateButton('save', 'label', $this->__('Queue Message'));
            $this->_updateButton('save', 'onclick', 'if (editForm.submit()) {disableElements(\'save\')}');
        }
        $this->_removeButton('delete');

        $this->_updateButton('back', 'onclick', 'setLocation(\'' . $this->getBackUrl() . '\')');
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        $template = Mage::registry('current_template');
        $message  = Mage::registry('current_message');
        return $message && !$message->getId() && $template && $template->getId() ? $this->getUrl('*/*/template')
            : $this->getUrl('*/*/queue');
    }

    /**
     * Get header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        $message = Mage::registry('current_message');
        if ($message && $message->getId()) {
            return $this->__('Edit AirMail Message Queue #%s', $this->escapeHtml($message->getId()));
        } else {
            return $this->__('New AirMail Message Queue');
        }
    }
}
