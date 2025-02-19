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
 * @package     Mage_Connect
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Extension edit page
 *
 * @category    Mage
 * @package     Mage_Connect
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Connect_Block_Adminhtml_Extension_Custom_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Constructor
     *
     * Initializes edit form container, adds necessary buttons
     */
    public function __construct()
    {
        $this->_objectId    = 'id';
        $this->_blockGroup  = 'connect';
        $this->_controller  = 'adminhtml_extension_custom';

        parent::__construct();

        $this->_removeButton('back');
        $this->_updateButton('reset', 'onclick', "resetPackage()");

        $this->_addButton('create', array(
            'label'     => Mage::helper('connect')->__('Save Data and Create Package'),
            'class'     => 'save',
            'onclick'   => "createPackage()",
        ));
        $this->_addButton('save_as', array(
            'label'     => Mage::helper('connect')->__('Save As...'),
            'title'     => Mage::helper('connect')->__('Save package with custom package file name'),
            'onclick'   => 'saveAsPackage()'
        ));
    }

    /**
    * Get header of page
    *
    * @return string
    */
    public function getHeaderText()
    {
        return Mage::helper('connect')->__('New Extension');
    }

    /*
     * Get form submit URL
     *
     * @return string
     */
    public function getFormActionUrl()
    {
        return $this->getUrl('*/*/save');
    }
}
