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

namespace Mage\Tax\Test\TestStep;

use Mage\Tax\Test\Page\Adminhtml\TaxRuleIndex;
use Mage\Tax\Test\Page\Adminhtml\TaxRuleNew;
use Magento\Mtf\TestStep\TestStepInterface;

/**
 * Delete all Tax Rule on backend.
 */
class DeleteAllTaxRulesStep implements TestStepInterface
{
    /**
     * Tax Rule grid page.
     *
     * @var TaxRuleIndex
     */
    protected $taxRuleIndexPage;

    /**
     * Tax Rule new and edit page.
     *
     * @var TaxRuleNew
     */
    protected $taxRuleNewPage;

    /**
     * @constructor
     * @param TaxRuleIndex $taxRuleIndexPage
     * @param TaxRuleNew $taxRuleNewPage
     */
    public function __construct(TaxRuleIndex $taxRuleIndexPage, TaxRuleNew $taxRuleNewPage)
    {
        $this->taxRuleIndexPage = $taxRuleIndexPage;
        $this->taxRuleNewPage = $taxRuleNewPage;
    }

    /**
     * Delete all Tax Rules on backend.
     *
     * @return array
     */
    public function run()
    {
        $this->taxRuleIndexPage->open();
        $this->taxRuleIndexPage->getTaxRuleGrid()->resetFilter();
        while ($this->taxRuleIndexPage->getTaxRuleGrid()->isFirstRowVisible()) {
            $this->taxRuleIndexPage->getTaxRuleGrid()->openFirstRow();
            $this->taxRuleNewPage->getFormPageActions()->delete();
        }
    }
}
