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

namespace Mage\CatalogRule\Test\TestCase;

use Mage\Catalog\Test\Fixture\CatalogProductSimple;

/**
 * Preconditions:
 *  1. Execute before each variation:
 *   - Delete all active catalog price rules.
 *   - Create catalog price rule from dataset using Curl.
 *
 * Steps:
 *  1. Apply all created rules.
 *  2. Create simple product.
 *  3. Perform all assertions.
 *
 * @group Catalog_Price_Rules_(MX)
 * @ZephyrId MPERF-6801
 */
class ApplySeveralCatalogPriceRuleEntityTest extends AbstractCatalogRuleEntityTest
{
    /**
     * Apply several catalog price rules.
     *
     * @param array $catalogRulesOriginal
     * @return array
     */
    public function test(array $catalogRulesOriginal)
    {
        // Steps:
        $this->catalogRuleIndex->open();
        foreach ($catalogRulesOriginal as $key => $catalogPriceRule) {
            if ($catalogPriceRule === '-') {
                continue;
            }
            $this->catalogRules[$key] = $this->fixtureFactory->createByCode(
                'catalogRule',
                ['dataset' => $catalogPriceRule]
            );
            $this->catalogRules[$key]->persist();

            $filter = [
                'name' => $this->catalogRules[$key]->getName(),
                'rule_id' => $this->catalogRules[$key]->getId(),
            ];
            $this->catalogRuleIndex->getCatalogRuleGrid()->searchAndOpen($filter);
            $this->catalogRuleEdit->getFormPageActions()->saveAndApply();
        }
        // Create product
        $productSimple = $this->fixtureFactory->createByCode(
            'catalogProductSimple',
            ['dataset' => 'simple_for_salesrule_1']
        );
        $productSimple->persist();

        return ['product' => $productSimple];
    }
}
