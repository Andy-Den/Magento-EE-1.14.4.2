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
 * @package     Mage_Adminhtml
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Categories tree with checkboxes
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_Catalog_Category_Checkboxes_Tree extends Mage_Adminhtml_Block_Catalog_Category_Tree
{
    protected $_selectedIds = array();

    protected function _prepareLayout()
    {
        $this->setTemplate('catalog/category/checkboxes/tree.phtml');
    }

    public function getCategoryIds()
    {
        return $this->_selectedIds;
    }

    public function setCategoryIds($ids)
    {
        if (empty($ids)) {
            $ids = array();
        }
        elseif (!is_array($ids)) {
            $ids = array((int)$ids);
        }
        $this->_selectedIds = $ids;
        return $this;
    }

    protected function _getNodeJson($node, $level = 1)
    {
        $item = array();
        $item['text']= $this->escapeHtml($node->getName());

        if ($this->_withProductCount) {
             $item['text'].= ' ('.$node->getProductCount().')';
        }
        $item['id']  = $node->getId();
        $item['path'] = $node->getData('path');
        $item['cls'] = 'folder ' . ($node->getIsActive() ? 'active-category' : 'no-active-category');
        $item['allowDrop'] = false;
        $item['allowDrag'] = false;

        if ($node->hasChildren()) {
            $item['children'] = array();
            foreach ($node->getChildren() as $child) {
                $item['children'][] = $this->_getNodeJson($child, $level + 1);
            }
        }

        if (empty($item['children']) && (int)$node->getChildrenCount() > 0) {
            $item['children'] = array();
        }

        if (!empty($item['children'])) {
            $item['expanded'] = true;
        }

        if (in_array($node->getId(), $this->getCategoryIds())) {
            $item['checked'] = true;
        }

        return $item;
    }

    public function getRoot($parentNodeCategory=null, $recursionLevel=3)
    {
        return $this->getRootByIds($this->getCategoryIds());
    }
}
