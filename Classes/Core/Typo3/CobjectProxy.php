<?php

class Tx_Smarty_Core_Typo3_CobjectProxy
{

    /**
     * @var tslib_fe contains a backup of the current $GLOBALS['TSFE'] if used in BE mode
     */
    private $tsfeBackup                 = null;

    /**
     * @var tslib_fe contains a backup of the current $GLOBALS['TSFE'] if used in BE mode
     */
    private $contentObject              = null;

    /**
     * @throws RuntimeException
     * 
     */
    public function __construct()
    {
        if (Tx_Smarty_Utility_Typo3::isFeInstance()) {
            $this->setContentObject($GLOBALS['TSFE']->cObj);

        } elseif (Tx_Smarty_Utility_Typo3::isBeInstance()) {
            $this->simulateFrontendEnvironment();
            $this->setContentObject($GLOBALS['TSFE']->cObj);

        } else {
            throw new RuntimeException('WTF');
        }
    }

    /**
     * Reroutes cObj methods to the tslib_cObj instance
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public final function __call($method, array $args = array())
    {
        return call_user_func_array(array($this->getContentObject(), $method), $args);
    }

    /**
     * Sets the $TSFE->cObjectDepthCounter in Backend mode
     * This somewhat hacky work around is currently needed because the cObjGetSingle() function of tslib_cObj relies on this setting
     *
     * @return void
     * @author Bastian Waidelich <bastian@typo3.org>
     * @coauthor Simon Tuck <stu@rtp.ch>
     */
    protected function simulateFrontendEnvironment()
    {
        $this->tsfeBackup = isset($GLOBALS['TSFE']) ? $GLOBALS['TSFE'] : null;
        $GLOBALS['TSFE'] = new stdClass();
        $GLOBALS['TSFE']->cObjectDepthCounter = 100;
        $GLOBALS['TSFE']->cObj = t3lib_div::makeInstance('tslib_cObj');
        $GLOBALS['TSFE']->cObj->start(array(), 'pages');
    }

    /**
     * @return tslib_cObj
     */
    protected function getContentObject()
    {
        if(!($this->contentObject instanceof tslib_cObj)) {
            throw new UnexpectedValueException('Shadupayouface!');
        }
        return $this->contentObject;
    }

    /**
     * @throws InvalidArgumentException
     * @param tslib_cObj $contentObject
     * @return void
     */
    protected function setContentObject(tslib_cObj $contentObject)
    {
        if(!($contentObject instanceof tslib_cObj)) {
            throw new InvalidArgumentException('Shadupayouface!');
        }
        $this->contentObject = $contentObject;
    }

    /**
     * Resets $GLOBALS['TSFE'] if it was previously changed by simulateFrontendEnvironment()
     *
     * @return void
     * @author Bastian Waidelich <bastian@typo3.org>
     * @see simulateFrontendEnvironment()
     */
    public final function __destruct()
    {
        if(!is_null($this->tsfeBackup)) {
            $GLOBALS['TSFE'] = $this->tsfeBackup;
        }
    }
}