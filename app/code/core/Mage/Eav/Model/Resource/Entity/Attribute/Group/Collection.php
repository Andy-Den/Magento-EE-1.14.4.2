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
 * @package     Mage_Eav
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Eav attribute group resource collection
 *
 * @category    Mage
 * @package     Mage_Eav
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Eav_Model_Resource_Entity_Attribute_Group_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Init resource model for collection
     *
     */
    protected function _construct()
    {
        $this->_init('eav/entity_attribute_group');
    }

    /**
     * Set Attribute Set Filter
     *
     * @param int $setId
     * @return Mage_Eav_Model_Resource_Entity_Attribute_Group_Collection
     */
    public function setAttributeSetFilter($setId)
    {
        $this->addFieldToFilter('attribute_set_id', array('eq' => $setId));
        $this->setOrder('sort_order');
        return $this;
    }

    /**
     * Set sort order
     *
     * @param string $direction
     * @return Mage_Eav_Model_Resource_Entity_Attribute_Group_Collection
     */
    public function setSortOrder($direction = self::SORT_ORDER_ASC)
    {
        return $this->addOrder('sort_order', $direction);
    }
}
