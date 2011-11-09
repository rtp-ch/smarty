<?php

//require_once t3lib_extMgm::extPath('smarty') . 'Vendor/Smarty/Smarty.class.php';
//require_once t3lib_extMgm::extPath('smarty') . 'Vendor/Smarty/SmartyBC.class.php';

class Tx_Smarty_Tests_Unit_Facade_ConfigurationTest
    extends tx_phpunit_testcase
{

    /**
     * @var Tx_Smarty_Facade_Configuration
     */
    protected $configuration        = null;

    /**
     * @var string
     */
    const TEST_SETTING              = 'someTestSetting';

    /**
     * @return void
     */
    public function setUp()
    {
        $this->smarty = t3lib_div::makeInstance('Tx_Smarty_Facade_Wrapper');
        //$this->smarty = t3lib_div::makeInstance('Tx_Smarty_Facade_Configuration', $this->smarty);
    }

    /**
     * @return void
     */
	public function tearDown()
    {
		t3lib_div::purgeInstances();
	}

    /**
     * @test
     * @expectedException BadMethodCallException
     */
    public function throwsExceptionWhenNoActionCanBeFound()
    {
        $this->smarty->unsetTemplateDir();
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function throwsExceptionWhenNoPropertyIsGiven()
    {
        $this->smarty->set();
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function throwsExceptionWhenPropertyDoesNotExist()
    {
        $this->smarty->setNotAValidProperty();
    }

    /**
     * @test
     */
    public function setPropertyMethodCanBeAccessed()
    {
        $this->smarty->setTemplateDir(self::TEST_SETTING);
        $this->assertEquals($this->smarty->template_dir, array(self::TEST_SETTING . DS));
    }

    /**
     * @test
     * @depends setPropertyMethodCanBeAccessed
     */
    public function getPropertyMethodCanBeAccessed()
    {
        $this->smarty->setTemplateDir(self::TEST_SETTING);
        $this->assertEquals($this->smarty->getTemplateDir(), array(self::TEST_SETTING . DS));
    }

    /**
     * @test
     * @depends setPropertyMethodCanBeAccessed
     */
    public function addPropertyMethodCanBeAccessed()
    {
        $this->smarty->setTemplateDir(self::TEST_SETTING);
        $this->smarty->addTemplateDir(self::TEST_SETTING);
        $this->assertEquals($this->smarty->template_dir, array(self::TEST_SETTING . DS, self::TEST_SETTING . DS));
    }

    /**
     * @test
     */
    public function canSetPropertyDirectly()
    {
        $this->smarty->setLeftDelimiter(self::TEST_SETTING);
        $this->assertEquals($this->smarty->left_delimiter, self::TEST_SETTING);
    }

    /**
     * @test
     * @depends canSetPropertyDirectly
     */
    public function canGetPropertyDirectly()
    {
        $this->smarty->setLeftDelimiter(self::TEST_SETTING);
        $this->assertEquals($this->smarty->left_delimiter, self::TEST_SETTING);
    }

    /**
     * @test
     * @depends canSetPropertyDirectly
     * @expectedException BadMethodCallException
     */
    public function cannotAddPropertyDirectly()
    {
        $this->smarty->addLeftDelimiter(self::TEST_SETTING);
    }
}
