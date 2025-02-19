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

namespace Mage\Adminhtml\Test\Block\Review;

use Mage\Adminhtml\Test\Block\Widget\FormTabs;
use Magento\Mtf\Client\Locator;
use Mage\Adminhtml\Test\Block\Widget\Tab;

/**
 * Review form on backend review page.
 */
class ReviewForm extends FormTabs
{
    /**
     * Rating status
     *
     * @var string
     */
    protected $status = '[name=status_id]';

    /**
     * Open tab.
     *
     * @param string $tabName
     * @return Tab
     */
    public function openTab($tabName)
    {
        return $this;
    }

    /**
     * Set approve review.
     *
     * @return void
     */
    public function setApproveReview()
    {
        $this->_rootElement->find($this->status, Locator::SELECTOR_CSS, 'select')->setValue('Approved');
    }
}
