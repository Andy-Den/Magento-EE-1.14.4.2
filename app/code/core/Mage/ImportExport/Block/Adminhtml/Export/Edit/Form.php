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
 * @package     Mage_ImportExport
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Export edit form block
 *
 * @category    Mage
 * @package     Mage_ImportExport
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_ImportExport_Block_Adminhtml_Export_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare form before rendering HTML.
     *
     * @return Mage_ImportExport_Block_Adminhtml_Export_Edit_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'     => 'edit_form',
            'action' => $this->getUrl('*/*/getFilter'),
            'method' => 'post'
        ));
        $fieldset = $form->addFieldset('base_fieldset', array('legend' => Mage::helper('importexport')->__('Export Settings')));
        $fieldset->addField('entity', 'select', array(
            'name'     => 'entity',
            'title'    => Mage::helper('importexport')->__('Entity Type'),
            'label'    => Mage::helper('importexport')->__('Entity Type'),
            'required' => false,
            'onchange' => 'editForm.getFilter();',
            'values'   => Mage::getModel('importexport/source_export_entity')->toOptionArray()
        ));
        $fieldset->addField('file_format', 'select', array(
            'name'     => 'file_format',
            'title'    => Mage::helper('importexport')->__('Export File Format'),
            'label'    => Mage::helper('importexport')->__('Export File Format'),
            'required' => false,
            'values'   => Mage::getModel('importexport/source_export_format')->toOptionArray()
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
