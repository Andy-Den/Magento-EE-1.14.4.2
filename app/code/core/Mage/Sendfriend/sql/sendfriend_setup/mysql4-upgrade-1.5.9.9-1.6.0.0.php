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
 * @package     Mage_Sendfriend
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/* @var $installer Mage_Sendfriend_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/**
 * Drop indexes
 */
$installer->getConnection()->dropIndex(
    $installer->getTable('sendfriend/sendfriend'),
    'IDX_REMOTE_ADDR'
);

$installer->getConnection()->dropIndex(
    $installer->getTable('sendfriend/sendfriend'),
    'IDX_LOG_TIME'
);


/**
 * Change columns
 */
$tables = array(
    $installer->getTable('sendfriend/sendfriend') => array(
        'columns' => array(
            'log_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'identity'  => true,
                'unsigned'  => true,
                'nullable'  => false,
                'primary'   => true,
                'comment'   => 'Log ID'
            ),
            'ip' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_BIGINT,
                'length'    => 20,
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
                'comment'   => 'Customer IP address'
            ),
            'time' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
                'comment'   => 'Log time'
            ),
            'website_id' => array(
                'type'      => Varien_Db_Ddl_Table::TYPE_SMALLINT,
                'unsigned'  => true,
                'nullable'  => false,
                'default'   => '0',
                'comment'   => 'Website ID'
            )
        ),
        'comment' => 'Send to friend function log storage table',
        'engine'  => 'InnoDB'
    )
);

$installer->getConnection()->modifyTables($tables);

/**
 * Add indexes
 */
$installer->getConnection()->addIndex(
    $installer->getTable('sendfriend/sendfriend'),
    $installer->getIdxName('sendfriend/sendfriend', array('ip')),
    array('ip')
);

$installer->getConnection()->addIndex(
    $installer->getTable('sendfriend/sendfriend'),
    $installer->getIdxName('sendfriend/sendfriend', array('time')),
    array('time')
);

$installer->endSetup();
