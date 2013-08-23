<?php

/**
 * A proxy object for plugins which rely on frontend tslib_cobj methods. Inspired by various similar approaches in:
 *
 * - Tx_Fluid_ViewHelpers_CObjectViewHelper
 * - Tx_Fluid_ViewHelpers_ImageViewHelper
 * - Tx_Fluid_ViewHelpers_Format_CropViewHelper
 * - Tx_Fluid_ViewHelpers_Format_HtmlViewHelper and
 * - Tx_Extbase_Utility_FrontendSimulator
 * - Tx_Phpunit_Framework
 * - and possibly others...
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
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    public function __destruct()
    {
        if ($this->tsfeBackup instanceof tslib_fe) {
            $GLOBALS['TSFE'] = $this->tsfeBackup;
        }

        if (!is_null($this->workingDirBackup)) {
            chdir($this->workingDirBackup);
        }
    }

    /**
     * Reroutes cObj method calls to the tslib_cObj instance
     *
     * @param $method
     * @param array $args
     * @return mixed
     * @throws BadMethodCallException|RuntimeException
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    public function __call($method, array $args = array())
    {
        if (!($GLOBALS['TSFE']->cObj instanceof tslib_cObj)) {
            throw new RuntimeException('Unable to access "tslib_cObj"!', 1355689602);

        } elseif (!method_exists($GLOBALS['TSFE']->cObj, $method)) {
            throw new BadMethodCallException('No such method "' . $method . '" in class "tslib_cObj"!', 1329912359);
        }

        return call_user_func_array(array($GLOBALS['TSFE']->cObj, $method), $args);
    }

    /**
     * Simulates a frontend environment.
     *
     * @param array $data
     * @param string $table
     */
    protected function simulateFrontendEnvironment(array $data = array(), $table = '')
    {
        $this->setTimeTracker();
        $this->setTsfe();
        $this->setWorkingDir();
        $this->setCharSet();
        $this->setPageSelect();
        $this->setTypoScript();
        $this->setContentObject($data, $table);
    }

    /**
     * Sets a fake time tracker
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    private static function setTimeTracker()
    {
        if (!is_object($GLOBALS['TT'])) {
            $GLOBALS['TT'] = Tx_Smarty_Service_Compatibility::makeInstance('t3lib_TimeTrackNull');
        }
    }

    /**
     * @param array $data
     * @param string $table
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    private function setContentObject(array $data = array(), $table = '')
    {

        $GLOBALS['TSFE']->cObj = Tx_Smarty_Service_Compatibility::makeInstance('tslib_cObj');
        $GLOBALS['TSFE']->cObj->start($data, $table);
    }

    /**
     * Creates an instance of t3lib_pageSelect
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    private function setPageSelect()
    {
        $GLOBALS['TSFE']->sys_page = Tx_Smarty_Service_Compatibility::makeInstance('t3lib_pageSelect');
        $GLOBALS['TSFE']->sys_page->versioningPreview = false;
        $GLOBALS['TSFE']->sys_page->versioningWorkspaceId = false;
        $GLOBALS['TSFE']->where_hid_del = ' AND pages.deleted=0';
        $GLOBALS['TSFE']->sys_page->init(false);
        $GLOBALS['TSFE']->sys_page->where_hid_del .= ' AND pages.doktype<200';
        $GLOBALS['TSFE']->sys_page->where_groupAccess
            = $GLOBALS['TSFE']->sys_page->getMultipleGroupsWhereClause('pages.fe_group', 'pages');
    }

    /**
     * Initializes TypoScript templating
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    private function setTypoScript()
    {
        $GLOBALS['TSFE']->tmpl->runThroughTemplates(
            $GLOBALS['TSFE']->sys_page->getRootLine($GLOBALS['TSFE']->id),
            0
        );
        $GLOBALS['TSFE']->tmpl->generateConfig();
        $GLOBALS['TSFE']->tmpl->loaded = 1;
        $GLOBALS['TSFE']->settingLanguage();
        $GLOBALS['TSFE']->settingLocale();
    }

    /**
     * Initializes global charset helpers
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    private function setCharSet()
    {
        // preparing csConvObj
        if (!is_object($GLOBALS['TSFE']->csConvObj)) {
            if (is_object($GLOBALS['LANG'])) {
                $GLOBALS['TSFE']->csConvObj = $GLOBALS['LANG']->csConvObj;

            } else {
                $GLOBALS['TSFE']->csConvObj = Tx_Smarty_Service_Compatibility::makeInstance('t3lib_cs');
            }
        }

        // preparing renderCharset
        if (!is_object($GLOBALS['TSFE']->renderCharset)) {
            if (is_object($GLOBALS['LANG'])) {
                $GLOBALS['TSFE']->renderCharset = $GLOBALS['LANG']->charSet;

            } else {
                $GLOBALS['TSFE']->renderCharset = $GLOBALS['TYPO3_CONF_VARS']['BE']['forceCharset'];
            }
        }
    }

    /**
     * Resets the current working directory to the TYPO3 installation path
     */
    private function setWorkingDir()
    {
        $this->workingDirBackup = getcwd();
        chdir(PATH_SITE);
    }

    /**
     * Sets $GLOBALS['TSFE']
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     * TODO: Implement page & cache
     */
    private function setTsfe($pageId = 0, $noCache = 0)
    {
        $this->tsfeBackup = ($GLOBALS['TSFE'] instanceof tslib_fe) ? $GLOBALS['TSFE'] : false;
        $GLOBALS['TSFE'] = Tx_Smarty_Service_Compatibility::makeInstance(
            'tslib_fe',
            $GLOBALS['TYPO3_CONF_VARS'],
            $pageId,
            $noCache
        );
        $GLOBALS['TSFE']->beUserLogin = false;
        $GLOBALS['TSFE']->cObjectDepthCounter = 100;
        $GLOBALS['TSFE']->workspacePreview = '';
        $GLOBALS['TSFE']->initFEuser();
        $GLOBALS['TSFE']->determineId();
        $GLOBALS['TSFE']->initTemplate();
        $GLOBALS['TSFE']->config = array();
        $GLOBALS['TSFE']->tmpl->getFileName_backPath = PATH_SITE;
        $GLOBALS['TSFE']->baseUrl = Tx_Smarty_Service_Compatibility::getIndpEnv('TYPO3_SITE_URL');
    }
}
