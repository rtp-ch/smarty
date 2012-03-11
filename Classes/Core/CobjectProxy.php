<?php

/**
 * A proxy object for plugins which rely on frontend tslib_cobj methods.
 */
class Tx_Smarty_Core_CobjectProxy
{
    /**
     * Contains a backup of the current $GLOBALS['TSFE'].
     *
     * @var tslib_fe|null
     */
    private $tsfeBackup;

    /**
     * Contains a backup of the current working directory.
     *
     * @var string|null
     */
    private $workingDirBackup;

    /**
     * Constructor creates a simulated frontend environment when
     *
     * @param array $data
     * @param string $table
     */
    public function __construct(array $data = array(), $table = '')
    {
        if (!Tx_Smarty_Utility_Typo3::isFeInstance()) {
            $this->simulateFrontendEnvironment($data, $table);
        }
    }

    /**
     * Resets $GLOBALS['TSFE'] if it was previously changed by simulateFrontendEnvironment()
     *
     * @return void
     * @see Tx_Extbase_Utility_FrontendSimulator::resetFrontendEnvironment
     */
    public function __destruct()
    {
        $this->resetTsfe();
        $this->resetWorkingDir();
    }

    /**
     * Reroutes cObj method calls to the tslib_cObj instance
     *
     * @param $method
     * @param array $args
     * @return mixed
     * @throws BadMethodCallException|RuntimeException
     */
    public function __call($method, array $args = array())
    {
        if(!method_exists($this->getTsfe()->cObj, $method)) {
            throw new BadMethodCallException('No such method "' . $method . '" in class "tslib_cObj"!', 1329912359);
        }
        return call_user_func_array(array($this->getTsfe()->cObj, $method), $args);
    }

    /**
     * Simulates a frontend environment for backend mode. Inspired by various hacks for simulating the frontend in
     * Tx_Fluid_ViewHelpers_CObjectViewHelper, Tx_Fluid_ViewHelpers_ImageViewHelper,
     * Tx_Fluid_ViewHelpers_Format_CropViewHelper, Tx_Fluid_ViewHelpers_Format_HtmlViewHelper and
     * Tx_Extbase_Utility_FrontendSimulator (and possibly others...)
     *
     * @param array $data
     * @param string $table
     */
    protected function simulateFrontendEnvironment(array $data = array(), $table = '')
    {
        $this->setWorkingDir();
        $this->setCharSet();
        $this->setTypoScript();
        $this->setContentObject($data, $table);
    }

    /**
     * @param array $data
     * @param string $table
     */
    private function setContentObject(array $data = array(), $table = '')
    {
        $this->getTsfe()->cObj = t3lib_div::makeInstance('tslib_cObj');
        $this->getTsfe()->cObj->start($data, $table);
    }

    /**
     * Creates a dummy global instance of tslib_fe.
     */
    private function setTsfe()
    {
        $this->tsfeBackup = ($GLOBALS['TSFE'] instanceof tslib_fe) ? $GLOBALS['TSFE'] : false;
        $GLOBALS['TSFE'] = new stdClass();
        $GLOBALS['TSFE']->cObjectDepthCounter = 100;
    }

    /**
     * Checks if the global tslib_fe instance has already been set. This is the case as soon
     * as $tsfeBackup has been set (containing either a backup of the current tslib_fe global
     * or the boolean "false").
     *
     * @return bool
     */
    private function hasTsfe()
    {
        return !is_null($this->tsfeBackup);
    }

    /**
     * @return tslib_fe
     */
    private function getTsfe()
    {
        if (!$this->hasTsfe()) {
            $this->setTsfe();
        }
        return $GLOBALS['TSFE'];
    }

    /**
     *
     */
    private function setTypoScript()
    {
        $typoScriptSetup = array(); // TODO: Smarty setup
        $template = t3lib_div::makeInstance('t3lib_TStemplate');
        $template->tt_track = 0;
        $template->init();
        $template->getFileName_backPath = PATH_site;
        $this->getTsfe()->tmpl = $template;
        $this->getTsfe()->tmpl->setup = $typoScriptSetup;
        $this->getTsfe()->config = $typoScriptSetup;
    }

    /**
     *
     */
    private function setCharSet()
    {
        // preparing csConvObj
        if (!is_object($this->getTsfe()->csConvObj)) {
            if (is_object($GLOBALS['LANG'])) {
                $this->getTsfe()->csConvObj = $GLOBALS['LANG']->csConvObj;
            } else {
                $this->getTsfe()->csConvObj = t3lib_div::makeInstance('t3lib_cs');
            }
        }

        // preparing renderCharset
        if (!is_object($this->getTsfe()->renderCharset)) {
            if (is_object($GLOBALS['LANG'])) {
                $this->getTsfe()->renderCharset = $GLOBALS['LANG']->charSet;
            } else {
                $this->getTsfe()->renderCharset = $GLOBALS['TYPO3_CONF_VARS']['BE']['forceCharset'];
            }
        }
    }

    private function setWorkingDir()
    {
        $this->workingDirBackup = getcwd();
        chdir(PATH_site);
    }

    private function resetWorkingDir()
    {
        if (!is_null($this->workingDirBackup)) {
            chdir($this->workingDirBackup);
        }
    }

    private function resetTsfe()
    {
        if ($this->tsfeBackup instanceof tslib_fe) {
            $GLOBALS['TSFE'] = $this->tsfeBackup;
        } else {
            unset($GLOBALS['TSFE']);
        }
    }
}