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
 * @package     Varien_Io
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Input/output client interface
 *
 * @category   Varien
 * @package    Varien_Io
 * @author      Magento Core Team <core@magentocommerce.com>
 */
interface Varien_Io_Interface
{
    /**
     * Open a connection
     *
     */
    public function open(array $args=array());

    /**
     * Close a connection
     *
     */
    public function close();

    /**
     * Create a directory
     *
     */
    public function mkdir($dir, $mode=0777, $recursive=true);

    /**
     * Delete a directory
     *
     */
    public function rmdir($dir, $recursive=false);

    /**
     * Get current working directory
     *
     */
    public function pwd();

    /**
     * Change current working directory
     *
     */
    public function cd($dir);

    /**
     * Read a file
     *
     */
    public function read($filename, $dest=null);

    /**
     * Write a file
     *
     */
    public function write($filename, $src, $mode=null);

    /**
     * Delete a file
     *
     */
    public function rm($filename);

    /**
     * Rename or move a directory or a file
     *
     */
    public function mv($src, $dest);

    /**
     * Chamge mode of a directory or a file
     *
     */
    public function chmod($filename, $mode);

    /**
     * Get list of cwd subdirectories and files
     *
     */
    public function ls($grep=null);

    /**
     * Retrieve directory separator in context of io resource
     *
     */
    public function dirsep();
}
