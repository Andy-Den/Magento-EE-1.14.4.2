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

namespace Mage\Admin\Test\Constraint;

use Magento\Mtf\Constraint\AbstractConstraint;
use Mage\Adminhtml\Test\Page\AdminAuthLogin;

/**
 * Assert that error message "This account is locked." is present in log in to backend page.
 */
class AssertUserIsLockedMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Text for verify.
     */
    const ERROR_MESSAGE = 'You did not sign in correctly or your account is temporarily disabled.';

    /**
     * Assert that error message "This account is locked." is present in log in to backend page.
     *
     * @param AdminAuthLogin $adminAuth
     * @return void
     */
    public function processAssert(AdminAuthLogin $adminAuth)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            self::ERROR_MESSAGE,
            $adminAuth->getMessagesBlock()->getErrorMessages()
        );
    }

    /**
     * Return string representation of object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Admin user account is locked.';
    }
}
