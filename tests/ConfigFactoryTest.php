<?php
/**
 * Bright Nucleus Config Component.
 *
 * @package   BrightNucleus\Config
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   MIT
 * @link      http://www.brightnucleus.com/
 * @copyright 2016 Alain Schlesser, Bright Nucleus
 */

namespace BrightNucleus\Config;

/**
 * Class ConfigFactoryTest.
 *
 * @since   0.3.0
 *
 * @package BrightNucleus\Config
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class ConfigFactoryTest extends \PHPUnit_Framework_TestCase
{

    /*
     * TODO: There's still lots of work to do to render these tests useful.
     */

    /*
     * Don't use an array const to avoid bumping PHP requirement to 5.6.
     */
    protected static $test_array = [
        'random_string'    => 'test_value',
        'positive_integer' => 42,
        'negative_integer' => -256,
        'positive_boolean' => true,
        'negative_boolean' => false,
    ];

    protected static $test_multi_array = [
        'level1' => [
            'level2' => [
                'level3' => [
                    'level4_key' => 'level4_value',
                ],
            ],
        ],
    ];

    /**
     * Test creation from file.
     *
     * @covers \BrightNucleus\Config\ConfigFactory::createFromFile
     *
     * @since  0.3.0
     */
    public function testCreateFromFile()
    {
        $config = ConfigFactory::createFromFile(__DIR__ . '/fixtures/config_file.php');

        $this->assertInstanceOf('\BrightNucleus\Config\ConfigInterface', $config);
        $this->assertInstanceOf('\BrightNucleus\Config\AbstractConfig', $config);
        $this->assertInstanceOf('\BrightNucleus\Config\Config', $config);
        $this->assertTrue($config->hasKey('random_string'));

        $config2 = ConfigFactory::createFromFile(
            'nonsense_file.php',
            'still_nonsense.txt',
            __DIR__ . '/fixtures/config_file.php'
        );

        $this->assertInstanceOf('\BrightNucleus\Config\ConfigInterface', $config2);
        $this->assertInstanceOf('\BrightNucleus\Config\AbstractConfig', $config2);
        $this->assertInstanceOf('\BrightNucleus\Config\Config', $config2);
        $this->assertTrue($config2->hasKey('random_string'));
    }

    /**
     * Test creation from array.
     *
     * @covers \BrightNucleus\Config\ConfigFactory::createFromArray
     *
     * @since  0.3.0
     */
    public function testCreateFromArray()
    {
        $config = ConfigFactory::createFromArray(['some_key' => 'some_value']);

        $this->assertInstanceOf('\BrightNucleus\Config\ConfigInterface', $config);
        $this->assertInstanceOf('\BrightNucleus\Config\AbstractConfig', $config);
        $this->assertInstanceOf('\BrightNucleus\Config\Config', $config);
        $this->assertTrue($config->hasKey('some_key'));
        $this->assertEquals('some_value', $config->getKey('some_key'));
    }

    /**
     * Test creation from best guess using one file.
     *
     * @covers \BrightNucleus\Config\ConfigFactory::create
     *
     * @since  0.3.0
     */
    public function testCreateFromBestGuessUsingOneFile()
    {
        $config = ConfigFactory::create(__DIR__ . '/fixtures/config_file.php');

        $this->assertInstanceOf('\BrightNucleus\Config\ConfigInterface', $config);
        $this->assertInstanceOf('\BrightNucleus\Config\AbstractConfig', $config);
        $this->assertInstanceOf('\BrightNucleus\Config\Config', $config);
        $this->assertTrue($config->hasKey('random_string'));
    }

    /**
     * Test creation from best guess using several files.
     *
     * @covers \BrightNucleus\Config\ConfigFactory::create
     *
     * @since  0.3.0
     */
    public function testCreateFromBestGuessUsingSeveralFiles()
    {
        $config = ConfigFactory::create(
            'nonsense_file.php',
            'still_nonsense.txt',
            __DIR__ . '/fixtures/config_file.php'
        );

        $this->assertInstanceOf('\BrightNucleus\Config\ConfigInterface', $config);
        $this->assertInstanceOf('\BrightNucleus\Config\AbstractConfig', $config);
        $this->assertInstanceOf('\BrightNucleus\Config\Config', $config);
        $this->assertTrue($config->hasKey('random_string'));
    }

    /**
     * Test creation from best guess using an array.
     *
     * @covers \BrightNucleus\Config\ConfigFactory::create
     *
     * @since  0.3.0
     */
    public function testCreateFromBestGuessUsingAnArray()
    {
        $config = ConfigFactory::create(['some_key' => 'some_value']);

        $this->assertInstanceOf('\BrightNucleus\Config\ConfigInterface', $config);
        $this->assertInstanceOf('\BrightNucleus\Config\AbstractConfig', $config);
        $this->assertInstanceOf('\BrightNucleus\Config\Config', $config);
        $this->assertTrue($config->hasKey('some_key'));
        $this->assertEquals('some_value', $config->getKey('some_key'));
    }
}