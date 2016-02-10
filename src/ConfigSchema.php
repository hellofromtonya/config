<?php
/**
 * Generic Config Schema Class.
 *
 * @package   BrightNucleus\Config
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   GPL-2.0+
 * @link      http://www.brightnucleus.com/
 * @copyright 2016 Alain Schlesser, Bright Nucleus
 */

namespace BrightNucleus\Config;

use InvalidArgumentException;
use BrightNucleus\Config\ConfigInterface;

/**
 * Class ConfigSchema
 *
 * @since   0.1.0
 *
 * @package BrightNucleus\Config
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class ConfigSchema extends AbstractConfigSchema
{

    /**
     * The key that is used in the schema to define a required value.
     */
    const REQUIRED_KEY = 'required';

    /**
     * The key that is used in the schema to define a default value.
     */
    const DEFAULT_VALUE = 'default';

    /**
     * The list of values that are recognized as true in the schema.
     */
    const TRUTHY_VALUES = [
        true,
        1,
        'true',
        'True',
        'TRUE',
        'y',
        'Y',
        'yes',
        'Yes',
        'YES',
        '√',
    ];

    /**
     * Instantiate a ConfigSchema object.
     *
     * @since 0.1.0
     *
     * @param ConfigInterface|array $schema The schema to parse.
     * @throws InvalidArgumentException
     */
    public function __construct($schema)
    {
        if ($schema instanceof ConfigInterface) {
            $schema = $schema->getArrayCopy();
        }

        if ( ! is_array($schema)) {
            throw new InvalidArgumentException(sprintf(
                _('Invalid schema source: %1$s'),
                print_r($schema, true)
            ));
        }

        array_walk($schema, [$this, 'parseSchema']);
    }

    /**
     * Parse a single provided schema entry.
     *
     * @since 0.1.0
     *
     * @param mixed  $data The data associated with the key.
     * @param string $key  The key of the schema data.
     */
    protected function parseSchema($data, $key)
    {
        $this->parseDefined($key, $data);

        if (array_key_exists(self::REQUIRED_KEY, $data)) {
            $this->parseRequired($key,
                $data[self::REQUIRED_KEY]);
        }

        if (array_key_exists(self::DEFAULT_VALUE, $data)) {
            $this->parseDefault($key,
                $data[self::DEFAULT_VALUE]);
        }
    }

    /**
     * Parse the set of defined values.
     *
     * @since 0.1.0
     *
     * @param string $key  The key of the schema data.
     * @param mixed  $data The data associated with the key.
     */
    protected function parseDefined($key, $data)
    {
        $this->defined[] = $key;
    }

    /**
     * Parse the set of required values.
     *
     * @since 0.1.0
     *
     * @param string $key  The key of the schema data.
     * @param mixed  $data The data associated with the key.
     */
    protected function parseRequired($key, $data)
    {
        if ($this->isTruthy($data)) {
            $this->required[] = $key;
        }
    }

    /**
     * Parse the set of default values.
     *
     * @since 0.1.0
     *
     * @param string $key  The key of the schema data.
     * @param mixed  $data The data associated with the key.
     */
    protected function parseDefault($key, $data)
    {
        $this->defaults[$key] = $data;
    }

    /**
     * Return a boolean true or false for an arbitrary set of data. Recognizes
     * several different string values that should be valued as true.
     *
     * @since 0.1.0
     *
     * @param mixed $data The data to evaluate.
     * @return bool
     */
    protected function isTruthy($data)
    {
        return in_array($data, self::TRUTHY_VALUES, true);
    }
}
