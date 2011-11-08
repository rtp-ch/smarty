<?php

require_once t3lib_extMgm::extPath('smarty') . 'Vendor/Smarty/Smarty.class.php';
//require_once t3lib_extMgm::extPath('smarty') . 'Vendor/Smarty/SmartyBC.class.php';

class Tx_Smarty_Tests_Unit_Facade_ConfigurationTest
    extends tx_phpunit_testcase
{

    /**
     * @var null
     */
    protected $configuration;

    /**
     * @return void
     */
    public function setUp()
    {
        /*$methods = array(
            'setTemplateDir',
            'addTemplateDir',
            'getTemplateDir',
            'getPluginsDir',
            'addPluginsDir',
            'setPluginsDir'
        );
        $properties = array(
            'template_dir',
            'plugins_dir',
            'cache_id',
            'compile_id',
            'left_delimiter',
            'right_delimiter'
        );
		$smartyInstance = $this->getMock('Tx_Smarty_Facade_Wrapper', array('dummy'), array(), '', FALSE);*/
        $this->smarty = t3lib_div::makeInstance('Tx_Smarty_Facade_Wrapper');
        $this->configuration = t3lib_div::makeInstance('Tx_Smarty_Facade_Configuration', $this->smarty);
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
        $this->configuration->unsetTemplateDir();
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function throwsExceptionWhenNoPropertyIsGiven()
    {
        $this->configuration->set();
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function throwsExceptionWhenPropertyDoesNotExist()
    {
        $this->configuration->setNotAValidProperty();
    }

    /**
     * @test
     */
    public function templateDirCanBeSet()
    {
        $value = 'testSetting';
        $this->configuration->setTemlateDir($value);
        $this->assertEquals($this->smarty->template_dir, $value);
    }
}
