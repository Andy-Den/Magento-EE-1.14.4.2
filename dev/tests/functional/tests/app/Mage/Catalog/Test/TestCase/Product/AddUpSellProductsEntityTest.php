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

namespace Mage\Catalog\Test\TestCase\Product;

/**
 * Preconditions:
 * 1. Create Simple Product.
 * 2. Create Configurable Product.
 *
 * Steps:
 * 1. Open Backend.
 * 2. Go to Products -> Catalog.
 * 3. Press "Add product" button.
 * 4. Fill data according to dataset.
 * 5. Save product.
 * 6. Perform all assertions.
 *
 * @group Up-sells_(MX)
 * @ZephyrId MPERF-6834
 */
class AddUpSellProductsEntityTest extends AbstractAddAppurtenantProductsEntityTest
{
    /**
     * Run test add up sell products.
     *
     * @param string $productData
     * @param string $upSellProductsData
     * @return array
     */
    public function test($productData, $upSellProductsData)
    {
        $product = $this->getProductByData($productData, ['up_sell_products' => $upSellProductsData]);
        $this->createAndSaveProduct($product);

        return [
            'product' => $product,
            'upSellProducts' => $product->getDataFieldConfig('up_sell_products')['source']->getProducts()
        ];
    }
}
