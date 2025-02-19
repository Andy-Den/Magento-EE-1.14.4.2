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

namespace Mage\Wishlist\Test\Block\Customer\Wishlist;

use Mage\Wishlist\Test\Block\Customer\Wishlist\Items\Product;
use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;
use Magento\Mtf\Fixture\InjectableFixture;

/**
 * Customer wishlist items block on frontend.
 */
class Items extends Block
{
    /**
     * Item product block.
     *
     * @var string
     */
    protected $itemProductBlock = '//tbody//tr[.//h3[@class="product-name" and *[text()="%s"]]]';

    /**
     * Get item product block.
     *
     * @param InjectableFixture $product
     * @return Product
     */
    public function getItemProductBlock(InjectableFixture $product)
    {
        $selector = sprintf($this->itemProductBlock, $product->getName());
        return $this->blockFactory->create(
            'Mage\Wishlist\Test\Block\Customer\Wishlist\Items\Product',
            ['element' => $this->_rootElement->find($selector, Locator::SELECTOR_XPATH)]
        );
    }
}
