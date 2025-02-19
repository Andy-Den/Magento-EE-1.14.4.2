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
 * @package     Mage_Directory
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/** @var Mage_Core_Model_Resource_Setup */
$installer = $this;

/** @var Varien_Db_Adapter_Pdo_Mysql */
$connection  = $this->getConnection();
$regionTable = $installer->getTable('directory/country_region');

$regionsToIns = array(
    array('RO', 'AB', 'Alba'), array('RO', 'AR', 'Arad'), array('RO', 'AG', 'Argeş'),
    array('RO', 'BC', 'Bacău'), array('RO', 'BH', 'Bihor'), array('RO', 'BN', 'Bistriţa-Năsăud'),
    array('RO', 'BT', 'Botoşani'), array('RO', 'BV', 'Braşov'), array('RO', 'BR', 'Brăila'),
    array('RO', 'B', 'Bucureşti'), array('RO', 'BZ', 'Buzău'), array('RO', 'CS', 'Caraş-Severin'),
    array('RO', 'CL', 'Călăraşi'), array('RO', 'CJ', 'Cluj'), array('RO', 'CT', 'Constanţa'),
    array('RO', 'CV', 'Covasna'), array('RO', 'DB', 'Dâmboviţa'), array('RO', 'DJ', 'Dolj'),
    array('RO', 'GL', 'Galaţi'), array('RO', 'GR', 'Giurgiu'), array('RO', 'GJ', 'Gorj'),
    array('RO', 'HR', 'Harghita'), array('RO', 'HD', 'Hunedoara'), array('RO', 'IL', 'Ialomiţa'),
    array('RO', 'IS', 'Iaşi'), array('RO', 'IF', 'Ilfov'), array('RO', 'MM', 'Maramureş'),
    array('RO', 'MH', 'Mehedinţi'), array('RO', 'MS', 'Mureş'), array('RO', 'NT', 'Neamţ'),
    array('RO', 'OT', 'Olt'), array('RO', 'PH', 'Prahova'), array('RO', 'SM', 'Satu-Mare'),
    array('RO', 'SJ', 'Sălaj'), array('RO', 'SB', 'Sibiu'), array('RO', 'SV', 'Suceava'),
    array('RO', 'TR', 'Teleorman'), array('RO', 'TM', 'Timiş'), array('RO', 'TL', 'Tulcea'),
    array('RO', 'VS', 'Vaslui'), array('RO', 'VL', 'Vâlcea'), array('RO', 'VN', 'Vrancea')
);

foreach ($regionsToIns as $row) {
    if (! ($connection->fetchOne("SELECT 1 FROM `{$regionTable}` WHERE `country_id` = :country_id && `code` = :code", array('country_id' => $row[0], 'code' => $row[1])))) {
        $connection->insert($regionTable, array(
            'country_id'   => $row[0],
            'code'         => $row[1],
            'default_name' => $row[2]
        ));
    }
}
