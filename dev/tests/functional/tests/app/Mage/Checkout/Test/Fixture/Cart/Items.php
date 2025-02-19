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

namespace Mage\Checkout\Test\Fixture\Cart;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\ObjectManager;

/**
 * Data for verify cart item block on checkout page.
 *
 * Data keys:
 *  - product (fixture data for verify)
 */
class Items extends DataSource
{
    /**
     * Item render.
     *
     * @var array
     */
    protected $itemRender = [
        'simple' => 'Mage\Catalog\Test\Fixture\Cart\Item',
        'configurable' => 'Mage\Catalog\Test\Fixture\ConfigurableProduct\Cart\Item',
        'downloadable' => 'Mage\Downloadable\Test\Fixture\Cart\Item',
        'giftcard' => 'Enterprise\GiftCard\Test\Fixture\Cart\Item',
        'virtual' => 'Mage\Catalog\Test\Fixture\Cart\Item',
        'grouped' => 'Mage\Catalog\Test\Fixture\GroupedProduct\Cart\Item',
        'bundle' => 'Mage\Bundle\Test\Fixture\Cart\Item'
    ];

    /**
     * List fixture products.
     *
     * @var FixtureInterface[]
     */
    protected $products;

    /**
     * @constructor
     * @param array $params
     * @param array $data
     */
    public function __construct(array $params, array $data = [])
    {
        $this->params = $params;
        $this->products = isset($data['products']) ? $data['products'] : [];
        foreach ($this->products as $product) {
            $this->data[] = $this->getCartItemClass($product);
        }
    }

    /**
     * Get module name from fixture.
     *
     * @param FixtureInterface $product
     * @return string
     */
    protected function getCartItemClass(FixtureInterface $product)
    {
        $typeId = $product->getDataConfig()['type_id'];
        return ObjectManager::getInstance()->create($this->itemRender[$typeId], ['product' => $product]);
    }

    /**
     * Get source products.
     *
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }
}
