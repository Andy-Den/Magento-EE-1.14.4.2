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
 * Tab for Design Management
 *
 * @category    Mage
 * @package     Mage_XmlConnect
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_XmlConnect_Block_Adminhtml_Mobile_Edit_Tab_Design
    extends Mage_Adminhtml_Block_Template
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Set design tab template
     * Set to show global icon
     */
    public function __construct()
    {
        parent::__construct();
        $this->setShowGlobalIcon(true);
        $this->setTemplate('xmlconnect/edit/tab/design.phtml');
    }

    /**
     * Tab label getter
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('Design');
    }

    /**
     * Tab title getter
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('Design');
    }

    /**
     * Check if tab can be shown
     *
     * @return bool
     */
    public function canShowTab()
    {
        return (bool) !Mage::getSingleton('adminhtml/session')->getNewApplication();
    }

    /**
     * Check if tab hidden
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check if we have to show Preview Block
     *
     * @return bool
     */
    public function canShowPreview()
    {
        return true;
    }

    /**
     * Create browse button template
     *
     * @return string
     */
    public function getBrowseButtonHtml()
    {
        return $this->getLayout()->createBlock('adminhtml/widget_button')
            ->addData(array(
                'before_html'   => '<div style="display:inline-block; " id="{{file_field}}_{{id}}_file-browse">',
                'after_html'    => '</div>',
                'id'            => '{{file_field}}_{{id}}_file-browse_button',
                'label'         => Mage::helper('uploader')->__('...'),
                'type'          => 'button',
            ))->toHtml();
    }
}
