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
 * @package     Enterprise_Catalog
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Refresh category flat index row
 *
 * @category    Enterprise
 * @package     Enterprise_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_Catalog_Model_Index_Action_Product_Price_Refresh_Row
    extends Enterprise_Catalog_Model_Index_Action_Product_Price_Refresh_Changelog
{
    /**
     * Value for updating mview table
     *
     * @var mixed
     */
    protected $_keyColumnIdValue;

    /**
     * Constructor with parameters
     * Array of arguments with keys
     *  - 'metadata' Enterprise_Mview_Model_Metadata
     *  - 'connection' Varien_Db_Adapter_Interface
     *  - 'factory' Enterprise_Mview_Model_Factory
     *  - 'value' mixed
     *
     * @param array $args
     */
    public function __construct(array $args)
    {
        parent::__construct($args);
        if (isset($args['value'])) {
            $this->_keyColumnIdValue = $args['value'];
        }
    }

    /**
     * Execute refresh row action
     *
     * @return Enterprise_Catalog_Model_Index_Action_Product_Price_Refresh_Row
     * @throws Enterprise_Index_Model_Action_Exception
     */
    public function execute()
    {
        $this->_validate();
        try {
            $this->_connection->beginTransaction();
            $affectedIds = $this->_reindex(array($this->_keyColumnIdValue));
            $this->_connection->commit();
            Mage::dispatchEvent('catalog_product_price_partial_reindex', array('product_ids' => $affectedIds));
        } catch (Exception $e) {
            $this->_connection->rollBack();
            throw new Enterprise_Index_Model_Action_Exception($e->getMessage(), $e->getCode(), $e);
        }
        return $this;
    }
}
