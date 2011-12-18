<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Simon Tuck <stu@rtp.ch>
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

class Tx_Smarty_Core_Wrapper
    extends SmartyBC
{

    /**
     * @var Tx_Smarty_Core_Configuration
     */
    private $configuration               = null;

    /**
     *
     * Language file(s) for the translate view helper
     *
     * @var string|array
     */
    private $language_file               = null;

    /**
     *
     * Instance of the calling class
     *
     * @var null
     */
    private $parent_object               = null;

    /**
     *
     * Instance of cObj (FE only)
     *
     * @var tslib_cObj
     */
    private $content_object              = null;

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
     * @return Tx_Smarty_Core_Configuration
     */
    public function getConfiguration()
    {
        if(is_null($this->configuration)) {
            $this->configuration = t3lib_div::makeInstance('Tx_Smarty_Core_Configuration', $this);
        }
        return $this->configuration;
    }

    /**
     * @param mixed $pObj The instance of the calling class
     */
    public function setParentObject($pObj)
    {
        $this->parent_object = $pObj;
    }

    /**
     * @return mixed Returns the instance of the calling class
     */
    public function getParentObject()
    {
        return $this->parent_object;
    }

   /**
    *
    * Set language file(s)
    *
    * @api
    * @param string|array $language_file language file(s)
    * @return Smarty current Smarty instance for chaining
    */
    public function setLanguageFile($language_file)
    {
        $this->language_file = array();
        foreach ((array) $language_file as $k => $v) {
            $this->language_file[$k] = $v;
        }
        return $this;
    }

   /**
    *
    * Get language file(s)
    *
    * @api
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

   /**
    *
    * Adds language file(s)
    *
    * @api
    * @param mixed $language_file
    * @param string $key of the array element to assign
    * @return Tx_Smarty_Core_Wrapper current Smarty instance for chaining
    */
    public function addLanguageFile($language_file, $key = null)
    {
        // make sure we're dealing with an array
        $this->language_file = (array) $this->language_file;

        if (is_array($language_file)) {
            foreach ($language_file as $k => $v) {
                if (is_int($k)) {
                    // indexes are not merged but appended
                    $this->language_file[] = $v;
                } else {
                    // string indexes are overridden
                    $this->language_file[$k] = $v;
                }
            }
        } else {
            // append new directory
            $this->language_file[] = $language_file;
        }

        $this->language_file = array_unique($this->language_file);
        return $this;
    }


   /**
    *
    * Set template directory
    *
    * @api
    * @param string|array $template_dir directory(s) of template sources
    * @return Smarty current Smarty instance for chaining
    */
    public function setTemplateDir($template_dir)
    {
        $template_dir = Tx_Smarty_Utility_Path::resolvePaths($template_dir);
        return parent::setTemplateDir($template_dir);
    }

   /**
    *
    * Add template directory(s)
    *
    * @api
    * @param string|array $template_dir directory(s) of template sources
    * @param string       $key          of the array element to assign the template dir to
    * @return Smarty current Smarty instance for chaining
    * @throws SmartyException when the given template directory is not valid
    */
    public function addTemplateDir($template_dir, $key = null)
    {
        $template_dir = Tx_Smarty_Utility_Path::resolvePaths($template_dir);
        return parent::addTemplateDir($template_dir, $key);
    }

   /**
    *
    * Set config directory
    *
    * @api
    * @param string|array $config_dir directory(s) of configuration sources
    * @return Smarty current Smarty instance for chaining
    */
    public function setConfigDir($config_dir)
    {
        $config_dir = Tx_Smarty_Utility_Path::resolvePaths($config_dir);
        return parent::setConfigDir($config_dir);
    }

   /**
    *
    * Add config directory(s)
    *
    * @api
    * @param string|array $config_dir directory(s) of config sources
    * @param string $key of the array element to assign the config dir to
    * @return Smarty current Smarty instance for chaining
    */
    public function addConfigDir($config_dir, $key = null)
    {
        $config_dir = Tx_Smarty_Utility_Path::resolvePaths($config_dir);
        return parent::addConfigDir($config_dir, $key);
    }

   /**
    *
    * Set plugins directory
    *
    * @api
    * @param string|array $plugins_dir directory(s) of plugins
    * @return Smarty current Smarty instance for chaining
    */
    public function setPluginsDir($plugins_dir)
    {
        $plugins_dir = Tx_Smarty_Utility_Path::resolvePaths($plugins_dir);
        return parent::setPluginsDir($plugins_dir);
    }

   /**
    * 
    * Adds directory of plugin files
    *
    * @api
    * @param string|array $plugins_dir
    * @return Smarty current Smarty instance for chaining
    */
    public function addPluginsDir($plugins_dir)
    {
        $plugins_dir = Tx_Smarty_Utility_Path::resolvePaths($plugins_dir);
        return parent::addPluginsDir($plugins_dir);
    }

   /**
    *
    * Set compile directory
    *
    * @api
    * @param string $compile_dir directory to store compiled templates in
    * @return Smarty current Smarty instance for chaining
    */
    public function setCompileDir($compile_dir)
    {
        $compile_dir = Tx_Smarty_Utility_Path::resolvePaths($compile_dir);
        return parent::setCompileDir($compile_dir);
    }

   /**
    *
    * Set cache directory
    *
    * @api
    * @param string $cache_dir directory to store cached templates in
    * @return Smarty current Smarty instance for chaining
    */
    public function setCacheDir($cache_dir)
    {
        $cache_dir = Tx_Smarty_Utility_Path::resolvePaths($cache_dir);
        return parent::setCacheDir($cache_dir);
    }

   /**
    *
    * Set the debug template
    *
    * @api
    * @param string $tpl_name
    * @return Smarty current Smarty instance for chaining
    * @throws SmartyException if file is not readable
    */
    public function setDebugTemplate($tpl_name)
    {
        $tpl_name = Tx_Smarty_Utility_Path::resolvePaths($tpl_name);
        return parent::setDebugTemplate($tpl_name);
    }


    /************************************************************************
     * Deprecated methods
     ************************************************************************/
    
    /**
     * @throws InvalidArgumentException
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        // Log deprecated properties
        if ($property === 'pObj') {
            return $this->getParentObject();

        //} elseif ($property === 'cObj') {
        //    return new Tx_Smarty_Core_CobjectProxy();

        } elseif ($property === 'path_to_template_directory') {
            return $this->getTemplateDir();

        } elseif ($property === 'path_to_language_file') {
            return $this->getLanguageFile();

        } else {
            throw new InvalidArgumentException('Attempted to get unknown smarty property "' . $property . '"!', 1322384939);
        }
    }

    /**
     * @throws InvalidArgumentException
     * @param $property
     * @param $value
     * @return void
     */
    public function __set($property, $value)
    {
        // Log deprecated properties
        if ($property === 'pObj') {
            $this->setParentObject($value);

        //} elseif ($property === 'cObj') {
        //    $this->setContentObject($value);

        } elseif ($property === 'path_to_template_directory') {
            $this->setTemplateDir($value);

        } elseif ($property === 'path_to_language_file') {
            $this->setLanguageFile($value);

        } elseif ($property === 'relPathToLanguageFile') {
            $this->setLanguageFile($value);

        } else {
            throw new InvalidArgumentException('Attempted to set unknown smarty property "' . $property . '"!', 1322384939);
        }
    }

    /**
     *
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
     * Set the language file
     *
     * @param $path_to_language_file
     * @return void
     * @deprecated use setLanguageFile() instead
     */
    public function setRelPathToLanguageFile($path_to_language_file)
    {
        $this->setLanguageFile($path_to_language_file);
    }

    /**
     *
     * Set the language file
     *
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
     * Set smarty configuration variable
     *
     * @param $smartyVar
     * @param $smartyValue
     * @return void
     * @deprecated use accessors instead. For example setCacheLifetime(3600)
     */
    public function setSmartyVar($smartyVar, $smartyValue)
    {
        $method = 'set' . t3lib_div::underscoredToUpperCamelCase($smartyVar);
        $this->{$method}($smartyValue);
    }
}