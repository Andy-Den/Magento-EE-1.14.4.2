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
 * @package     Mage_Core
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Store group resource model
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Core_Model_Resource_Store_Group extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Define main table
     *
     */
    protected function _construct()
    {
        $this->_init('core/store_group', 'group_id');
    }

    /**
     * Update default store group for website
     *
     * @param Mage_Core_Model_Abstract $model
     * @return Mage_Core_Model_Resource_Store_Group
     */
    protected function _afterSave(Mage_Core_Model_Abstract $model)
    {
        $this->_updateStoreWebsite($model->getId(), $model->getWebsiteId());
        $this->_updateWebsiteDefaultGroup($model->getWebsiteId(), $model->getId());
        $this->_changeWebsite($model);

        return $this;
    }

    /**
     * Update default store group for website
     *
     * @param int $websiteId
     * @param int $groupId
     * @return Mage_Core_Model_Resource_Store_Group
     */
    protected function _updateWebsiteDefaultGroup($websiteId, $groupId)
    {
        $select = $this->_getWriteAdapter()->select()
            ->from($this->getMainTable(), 'COUNT(*)')
            ->where('website_id = :website');
        $count  = $this->_getWriteAdapter()->fetchOne($select, array('website' => $websiteId));

        if ($count == 1) {
            $bind  = array('default_group_id' => $groupId);
            $where = array('website_id = ?' => $websiteId);
            $this->_getWriteAdapter()->update($this->getTable('core/website'), $bind, $where);
        }
        return $this;
    }

    /**
     * Change store group website
     *
     * @param Mage_Core_Model_Abstract $model
     * @return Mage_Core_Model_Resource_Store_Group
     */
    protected function _changeWebsite(Mage_Core_Model_Abstract $model)
    {
        if ($model->getOriginalWebsiteId() && $model->getWebsiteId() != $model->getOriginalWebsiteId()) {
            $select = $this->_getWriteAdapter()->select()
               ->from($this->getTable('core/website'), 'default_group_id')
               ->where('website_id = :website_id');
            $groupId = $this->_getWriteAdapter()->fetchOne($select, array('website_id' => $model->getOriginalWebsiteId()));

            if ($groupId == $model->getId()) {
                $bind  = array('default_group_id' => 0);
                $where = array('website_id = ?' => $model->getOriginalWebsiteId());
                $this->_getWriteAdapter()->update($this->getTable('core/website'), $bind, $where);
            }
        }
        return $this;
    }

    /**
     * Update website for stores that assigned to store group
     *
     * @param int $groupId
     * @param int $websiteId
     * @return Mage_Core_Model_Resource_Store_Group
     */
    protected function _updateStoreWebsite($groupId, $websiteId)
    {
        $bind  = array('website_id' => $websiteId);
        $where = array('group_id = ?' => $groupId);
        $this->_getWriteAdapter()->update($this->getTable('core/store'), $bind, $where);
        return $this;
    }

    /**
     * Save default store for store group
     *
     * @param int $groupId
     * @param int $storeId
     * @return Mage_Core_Model_Resource_Store_Group
     */
    protected function _saveDefaultStore($groupId, $storeId)
    {
        $bind  = array('default_store_id' => $storeId);
        $where = array('group_id = ?' => $groupId);
        $this->_getWriteAdapter()->update($this->getMainTable(), $bind, $where);

        return $this;
    }
}
