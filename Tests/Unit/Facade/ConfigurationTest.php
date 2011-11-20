<?php


class Tx_Smarty_Tests_Unit_Facade_ConfigurationTest
    extends tx_phpunit_testcase
{

    /**
     * @var Tx_Smarty_Facade_Wrapper
     */
    protected $smarty;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->smarty = t3lib_div::makeInstance('Tx_Smarty_Facade_Wrapper');
    }

    /**
     * @return void
     */
	public function tearDown()
    {
		t3lib_div::purgeInstances();
	}

    /**
     *
     * Return a unique id
     *
     * @static
     * @return string
     */
    public static function getTestValue()
    {
        return uniqid('smarty_', true);
    }

    /**
     *
     * Tests that smarty has an instance of the configuration class
     *
     * @test
     */
    public function smartyHasConfigurationInstance()
    {
        $this->assertInstanceOf('Tx_Smarty_Facade_Configuration', $this->smarty->getConfiguration());
    }
    
    /**
     *
     * Tests that an exception is thrown when the method doesn't have
     * a valid action (e.g. set, add or get).
     *
     * @test
     * @depends smartyHasConfigurationInstance
     * @expectedException Tx_Smarty_Exception_BadMethodCallException
     */
    public function methodWithoutValidAccessorActionThrowsException()
    {
        $this->smarty->unsetTemplateDir();
    }

    /**
     *
     * Tests that an exception is thrown when the method doesn't
     * contain any property.
     *
     * @test
     * @depends smartyHasConfigurationInstance
     * @expectedException Tx_Smarty_Exception_InvalidArgumentException
     */
    public function accessorWithoutPropertyThrowsException()
    {
        $this->smarty->set();
    }

    /**
     *
     * Tests that a setter for a non-existent smarty property throws
     * an exception.
     *
     * @test
     * @depends smartyHasConfigurationInstance
     * @expectedException Tx_Smarty_Exception_InvalidArgumentException
     */
    public function accessorWithoutValidPropertyThrowsException()
    {
        $this->smarty->setNotAValidProperty();
    }

    /**
     *
     * Tests the setting TYPO3 path resolves the setting to a valid path.
     *
     * @test
     * @depends smartyHasConfigurationInstance
     * @return void
     */
    public function dirSettingResolvesToDirectory()
    {
        $pathToDir = $this->smarty->getConfiguration()->getPaths('EXT:smarty/Tests/');
        $this->assertTrue(is_dir($pathToDir));
    }

    /**
     *
     * Tests the setting TYPO3 path resolves the setting to a valid path.
     *
     * @test
     * @depends smartyHasConfigurationInstance
     * @return void
     */
    public function fileSettingResolvesToFile()
    {
        $pathToFile = $this->smarty->getConfiguration()->getPaths('EXT:smarty/ext_emconf.php');
        $this->assertTrue(is_file($pathToFile));
    }

    /**
     *
     * Tests that setter method sets smarty property
     *
     * @test
     * @depends smartyHasConfigurationInstance
     * @depends dirSettingResolvesToDirectory
     * @depends fileSettingResolvesToFile
     */
    public function setterMethodSetsSmartyProperty()
    {
        $value = self::getTestValue();
        $this->smarty->setLeftDelimiter($value);
        $this->assertEquals($this->smarty->left_delimiter, $value);
    }

    /**
     *
     * Tests that getter method returns smarty property value
     *
     * @test
     * @depends smartyHasConfigurationInstance
     * @depends dirSettingResolvesToDirectory
     * @depends fileSettingResolvesToFile
     */
    public function getterMethodReturnsSmartyPropertyValue()
    {
        $value = self::getTestValue();
        $this->smarty->left_delimiter = $value;
        $this->assertEquals($this->smarty->getLeftDelimiter(), $value);
    }

    /**
     *
     * Tests that accessors call smarty getter/setters
     *
     * @test
     * @depends smartyHasConfigurationInstance
     * @depends dirSettingResolvesToDirectory
     * @depends fileSettingResolvesToFile
     */
    public function accessorsCallSmartyGetterSetters()
    {
        $value = $this->smarty->getConfiguration()->getPaths(self::getTestValue());
        $this->smarty->setTemplateDir($value);
        $this->assertEquals($this->smarty->getTemplateDir(), array($value . DS));
    }

    /**
     *
     * Tests that smarty adder method adds values to a smarty property
     *
     * @test
     * @depends smartyHasConfigurationInstance
     * @depends accessorsCallSmartyGetterSetters
     * @depends dirSettingResolvesToDirectory
     * @depends fileSettingResolvesToFile
     */
    public function adderMethodAddsToSmartyProperty()
    {
        $firstValue  = $this->smarty->getConfiguration()->getPaths(self::getTestValue());
        $secondValue = $this->smarty->getConfiguration()->getPaths(self::getTestValue());
        $this->smarty->setTemplateDir($firstValue);
        $this->smarty->addTemplateDir($secondValue);
        $this->assertEquals($this->smarty->getTemplateDir(), array($firstValue . DS, $secondValue . DS));
    }

    /**
     *
     * Tests that the adder method can only add using a
     * corresponding smarty adder method
     *
     * @test
     * @depends smartyHasConfigurationInstance
     * @depends adderMethodAddsToSmartyProperty
     * @expectedException Tx_Smarty_Exception_BadMethodCallException
     */
    public function adderCannotAddToPropertyWithoutCorrespondingSmartyAdder()
    {
        $value = self::getTestValue();
        $this->smarty->addLeftDelimiter($value);
    }

    /**
     *
     * Tests that deprecated template directory setter is rerouted
     * to the normal template directory.
     *
     * @test
     * @depends smartyHasConfigurationInstance
     * @depends setterMethodSetsSmartyProperty
     * @depends dirSettingResolvesToDirectory
     * @depends fileSettingResolvesToFile
     */
    public function deprecatedTemplateDirectorySetter()
    {
        $value = $this->smarty->getConfiguration()->getPaths(self::getTestValue());
        $this->smarty->setPathToTemplateDirectory($value);
        //$this->assertAttributeInternalType()

        $this->assertEquals($this->smarty->getTemplateDir(), array($value . DS));
    }

    /**
     *
     * Tests that deprecated language file setter is rerouted to the
     * normal language file setter.
     *
     * @test
     * @depends smartyHasConfigurationInstance
     * @depends setterMethodSetsSmartyProperty
     * @depends dirSettingResolvesToDirectory
     * @depends fileSettingResolvesToFile
     */
    public function deprecatedLanguageFileSetter()
    {
        $value = $this->smarty->getConfiguration()->getPaths(self::getTestValue());
        $this->smarty->setPathToLanguageFile($value);
        $this->assertEquals($this->smarty->getLanguageFile(), array($value . DS));
    }
}