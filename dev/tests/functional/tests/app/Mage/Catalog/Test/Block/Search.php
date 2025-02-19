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

namespace Mage\Catalog\Test\Block;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Block for search field.
 */
class Search extends Block
{
    /**
     * Selector matches found - "Suggest Search".
     *
     * @var string
     */
    protected $searchAutocomplete = './/div[@id="search_autocomplete"]//li[text()="%s"]';

    /**
     * Selector number of matches for a given row.
     *
     * @var string
     */
    protected $searchItemAmount = '/span[@class="amount" and text()="%d"]';

    /**
     * Search field.
     *
     * @var string
     */
    protected $searchInput = '#search';

    /**
     * Search button.
     *
     * @var string
     */
    private $searchButton = '[title="Search"]';

    /**
     * Search products by a keyword
     *
     * @param string $keyword
     * @return void
     *
     * @SuppressWarnings(PHPMD.ConstructorWithNameAsEnclosingClass)
     */
    public function search($keyword)
    {
        $this->fillSearch($keyword);
        $this->_rootElement->find($this->searchButton, Locator::SELECTOR_CSS)->click();
    }

    /**
     * Fills the search field
     *
     * @param string $text
     * @return void
     */
    public function fillSearch($text)
    {
        $this->_rootElement->find($this->searchInput, Locator::SELECTOR_CSS)->setValue($text);
    }

    /**
     * Checking block visibility "Suggest Search"
     *
     * @param string $text
     * @param int|null $amount
     * @return bool
     */
    public function isSuggestSearchVisible($text, $amount = null)
    {
        $searchAutocomplete = sprintf($this->searchAutocomplete, $text);
        if ($amount !== null) {
            $searchAutocomplete .= sprintf($this->searchItemAmount, $amount);
        }

        $rootElement = $this->_rootElement;
        return (bool)$this->_rootElement->waitUntil(
            function () use ($rootElement, $searchAutocomplete) {
                return $rootElement->find($searchAutocomplete, Locator::SELECTOR_XPATH)->isVisible() ? true : null;
            }
        );
    }
}
