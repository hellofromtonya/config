<?php
/**
 * Config Interface
 *
 * @package   BrightNucleus\Config
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.brightnucleus.com/
 * @copyright 2016 Alain Schlesser, Bright Nucleus
 */

namespace BrightNucleus\Config;

use Countable;
use ArrayAccess;
use Serializable;
use IteratorAggregate;

/**
 * Config loader used to load config PHP files as objects.
 *
 * @since      0.1.0
 *
 * @package    BrightNucleus\Config
 * @author     Alain Schlesser <alain.schlesser@gmail.com>
 */
interface ConfigInterface extends IteratorAggregate, ArrayAccess, Serializable, Countable
{

    /**
     * Creates a copy of the ArrayObject.
     *
     * Returns a copy of the array. When the ArrayObject refers to an object an
     * array of the public properties of that object will be returned.
     * This is implemented by \ArrayObject.
     *
     * @since 0.1.0
     *
     * @return array Copy of the array.
     */
    public function getArrayCopy();

    /**
     * Check whether the Config has a specific key.
     *
     * To check a value several levels deep, add the keys for each level as a comma-separated list.
     *
     * @since 0.1.0
     * @since 0.1.4 Accepts list of keys.
     *
     * @param string ... List of keys.
     * @return bool
     */
    public function hasKey();

    /**
     * Get the value of a specific key.
     *
     * To get a value several levels deep, add the keys for each level as a comma-separated list.
     *
     * @since 0.1.0
     * @since 0.1.4 Accepts list of keys.
     *
     * @param string ... List of keys.
     *
     * @return mixed
     */
    public function getKey();

    /**
     * Get a (multi-dimensional) array of all the configuration settings.
     *
     * @since 0.1.4
     *
     * @return array
     */
    public function getAll();

    /**
     * Get the an array with all the keys
     *
     * @since 0.1.0
     *
     * @return mixed
     */
    public function getKeys();

    /**
     * Is the Config valid?
     *
     * @since 0.1.0
     *
     * @return boolean
     */
    public function isValid();
}
