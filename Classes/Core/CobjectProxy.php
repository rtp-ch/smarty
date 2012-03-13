<?php

/**
 * A proxy object for plugins which rely on frontend tslib_cobj methods.
 */
class Tx_Smarty_Core_CobjectProxy
{
    /**
     * Contains a backup of $GLOBALS['TSFE']
     *
     * @var mixed
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
     * Resets the working directory
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
        if(!method_exists($this->tsfe()->cObj, $method)) {
            throw new BadMethodCallException('No such method "' . $method . '" in class "tslib_cObj"!', 1329912359);
        }
        return call_user_func_array(array($this->tsfe()->cObj, $method), $args);
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
        $this->setPageSelect();
        $this->setTypoScript();
        $this->setContentObject($data, $table);
    }

    /**
     * @param array $data
     * @param string $table
     */
    private function setContentObject(array $data = array(), $table = '')
    {

        $this->tsfe()->cObj = t3lib_div::makeInstance('tslib_cObj');
        $this->tsfe()->cObj->start($data, $table);
    }

    /**
     * Creates an instance of t3lib_pageSelect
     */
    private function setPageSelect()
    {
        $this->tsfe()->sys_page = t3lib_div::makeInstance('t3lib_pageSelect');
        $this->tsfe()->sys_page->versioningPreview = false;
        $this->tsfe()->sys_page->versioningWorkspaceId = false;
        $this->tsfe()->where_hid_del = ' AND pages.deleted=0';
        $this->tsfe()->sys_page->init(false);
        $this->tsfe()->sys_page->where_hid_del .= ' AND pages.doktype<200';
        $this->tsfe()->sys_page->where_groupAccess = $this->tsfe()->sys_page->getMultipleGroupsWhereClause('pages.fe_group', 'pages');
    }

    /**
     * Initializes TypoScript templating
     */
    private function setTypoScript()
    {
        $typoScriptSetup = array(); // TODO: Smarty setup
        $template = t3lib_div::makeInstance('t3lib_TStemplate');
        $template->tt_track = 0;
        $template->init();
        $template->getFileName_backPath = PATH_site;
        $this->tsfe()->tmpl = $template;
        $this->tsfe()->tmpl->setup = $typoScriptSetup;
        $this->tsfe()->config = $typoScriptSetup;
    }

    /**
     * Initializes global charset helpers
     */
    private function setCharSet()
    {
        // preparing csConvObj
        if (!is_object($this->tsfe()->csConvObj)) {
            if (is_object($GLOBALS['LANG'])) {
                $this->tsfe()->csConvObj = $GLOBALS['LANG']->csConvObj;
            } else {
                $this->tsfe()->csConvObj = t3lib_div::makeInstance('t3lib_cs');
            }
        }

        // preparing renderCharset
        if (!is_object($this->tsfe()->renderCharset)) {
            if (is_object($GLOBALS['LANG'])) {
                $this->tsfe()->renderCharset = $GLOBALS['LANG']->charSet;
            } else {
                $this->tsfe()->renderCharset = $GLOBALS['TYPO3_CONF_VARS']['BE']['forceCharset'];
            }
        }
    }

    /*
     * ========================================
     * Working Directory
     * ========================================
     */

    /**
     * Resets the current working directory to the TYPO3 installation path
     */
    private function setWorkingDir()
    {
        $this->workingDirBackup = getcwd();
        chdir(PATH_site);
    }

    /**
     * Sets the current working directory back to it's original value
     */
    private function resetWorkingDir()
    {
        if (!is_null($this->workingDirBackup)) {
            chdir($this->workingDirBackup);
        }
    }

    /*
     * ========================================
     * $GLOBALS['TSFE']
     * ========================================
     */

    /**
     * Sets $GLOBALS['TSFE']
     */
    private function setTsfe()
    {
        $this->tsfeBackup = ($GLOBALS['TSFE'] instanceof tslib_fe) ? $GLOBALS['TSFE'] : false;
        $GLOBALS['TSFE'] = new stdClass();
        $GLOBALS['TSFE']->cObjectDepthCounter = 100;
        $GLOBALS['TSFE']->baseUrl = t3lib_div::getIndpEnv('TYPO3_SITE_URL');
    }

    /**
     * Resets $GLOBALS['TSFE']
     */
    private function resetTsfe()
    {
        unset($GLOBALS['TSFE']);
        if ($this->tsfeBackup instanceof tslib_fe) {
            $GLOBALS['TSFE'] = $this->tsfeBackup;
        }
    }

    /**
     * Provides access to $GLOBALS['TSFE']
     *
     * @return stdClass
     */
    private function tsfe()
    {
        if (is_null($this->tsfeBackup)) {
            $this->setTsfe();
        }
        return $GLOBALS['TSFE'];
    }
}