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
 * @category    Mage
 * @package     Mage_Core
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Magento Core Exception
 *
 * This class will be extended by other modules
 *
 * @category   Mage
 * @package    Mage_Core
 */
class Mage_Core_Exception extends Exception
{
    protected $_messages = array();

    public function addMessage(Mage_Core_Model_Message_Abstract $message)
    {
        if (!isset($this->_messages[$message->getType()])) {
            $this->_messages[$message->getType()] = array();
        }
        $this->_messages[$message->getType()][] = $message;
        return $this;
    }

    public function getMessages($type='')
    {
        if ('' == $type) {
            $arrRes = array();
            foreach ($this->_messages as $messageType => $messages) {
                $arrRes = array_merge($arrRes, $messages);
            }
            return $arrRes;
        }
        return isset($this->_messages[$type]) ? $this->_messages[$type] : array();
    }

    /**
     * Set or append a message to existing one
     *
     * @param string $message
     * @param bool $append
     * @return Mage_Core_Exception
     */
    public function setMessage($message, $append = false)
    {
        if ($append) {
            $this->message .= $message;
        } else {
            $this->message = $message;
        }
        return $this;
    }
}
