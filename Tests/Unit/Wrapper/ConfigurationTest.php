<?php

class Tx_Smarty_Tests_Unit_Wrapper_ConfigurationTest
    extends tx_phpunit_testcase
{

    /**
     * @var null
     */
    protected $configuration    = null;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->configuration = t3lib_div::makeInstance('Tx_Smarty_Wrapper_Configuration');
    }

    /**
     * @return void
     */
	public function tearDown()
    {
		t3lib_div::purgeInstances();
	}


    /**
     * @param $setting
     * @return bool
     */
    public function settingIsPath()
    {
        $pathSetting = 'some_valid_dir';
        $this->assertTrue($this->configuration->isPath($pathSetting));
    }

    /**
     * @test
     */
    public function settingIsNotPath()
    {
        $nonPathSetting = 'not_a_valid_path';
        error_log($this->configuration->isPath($nonPathSetting));
        $this->assertFalse($this->configuration->isPath($nonPathSetting), 'Whoops!');
    }


    /**
     * @test
     */
    private function resolvesValidDirectory()
    {
        $validDir       = 'EXT:smarty/Tests/Unit/Wrapper';
        $expectedValue  = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        $this->assertEquals($expectedValue, $this->configuration->getPath($validDir));
    }

    /**
     * @test
     */
    public function actionIsGetter()
    {
        $validGetter = 'get';
        $this->assertTrue($this->configuration->isGetter($validGetter));
    }

    /**
     * @test
     */
    public function actionIsNotGetter()
    {
        $invalidGetter = 'bla';
        $this->assertFalse($this->configuration->isGetter($invalidGetter));
    }

    /**
     * @test
     */
    public function actionIsSetter()
    {
        $validSetter = 'set';
        $this->assertTrue($this->configuration->isSetter($validSetter));
        
        $validSetter = 'add';
        $this->assertTrue($this->configuration->isSetter($validSetter));
    }

    /**
     * @test
     */
    public function actionIsNotSetter()
    {
        $invalidSetter = 'bla';
        $this->assertFalse($this->configuration->isSetter($invalidSetter));
    }

    /**
     * @test
     */
    public function propertyGetsSplitByUppercaseCharacters()
    {
        $propertyName   = 'thisShouldBeSplitByUppercaseCharacter';
        $expectedValue  = 'this_should_be_split_by_uppercase_character';
        $actualValue    = $this->configuration->getPropertyName($propertyName);
        $this->assertEquals($expectedValue, $actualValue);
    }

    /**
     * @test
     */
    public function lowercasePropertyDoesNotSplit()
    {
        $propertyName   = 'thisstringshouldnotbesplit';
        $actualValue    = $this->configuration->getPropertyName($propertyName);
        $this->assertEquals($propertyName, $actualValue);
    }

    /**
     * @test
     */
    public function findsPublicPropertyInSmartyClass()
    {
        $protectedProperty  = 'right_delimiter';
        $this->assertTrue($this->configuration->hasProperty($protectedProperty));
    }

    /**
     * @test
     */
    public function findsProtectedPropertyInSmartyClass()
    {
        $protectedProperty  = 'template_dir';
        $this->assertTrue($this->configuration->hasProperty($protectedProperty));
    }
}
