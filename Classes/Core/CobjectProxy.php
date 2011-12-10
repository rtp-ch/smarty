<?php

class Tx_Smarty_Core_CobjectProxy
{
    /**
     * @var tslib_fe Contains a backup of the current $GLOBALS['TSFE'] if used in BE mode
     */
    private $tsfeBackup                 = null;

    /**
     * @var tslib_cObj
     */
    private $contentObject              = null;

    /**
     * @throws RuntimeException
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
     * Reroutes cObj method calls to the tslib_cObj instance
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public final function __call($method, array $args = array())
    {
        if(!method_exists($this->getContentObject(), $method)) {
            throw new BadMethodCallException('No such method');
        }
        return call_user_func_array(array($this->getContentObject(), $method), $args);
    }

    /**
     * Creates a tslib_Cobj instance for backend mode
     *
     * @return Tx_Smarty_Core_CobjectProxy
     * @see Tx_Extbase_Utility_FrontendSimulator::simulateFrontendEnvironment
     */
    protected function simulateFrontendEnvironment()
    {
        $this->tsfeBackup = isset($GLOBALS['TSFE']) ? $GLOBALS['TSFE'] : null;
        // This somewhat hacky work around is currently needed because the cObjGetSingle()
        // function of tslib_cObj relies on this setting
        $GLOBALS['TSFE'] = new stdClass();
        // Sets the $TSFE->cObjectDepthCounter in Backend mode
        $GLOBALS['TSFE']->cObjectDepthCounter = 100;
        $GLOBALS['TSFE']->cObj = t3lib_div::makeInstance('tslib_cObj');
        $GLOBALS['TSFE']->cObj->start(array());
        return $this;
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
     * @param tslib_cObj $contentObject
     * @return Tx_Smarty_Core_CobjectProxy
     * @throws InvalidArgumentException
     */
    protected function setContentObject(tslib_cObj $contentObject)
    {
        if(!($contentObject instanceof tslib_cObj)) {
            throw new InvalidArgumentException('Shadupayouface!');
        }
        $this->contentObject = $contentObject;
        return $this;
    }

    /**
     * Resets $GLOBALS['TSFE'] if it was previously changed by simulateFrontendEnvironment()
     *
     * @return void
     * @see Tx_Extbase_Utility_FrontendSimulator::resetFrontendEnvironment
     */
    public final function __destruct()
    {
        if(!is_null($this->tsfeBackup)) {
            $GLOBALS['TSFE'] = $this->tsfeBackup;
        }
    }
}