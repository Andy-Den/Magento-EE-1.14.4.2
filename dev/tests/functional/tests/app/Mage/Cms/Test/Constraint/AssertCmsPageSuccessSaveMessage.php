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

namespace Mage\Cms\Test\Constraint;

use Magento\Mtf\Constraint\AbstractConstraint;
use Mage\Cms\Test\Page\Adminhtml\CmsPageIndex;

/**
 * Assert that after save a CMS page successful message appears.
 */
class AssertCmsPageSuccessSaveMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Success CMS page save message.
     */
    const SUCCESS_SAVE_MESSAGE = 'The page has been saved.';

    /**
     * Assert that after save a CMS page successful message appears.
     *
     * @param CmsPageIndex $cmsPageIndex
     * @return void
     */
    public function processAssert(CmsPageIndex $cmsPageIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            self::SUCCESS_SAVE_MESSAGE,
            $cmsPageIndex->getMessagesBlock()->getSuccessMessages()
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Success message is displayed after save a CMS page.';
    }
}
