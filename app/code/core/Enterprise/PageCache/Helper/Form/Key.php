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
 * @category    Enterprise
 * @package     Enterprise_PageCache
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */
/**
 * PageCache Form Key helper
 *
 * @category    Enterprise
 * @package     Enterprise_PageCache
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_PageCache_Helper_Form_Key extends Mage_Core_Helper_Abstract
{
    /**
     * Retrieve unique marker value
     *
     * @return string
     */
    protected static function _getFormKeyMarker()
    {
        return Enterprise_PageCache_Helper_Data::wrapPlaceholderString('_FORM_KEY_MARKER_');
    }

    /**
     * Replace form key with placeholder string
     *
     * @param string $content
     * @return bool
     */
    public static function replaceFormKey(&$content)
    {
        if (!$content) {
            return $content;
        }
        /** @var $session Mage_Core_Model_Session */
        $session = Mage::getSingleton('core/session');
        $replacementCount = 0;
        $content = str_replace($session->getFormKey(), self::_getFormKeyMarker(), $content, $replacementCount);
        return ($replacementCount > 0);
    }

    /**
     * Restore user form key in form key placeholders
     *
     * @param string $content
     * @param string $formKey
     * @return bool
     */
    public static function restoreFormKey(&$content, $formKey)
    {
        if (!$content) {
            return false;
        }
        $replacementCount = 0;
        $content = str_replace(self::_getFormKeyMarker(), $formKey, $content, $replacementCount);
        return ($replacementCount > 0);
    }

    /**
     * Get form key cache id
     *
     * @param boolean $renew
     * @return string
     */
    public static function getFormKeyCacheId($renew = false)
    {
        $formKeyId = Enterprise_PageCache_Model_Cookie::getFormKeyCookieValue();
        if ($renew && $formKeyId) {
            Enterprise_PageCache_Model_Cache::getCacheInstance()->remove(self::getFormKeyCacheId());
            $formKeyId = false;
            Mage::unregister('cached_form_key_id');
        }
        if (!$formKeyId) {
            if (!$formKeyId = Mage::registry('cached_form_key_id')) {
                $formKeyId = Enterprise_PageCache_Helper_Data::getRandomString(16);
                Enterprise_PageCache_Model_Cookie::setFormKeyCookieValue($formKeyId);
                Mage::register('cached_form_key_id', $formKeyId);
            }
        }
        return $formKeyId;
    }

    /**
     * Get cached form key
     *
     * @param boolean $renew
     * @return string
     */
    public static function getFormKey($renew = false)
    {
        $formKeyId = self::getFormKeyCacheId($renew);
        $formKey = Enterprise_PageCache_Model_Cache::getCacheInstance()->load($formKeyId);
        if ($renew) {
            $formKey = Enterprise_PageCache_Helper_Data::getRandomString(16);
            Enterprise_PageCache_Model_Cache::getCacheInstance()
                ->save($formKey, $formKeyId, array(Enterprise_PageCache_Model_Processor::CACHE_TAG));
        }
        return $formKey;
    }
}
