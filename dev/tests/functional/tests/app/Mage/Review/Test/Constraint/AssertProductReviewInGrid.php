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

namespace Mage\Review\Test\Constraint;

use Mage\Review\Test\Fixture\Review;
use Mage\Review\Test\Page\Adminhtml\CatalogProductReview;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Mtf\Fixture\InjectableFixture;

/**
 * Check that review is displayed in grid.
 */
class AssertProductReviewInGrid extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Filter params.
     *
     * @var array
     */
    public $filter = [
        'review_id',
        'status_id',
        'title',
        'nickname',
        'detail',
        'type',
        'name',
        'sku',
    ];

    /**
     * Assert that review is displayed in grid.
     *
     * @param CatalogProductReview $reviewIndex
     * @param Review $review
     * @param InjectableFixture $product
     * @param string $gridStatus [optional]
     * @return void
     */
    public function processAssert(
        CatalogProductReview $reviewIndex,
        Review $review,
        InjectableFixture $product,
        $gridStatus = ''
    ) {
        $reviewIndex->open();
        $filter = $this->prepareFilter($product, $review->getData(), $gridStatus);
        \PHPUnit_Framework_Assert::assertTrue(
            $reviewIndex->getReviewGrid()->isRowVisible($filter),
            'Review is absent in Review grid.'
        );
    }

    /**
     * Prepare filter for assert
     *
     * @param InjectableFixture $product
     * @param array $review
     * @param string $gridStatus [optional]
     * @return array
     */
    public function prepareFilter(InjectableFixture $product, array $review, $gridStatus = '')
    {
        $filter = [];
        foreach ($this->filter as $field) {
            switch ($field) {
                case 'name':
                case 'sku':
                    $value = $product->getData($field);
                    break;
                case 'status_id':
                    $value = $gridStatus !== '' ? $gridStatus : (isset($review[$field]) ? $review[$field] : null);
                    break;
                default:
                    $value = isset($review[$field]) ? $review[$field] : null;
                    break;
            }
            if ($value !== null) {
                $filter += [$field => $value];
            }
        }
        return $filter;
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Review is present in grid on product reviews tab.';
    }
}
