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
 * @category    Varien
 * @package     Varien_Crypt
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Crypt factory
 *
 * @category   Varien
 * @package    Varien_Crypt
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Varien_Crypt
{
    /**
     * Factory method to return requested cipher logic
     *
     * @param string $method
     * @return Varien_Crypt_Abstract
     */
    static public function factory($method='mcrypt')
    {
        $uc = str_replace(' ','_',ucwords(str_replace('_',' ',$method)));
        $className = 'Varien_Crypt_'.$uc;
        return new $className;
    }
}
