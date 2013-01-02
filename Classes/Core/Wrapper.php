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
    private $configuration;

    /**
     * Language file(s) for the translate view helper
     *
     * @var string|array
     */
    private $language_file;

    /**
     * @var boolean|array
     */
    private $mute_errors = false;

    /**
     * Reroutes all undefined method calls to the configuration manager
     *
     * @param $method
     * @param $args
     * @return mixed
     */
    final public function __call($method, $args)
    {
        return call_user_func_array(array($this->getConfiguration(), $method), $args);
    }

    /**
     * Gets the instance of the configuration manager
     *
     * @return Tx_Smarty_Core_Configuration
     */
    public function getConfiguration()
    {
        if (is_null($this->configuration)) {
            $this->configuration = t3lib_div::makeInstance('Tx_Smarty_Core_Configuration', $this);
        }

        return $this->configuration;
    }

    /**
     * Set language file(s)
     *
     * @param $languageFile
     */
    public function setLanguageFile($languageFile)
    {
        $this->addLanguageFile($languageFile);
    }

    /**
     * Get language file(s)
     *
     * @param null $index
     * @return array|null
     */
    public function getLanguageFile($index = null)
    {
        if ($index !== null) {
            return isset($this->language_file[$index]) ? $this->language_file[$index] : null;
        }

        return (array) $this->language_file;
    }

    /**
     * Adds language file(s)
     *
     * @param $languageFile
     * @param null $key
     * @return Tx_Smarty_Core_Wrapper
     */
    public function addLanguageFile($languageFile, $key = null)
    {
        // make sure we're dealing with an array
        $this->language_file = (array) $this->language_file;

        if (is_array($languageFile)) {
            foreach ($languageFile as $k => $v) {
                if (is_int($k)) {
                    // indexes are not merged but appended
                    $this->language_file[] = $v;

                } else {
                    // string indexes are overridden
                    $this->language_file[$k] = $v;
                }
            }
        } elseif (!is_null($key)) {
            $this->language_file[$key] = $languageFile;

        } else {
            $this->language_file[] = $languageFile;
        }

        $this->language_file = array_unique($this->language_file);

        return $this;
    }

    /**
     * Set template directory
     *
     * @param array|string $templateDir
     * @return Smarty
     */
    public function setTemplateDir($templateDir)
    {
        $templateDir = Tx_Smarty_Utility_Path::resolvePaths($templateDir);
        return parent::setTemplateDir($templateDir);
    }

    /**
     * Add template directory(s)
     *
     * @param array|string $templateDir
     * @param null $key
     * @return Smarty
     */
    public function addTemplateDir($templateDir, $key = null)
    {
        $templateDir = Tx_Smarty_Utility_Path::resolvePaths($templateDir);
        return parent::addTemplateDir($templateDir, $key);
    }

    /**
     * Set config directory
     *
     * @param $config_dir
     * @return Smarty
     */
    public function setConfigDir($config_dir)
    {
        $config_dir = Tx_Smarty_Utility_Path::resolvePaths($config_dir);
        return parent::setConfigDir($config_dir);
    }

    /**
     * Add config directory(s)
     *
     * @param array|string $config_dir
     * @param null $key
     * @return Smarty
     */
    public function addConfigDir($config_dir, $key = null)
    {
        $config_dir = Tx_Smarty_Utility_Path::resolvePaths($config_dir);
        return parent::addConfigDir($config_dir, $key);
    }

    /**
     * Set plugins directory
     *
     * @param array|string $plugins_dir
     * @return Smarty
     */
    public function setPluginsDir($plugins_dir)
    {
        $plugins_dir = Tx_Smarty_Utility_Path::resolvePaths($plugins_dir);
        // NOTE: never overwrite plugins_dir! Always translate the setPluginsDir action
        // to addPluginsDir
        return parent::addPluginsDir($plugins_dir);
    }

    /**
     * @param $plugins_dir
     * @return Smarty
     */
    public function addPluginsDir($plugins_dir)
    {
        $plugins_dir = Tx_Smarty_Utility_Path::resolvePaths($plugins_dir);
        return parent::addPluginsDir($plugins_dir);
    }

    /**
     * Set compile directory
     *
     * @param string $compile_dir
     * @return Smarty
     */
    public function setCompileDir($compile_dir)
    {
        $compile_dir = Tx_Smarty_Utility_Path::resolvePaths($compile_dir);
        return parent::setCompileDir($compile_dir);
    }

    /**
     * Set cache directory
     *
     * @param string $cache_dir
     * @return Smarty
     */
    public function setCacheDir($cache_dir)
    {
        $cache_dir = Tx_Smarty_Utility_Path::resolvePaths($cache_dir);
        return parent::setCacheDir($cache_dir);
    }

    /**
     * Set the debug template
     *
     * @param string $tpl_name
     * @return Smarty
     */
    public function setDebugTemplate($tpl_name)
    {
        $tpl_name = Tx_Smarty_Utility_Path::resolvePaths($tpl_name);
        return parent::setDebugTemplate($tpl_name);
    }

    /**
     * returns a rendered Smarty template: Modifies the display method to fetch the rendered
     * template instead of displaying it.
     *
     * @param string $template   the resource handle of the template file or template object
     * @param mixed  $cache_id   cache id to be used with this template
     * @param mixed  $compile_id compile id to be used with this template
     * @param object $parent     next higher level of Smarty variables
     * @return string|void       rendered template
     */
    public function display($template = null, $cache_id = null, $compile_id = null, $parent = null)
    {
        return $this->fetch($template, $cache_id, $compile_id, $parent, false);
    }

    /**
     * @param string $property
     * @return array|mixed|null|string
     * @throws Tx_Smarty_Exception_CoreException
     */
    public function __get($property)
    {
        if ($property === 'template_dir') {
            $this->getTemplateDir();

        } elseif ($property === 'plugins_dir') {
            $this->getPluginsDir();

        } elseif ($property === 'config_dir') {
            $this->getConfigDir();

        } elseif ($property === 'compile_dir') {
            $this->getCompileDir();

        } elseif ($property === 'cache_dir') {
            $this->getCacheDir();

        } elseif ($property === 'path_to_template_directory') {
            $this->getPathToTemplateDirectory();

        } elseif ($property === 'path_to_language_file') {
            $this->getPathToLanguageFile();

        } elseif ($property === 'relPathToLanguageFile') {
            $this->getRelPathToLanguageFile();

        } elseif ($property === 'respect_no_cache') {
            $this->getRespectNoCache();

        } elseif ($property == 't3_extVars') {
            return $this->getT3extVars();

        } elseif ($property === 'pObj') {
            return $this->getPobj();

        } else {
            $msg = 'Attempted to get unknown smarty property "' . $property . '"!';
            throw new Tx_Smarty_Exception_CoreException($msg, 1322384939);
        }
    }

    /**
     * Generic setter for properties which are either deprecated or not accessible (i.e. private and therefore have
     * to be translated to the appropriate setter method).
     *
     * @param string $property
     * @param mixed $value
     * @throws Tx_Smarty_Exception_CoreException
     */
    public function __set($property, $value)
    {
        if ($property === 'template_dir') {
            $this->setTemplateDir($value);

        } elseif ($property === 'plugins_dir') {
            $this->addPluginsDir($value);

        } elseif ($property === 'config_dir') {
            $this->setConfigDir($value);

        } elseif ($property === 'compile_dir') {
            $this->setCompileDir($value);

        } elseif ($property === 'cache_dir') {
            $this->setCacheDir($value);

        } elseif ($property === 'path_to_template_directory') {
            $this->setPathToTemplateDirectory($value);

        } elseif ($property === 'path_to_language_file') {
            $this->setPathToLanguageFile($value);

        } elseif ($property === 'relPathToLanguageFile') {
            $this->setRelPathToLanguageFile($value);

        } elseif ($property === 'respect_no_cache') {
            $this->setRespectNoCache($value);

        } elseif ($property === 't3_extVars') {
            $this->setT3extVars($value);

        } elseif ($property === 'pObj') {
            $this->setPobj($value);

        } else {
            $msg = 'Attempted to set unknown smarty property "' . $property . '"!';
            throw new Tx_Smarty_Exception_CoreException($msg, 1322384939);
        }
    }


    /************************************************************************
     * Deprecated methods
     ************************************************************************/

    /**
     * @param $value
     * @deprecated Feature has been dropped
     */
    private function setPobj($value)
    {
        t3lib_div::logDeprecatedFunction();
    }

    /**
     * @deprecated Feature has been dropped
     */
    private function getPobj()
    {
        t3lib_div::logDeprecatedFunction();
    }

    /**
     * @param $value
     * @deprecated Feature has been dropped
     */
    private function setRespectNoCache($value)
    {
        t3lib_div::logDeprecatedFunction();
    }

    /**
     * @deprecated Feature has been dropped
     */
    private function getRespectNoCache()
    {
        t3lib_div::logDeprecatedFunction();
        return false;
    }

    /**
     * @param $value
     * @deprecated Feature has been dropped
     */
    private function setT3extVars($value)
    {
        t3lib_div::logDeprecatedFunction();
    }

    /**
     * @deprecated Feature has been dropped
     */
    private function getT3extVars()
    {
        t3lib_div::logDeprecatedFunction();
    }

    /**
     * Sets the template directory
     *
     * @param $path_to_template_directory
     * @deprecated Use setTemplateDir() instead
     */
    public function setPathToTemplateDirectory($path_to_template_directory)
    {
        t3lib_div::logDeprecatedFunction();
        $this->setTemplateDir($path_to_template_directory);
    }

    /**
     * Gets the template directory
     *
     * @return array|null
     * @deprecated Use setTemplateDir() instead
     */
    public function getPathToTemplateDirectory()
    {
        t3lib_div::logDeprecatedFunction();
        return $this->getTemplateDir();
    }

    /**
     * Set the language file
     *
     * @param $path_to_language_file
     * @deprecated use setLanguageFile() instead
     */
    public function setRelPathToLanguageFile($path_to_language_file)
    {
        t3lib_div::logDeprecatedFunction();
        $this->setLanguageFile($path_to_language_file);
    }

    /**
     * Get the language file(s)
     *
     * @return array|null
     * @deprecated use getLanguageFile() instead
     */
    public function getRelPathToLanguageFile()
    {
        t3lib_div::logDeprecatedFunction();
        return $this->getLanguageFile();
    }

    /**
     * Set the language file
     *
     * @param $path_to_language_file
     * @deprecated use setLanguageFile() instead
     */
    public function setPathToLanguageFile($path_to_language_file)
    {
        t3lib_div::logDeprecatedFunction();
        $this->setLanguageFile($path_to_language_file);
    }

    /**
     * Get the language file(s)
     *
     * @return array|null
     * @deprecated use getLanguageFile() instead
     */
    public function getPathToLanguageFile()
    {
        t3lib_div::logDeprecatedFunction();
        return $this->getLanguageFile();
    }

    /**
     *
     * Set smarty configuration variable
     *
     * @param $smartyVar
     * @param $smartyValue
     * @deprecated use accessors instead. For example setCacheLifetime(3600)
     */
    public function setSmartyVar($smartyVar, $smartyValue)
    {
        t3lib_div::logDeprecatedFunction();
        $method = 'set' . t3lib_div::underscoredToUpperCamelCase($smartyVar);
        $this->{$method}($smartyValue);
    }
}