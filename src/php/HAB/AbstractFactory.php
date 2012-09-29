<?php

/**
 * AbstractFactory class file.
 *
 * PHP version 5
 *
 * @author   David Maus <maus@hab.de>
 * @license  http://sam.zoy.org/wtfpl/COPYING WTFPL 2.0
 * @link     https://github.com/dmj/HHelper
 */

namespace VuFindSearch;

/**
 * Factory for search system components.
 *
 * @author   David Maus <maus@hab.de>
 * @license  http://sam.zoy.org/wtfpl/COPYING WTFPL 2.0
 * @link     https://github.com/dmj/HHelper
 */

abstract class AbstractFactory
{

    /**
     * Version identifier.
     *
     * @var string
     */
    const VERSION = '0.1';

    /**
     * Create new component.
     *
     * @param array $config Configuration
     *
     * @return mixed
     */
    final public static function create (array $config)
    {
        if (!isset($config['class'])) {
            throw new \InvalidArgumentException('Missing class parameter in object configuration');
        }
        $class  = $config['class'];
        $config = isset($config['config']) ? $config['config'] : array();
        $instance = new $class();
        foreach ($config as $key => $value) {
            $setter = 'set' . ucfirst($key);
            $instance->$setter($value);
        }
        $instance->init();
        return $instance;
    }

}