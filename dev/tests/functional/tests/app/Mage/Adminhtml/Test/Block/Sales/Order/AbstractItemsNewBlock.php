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
 * @category    Tests
 * @package     Tests_Functional
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

namespace Mage\Adminhtml\Test\Block\Sales\Order;

use Mage\Adminhtml\Test\Block\Sales\Order\AbstractForm\Product;
use Magento\Mtf\Block\Block;
use Magento\Mtf\Fixture\InjectableFixture;
use Magento\Mtf\Client\Locator;

/**
 * Items block on Credit Memo, Invoice, Shipment new pages.
 */
abstract class AbstractItemsNewBlock extends Block
{
    /**
     * Item product row selector.
     *
     * @var string
     */
    protected $productItem = '//tr[.//*[contains(text(),"%s")]]';

    /**
     * Item block class.
     *
     * @var string
     */
    protected $classItemBlock;

    /**
     * 'Update Qty's' button css selector.
     *
     * @var string
     */
    protected $updateQty = '.update-button';

    /**
     * Get item product block.
     *
     * @param InjectableFixture $product
     * @return Product
     */
    public function getItemProductBlock(InjectableFixture $product)
    {
        $element = $this->_rootElement->find(sprintf($this->productItem, $product->getName()), Locator::SELECTOR_XPATH);
        return $this->blockFactory->create($this->classItemBlock, ['element' => $element]);
    }

    /**
     * Click update qty button.
     *
     * @return void
     */
    public function clickUpdateQty()
    {
        $this->_rootElement->find($this->updateQty)->click();
    }
}
