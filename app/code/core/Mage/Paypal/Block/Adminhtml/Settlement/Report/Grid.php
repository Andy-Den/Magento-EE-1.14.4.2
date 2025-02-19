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
 * @package     Mage_Paypal
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Adminhtml paypal settlement reports grid block
 *
 * @category    Mage
 * @package     Mage_Paypal
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Paypal_Block_Adminhtml_Settlement_Report_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Retain filter parameters in session
     *
     * @var bool
     */
    protected $_saveParametersInSession = true;

    /**
     * Constructor
     * Set main configuration of grid
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('settlementGrid');
        $this->setUseAjax(true);
    }

    /**
     * Prepare collection for grid
     * @return Mage_Paypal_Block_Adminhtml_Settlement_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('paypal/report_settlement_row_collection');
        $this->setCollection($collection);
        if (!$this->getParam($this->getVarNameSort())) {
            $collection->setOrder('row_id', 'desc');
        }
        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     * @return Mage_Paypal_Block_Adminhtml_Settlement_Grid
     */
    protected function _prepareColumns()
    {
        $settlement = Mage::getSingleton('paypal/report_settlement');
        $this->addColumn('report_date', array(
            'header'    => $settlement->getFieldLabel('report_date'),
            'index'     => 'report_date',
            'type'     => 'date'
        ));
        $this->addColumn('account_id', array(
            'header'    => $settlement->getFieldLabel('account_id'),
            'index'     => 'account_id'
        ));
        $this->addColumn('transaction_id', array(
            'header'    => $settlement->getFieldLabel('transaction_id'),
            'index'     => 'transaction_id'
        ));
        $this->addColumn('invoice_id', array(
            'header'    => $settlement->getFieldLabel('invoice_id'),
            'index'     => 'invoice_id'
        ));
        $this->addColumn('paypal_reference_id', array(
            'header'    => $settlement->getFieldLabel('paypal_reference_id'),
            'index'     => 'paypal_reference_id'
        ));
        $this->addColumn('transaction_event_code', array(
            'header'    => $settlement->getFieldLabel('transaction_event'),
            'index'     => 'transaction_event_code',
            'type'      => 'options',
            'options'   => Mage::getModel('paypal/report_settlement_row')->getTransactionEvents()
        ));
        $this->addColumn('transaction_initiation_date', array(
            'header'    => $settlement->getFieldLabel('transaction_initiation_date'),
            'index'     => 'transaction_initiation_date',
            'type'      => 'datetime'
        ));
        $this->addColumn('transaction_completion_date', array(
            'header'    => $settlement->getFieldLabel('transaction_completion_date'),
            'index'     => 'transaction_completion_date',
            'type'      => 'datetime'
        ));
        $this->addColumn('gross_transaction_amount', array(
            'header'    => $settlement->getFieldLabel('gross_transaction_amount'),
            'index'     => 'gross_transaction_amount',
            'type'      => 'currency',
            'currency'  => 'gross_transaction_currency',
        ));
        $this->addColumn('fee_amount', array(
            'header'    => $settlement->getFieldLabel('fee_amount'),
            'index'     => 'fee_amount',
            'type'      => 'currency',
            'currency'  => 'gross_transaction_currency',
        ));
        return parent::_prepareColumns();
    }

    /**
     * Return grid URL
     * @return string
     */
    public function getGridUrl()
    {
         return $this->getUrl('*/*/grid');
    }

    /**
     * Return item view URL
     * @return string
     */
    public function getRowUrl($item)
    {
        return $this->getUrl('*/*/details', array('id' => $item->getId()));
    }
}
