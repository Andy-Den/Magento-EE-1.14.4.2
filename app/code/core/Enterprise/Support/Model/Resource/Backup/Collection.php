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
 * @package     Enterprise_Support
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

class Enterprise_Support_Model_Resource_Backup_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Init Collection
     */
    protected function _construct()
    {
        $this->_init('enterprise_support/backup');
    }

    /**
     * Get Backups with status processing
     *
     * @return Enterprise_Support_Model_Resource_Backup_Collection
     */
    public function addProcessingStatusFilter()
    {
        $this->addFieldToFilter('status', array('eq' => Enterprise_Support_Model_Backup::STATUS_PROCESSING));

        return $this;
    }


    /**
     * Filter Backups where status not failed
     *
     * @return $this
     */
    public function removeBackupsWhereStatusFailed()
    {
        $this->addFieldToFilter('status', array('neq' => Enterprise_Support_Model_Backup::STATUS_FAILED));

        return $this;
    }
}
