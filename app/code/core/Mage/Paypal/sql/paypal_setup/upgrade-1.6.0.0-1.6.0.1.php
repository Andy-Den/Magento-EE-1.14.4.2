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

/** @var $installer Mage_Paypal_Model_Resource_Setup */
$installer = $this;

/**
 * Create table 'paypal/payment_transaction'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('paypal/payment_transaction'))
    ->addColumn('transaction_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Entity Id')
    ->addColumn('txn_id', Varien_Db_Ddl_Table::TYPE_TEXT, 100, array(
        ), 'Txn Id')
    ->addColumn('additional_information', Varien_Db_Ddl_Table::TYPE_BLOB, '64K', array(
        ), 'Additional Information')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Created At')
    ->addIndex(
        $installer->getIdxName(
            'paypal/payment_transaction',
            array('txn_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        array('txn_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->setComment('PayPal Payflow Link Payment Transaction');
$installer->getConnection()->createTable($table);
