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
 * @package     Mage_Adminhtml
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Admin tax rate save toolbar
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Mage_Adminhtml_Block_Tax_Rate_Toolbar_Save extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->assign('createUrl', $this->getUrl('*/tax_rate/save'));
        $this->setTemplate('tax/toolbar/rate/save.phtml');
    }

    protected function _prepareLayout()
    {
        $this->setChild('backButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('tax')->__('Back'),
                    'onclick'   => 'window.location.href=\''.$this->getUrl('*/*/').'\'',
                    'class' => 'back'
                ))
        );

        $this->setChild('resetButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('tax')->__('Reset'),
                    'onclick'   => 'window.location.reload()'
                ))
        );

        $this->setChild('saveButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('tax')->__('Save Rate'),
                    'onclick'   => 'wigetForm.submit();return false;',
                    'class' => 'save'
                ))
        );

        $this->setChild('deleteButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('tax')->__('Delete Rate'),
                    'onclick'   => 'deleteConfirm(\''
                        . Mage::helper('core')->jsQuoteEscape(
                            Mage::helper('tax')->__('Are you sure you want to do this?')
                        )
                        . '\', \''
                        . $this->getUrl('*/*/delete', array('rate' => $this->getRequest()->getParam('rate')))
                        . '\')',
                    'class' => 'delete'
                ))
        );
        return parent::_prepareLayout();
    }

    public function getBackButtonHtml()
    {
        return $this->getChildHtml('backButton');
    }

    public function getResetButtonHtml()
    {
        return $this->getChildHtml('resetButton');
    }

    public function getSaveButtonHtml()
    {
        return $this->getChildHtml('saveButton');
    }

    public function getDeleteButtonHtml()
    {
        if( intval($this->getRequest()->getParam('rate')) == 0 ) {
            return;
        }
        return $this->getChildHtml('deleteButton');
    }
}
