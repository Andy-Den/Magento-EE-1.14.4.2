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
 * @package     Mage_Catalog
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Catalog Product Relations Resource model
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Catalog_Model_Resource_Product_Relation extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource model and define main table
     *
     */
    protected function _construct()
    {
        $this->_init('catalog/product_relation', 'parent_id');
    }

    /**
     * Save (rebuild) product relations
     *
     * @param int $parentId
     * @param array $childIds
     * @return Mage_Catalog_Model_Resource_Product_Relation
     */
    public function processRelations($parentId, $childIds)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getMainTable(), array('child_id'))
            ->where('parent_id = ?', $parentId);
        $old = $this->_getReadAdapter()->fetchCol($select);
        $new = $childIds;

        $insert = array_diff($new, $old);
        $delete = array_diff($old, $new);

        if (!empty($insert)) {
            $insertData = array();
            foreach ($insert as $childId) {
                $insertData[] = array(
                    'parent_id' => $parentId,
                    'child_id'  => $childId
                );
            }
            $this->_getWriteAdapter()->insertMultiple($this->getMainTable(), $insertData);
        }
        if (!empty($delete)) {
            $where = join(' AND ', array(
                $this->_getWriteAdapter()->quoteInto('parent_id = ?', $parentId),
                $this->_getWriteAdapter()->quoteInto('child_id IN(?)', $delete)
            ));
            $this->_getWriteAdapter()->delete($this->getMainTable(), $where);
        }

        return $this;
    }
}
