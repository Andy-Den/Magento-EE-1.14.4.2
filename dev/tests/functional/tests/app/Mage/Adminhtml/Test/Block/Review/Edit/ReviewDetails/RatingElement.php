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

namespace Mage\Adminhtml\Test\Block\Review\Edit\ReviewDetails;

use Magento\Mtf\Client\Locator;
use Magento\Mtf\Client\Element\SimpleElement;

/**
 * Rating typified element.
 */
class RatingElement extends SimpleElement
{
    /**
     * Selector for label of checked rating.
     *
     * @var string
     */
    protected $checkedRating = 'input:checked';

    /**
     * Selector for rating title.
     *
     * @var string
     */
    protected $ratingTitle = '//*[@id="product-review-table"]/tbody/tr/td[1]';

    /**
     * Get ratings list.
     *
     * @return array
     */
    public function getValue()
    {
        $result = [];
        $ratings = $this->getElements($this->checkedRating, Locator::SELECTOR_CSS, 'checkbox');
        $titles = $this->getElements($this->ratingTitle, Locator::SELECTOR_XPATH);
        foreach ($ratings as $key => $rating) {
            $ratingTitle = $titles[$key]->getText();
            $result[] = [
                'title' => $ratingTitle,
                'rating' => $this->prepareFormatValue($rating->getAttribute('id'), $ratingTitle)
            ];
        }

        return $result;
    }

    /**
     * Prepare format for rating value.
     *
     * @param string $value
     * @param string $replace
     * @return string
     */
    protected function prepareFormatValue($value, $replace)
    {
        return str_replace($replace . '_', '', $value);
    }
}
