<?php

/**
 * The Helper class file.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright Copyright (c) 2012 by Herzog August Bibliothek Wolfenbüttel
 */

namespace HAB;

/**
 * A collection of helper functions.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright Copyright (c) 2012 by Herzog August Bibliothek Wolfenbüttel
 */
abstract class Helper 
{

  /**
   * Return the complement of a function.
   *
   * The complement of a function is a function that takes the same arguments
   * as the original function but returns a boolean with the opposite truth
   * value.
   *
   * @param  callback $function Original function
   * @return callback Complement function
   */
  public static function complement ($function) 
  {
    return function () use ($function) { return !call_user_func_array($function, func_get_args()); };
  }

  /**
   * Return an array of the results of calling a method for each element of a
   * sequence.
   *
   * @param  array $sequence Sequence of objects
   * @param  string $method Name of the method
   * @param  array $arguments Optional array of method arguments
   * @return array Result of calling method on each element of sequence
   */
  public static function mapMethod (array $sequence, $method, array $arguments = array()) 
  {
    if (empty($arguments)) {
      $f = function ($element) use ($method) {
        return $element->$method();
      };
    } else {
      $f = function ($element) use ($method, $arguments) {
        return call_user_func_array(array($element, $method), $arguments);
      };
    }
    return array_map($f, $sequence);
  }

  /**
   * Return an array with clones of each element in sequence.
   *
   * @param  array $sequence Sequence of objects
   * @return array Sequence of clones
   */
  public static function mapClone (array $sequence) 
  {
    return array_map(function ($element) { return clone($element); }, $sequence);
  }

  /**
   * Return TRUE if at least one element of sequence matches predicate.
   *
   * @param  array $sequence Sequence
   * @param  callback $predicate Predicate
   * @return boolean TRUE if at least one element matches predicate
   */
  public static function some (array $sequence, $predicate) 
  {
    foreach ($sequence as $element) {
      if (call_user_func($predicate, $element)) {
        return true;
      }
    }
    return false;
  }

  /**
   * Return TRUE if every element of sequence fullfills predicate.
   *
   * @param  array $sequence Sequence
   * @param  callback $predicate Predicate
   * @return boolean TRUE if every element fullfills predicate
   */
  public static function every (array $sequence, $predicate) 
  {
    foreach ($sequence as $element) {
      if (!call_user_func($predicate, $element)) {
        return false;
      }
    }
    return true;
  }

  /**
   * Flatten sequence.
   *
   * @param  array $sequence Sequence
   * @return array Flattend sequence
   */
  public static function flatten (array $sequence) 
  {
    $flat = array();
    array_walk_recursive($sequence, function ($element) use (&$flat) { $flat []= $element; });
    return $flat;
  }

  /**
   * Return function that takes any number of arguments, has no side-effect
   * and constantly returns a value.
   *
   * @param  mixed $value Value to return
   * @return callback Function that constantly returns the value
   */
  public static function constantly ($value)
  {
      return function () use ($value) { return $value; };
  }

}