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
 * @package     Enterprise_Customer
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Customer Address abstract model
 *
 */
abstract class Enterprise_Customer_Model_Sales_Address_Abstract extends Enterprise_Customer_Model_Sales_Abstract
{
    /**
     * Attach data to collection
     *
     * @param Varien_Data_Collection_Db $collection
     * @return Enterprise_Customer_Model_Sales_Address_Abstract
     */
    public function attachDataToCollection(Varien_Data_Collection_Db $collection)
    {
        $this->_getResource()->attachDataToCollection($collection);
        return $this;
    }
}
