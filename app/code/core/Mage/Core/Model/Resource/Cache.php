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
 * Core Cache resource model
 *
 * @category    Mage
 * @package     Mage_Core
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Core_Model_Resource_Cache extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Define main table
     *
     */
    protected function _construct()
    {
        $this->_init('core/cache_option', 'code');
    }

    /**
     * Get all cache options
     *
     * @return array | false
     */
    public function getAllOptions()
    {
        $adapter = $this->_getReadAdapter();
        if ($adapter) {
            /**
             * Check if table exist (it protect upgrades. cache settings checked before upgrades)
             */
            if ($adapter->isTableExists($this->getMainTable())) {
                $select = $adapter->select()
                    ->from($this->getMainTable(), array('code', 'value'));
                return $adapter->fetchPairs($select);
            }
        }
        return false;
    }

    /**
     * Save all options to option table
     *
     * @param array $options
     * @return Mage_Core_Model_Resource_Cache
     * @throws Exception
     */
    public function saveAllOptions($options)
    {
        $adapter = $this->_getWriteAdapter();
        if (!$adapter) {
            return $this;
        }

        $data = array();
        foreach ($options as $code => $value) {
            $data[] = array($code, $value);
        }

        $adapter->beginTransaction();
        try {
            $this->_getWriteAdapter()->delete($this->getMainTable());
            if ($data) {
                $this->_getWriteAdapter()->insertArray($this->getMainTable(), array('code', 'value'), $data);
            }
        } catch (Exception $e) {
            $adapter->rollback();
            throw $e;
        }
        $adapter->commit();

        return $this;
    }
}
