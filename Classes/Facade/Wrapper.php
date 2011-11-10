<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2006-2007 Simon Tuck <stu@rtpartner.ch>, Rueegg Tuck Partner GmbH
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * @copyright 	2007 Rueegg Tuck Partner GmbH
 * @author 		Simon Tuck <stu@rtpartner.ch>
 * @link 		http://www.rtpartner.ch/
 * @package 	Smarty (smarty)
 **/


// Wrapper extends the smarty backport class
class Tx_Smarty_Facade_Wrapper
    extends SmartyBC
{
    
    /**
     * @var Tx_Smarty_Facade_Configuration
     */
    private $configuration              = null;

    /**
     *
     * Language file(s) for the translate view helper
     *
     * @var string
     */
    protected $language_file            = null;

    /**
     * @var null
     * @deprecated Use $language_file instead
     */
    private $path_to_language_file      = null;

    /**
     * @var null
     * @deprecated Use $template_dir instead
     */
    private $path_to_template_directory = null;

    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);
    }

    /**
     *
     * Reroutes all undefined method calls to the configuration manager
     *
     * @param $method
     * @param $args
     * @return mixed
     */
    public final function __call($method, $args)
    {
    	return call_user_func_array(array($this->getConfiguration(), $method), $args);
    }

    /**
     *
     * Gets the instance of the configuration manager
     *
     * @return null|Tx_Smarty_Facade_Configuration
     */
    private function getConfiguration()
    {
        if(is_null($this->configuration)) {
            $this->configuration = t3lib_div::makeInstance('Tx_Smarty_Facade_Configuration', $this);
        }
        return $this->configuration;
    }

    /**
     * @param $path_to_template_directory
     * @return void
     * @deprecated Use setTemplateDir() instead
     */
    public function setPathToTemplateDirectory($path_to_template_directory)
    {
        $this->setTemplateDir($path_to_template_directory);
    }

   /**
    *
    * Adds language file(s)
    *
    * @param mixed $language_file
    * @param string $key of the array element to assign
    * @return Tx_Smarty_Facade_Wrapper current Smarty instance for chaining
    */
    public function addLanguageFile($language_file, $key = null)
    {
        // make sure we're dealing with an array
        $this->language_file = (array) $this->language_file;

        if (is_array($language_file)) {
            foreach ($language_file as $k => $v) {
                if (is_int($k)) {
                    // indexes are not merged but appended
                    $this->language_file[] = rtrim($v, '/\\') . DS;
                } else {
                    // string indexes are overridden
                    $this->language_file[$k] = rtrim($v, '/\\') . DS;
                }
            }
        } else {
            // append new directory
            $this->language_file[] = rtrim($language_file, '/\\') . DS;
        }

        $this->language_file = array_unique($this->language_file);
        return $this;
    }

   /**
    * 
    * Set language file(s)
    *
    * @param string|array $language_file language file(s)
    * @return Smarty current Smarty instance for chaining
    */
    public function setLanguageFile($language_file)
    {
        $this->language_file = array();
        foreach ((array) $language_file as $k => $v) {
            $this->language_file[$k] = rtrim($v, '/\\') . DS;
        }
        return $this;
    }

    /**
     * @param $path_to_language_file
     * @return void
     * @deprecated use setLanguageFile() instead
     */
    public function setPathToLanguageFile($path_to_language_file)
    {
        $this->setLanguageFile($path_to_language_file);
    }

   /**
    *
    * Get language file(s)
    *
    * @param mixed $index of language file to get, null to get all
    * @return array|null language file
    */
    public function getLanguageFile($index = null)
    {
        if ($index !== null) {
            return isset($this->language_file[$index]) ? $this->language_file[$index] : null;
        }
        return (array) $this->language_file;
    }
}