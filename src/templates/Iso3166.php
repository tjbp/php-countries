<?php

/*

This file is part of tjbp/countries.

tjbp/countries is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

tjbp/countries is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with tjbp/countries.  If not, see <http://www.gnu.org/licenses/>.

*/

namespace Tjbp\Countries;

use BadMethodCallException;
use OutOfBoundsException;

class Iso3166
{
    /**
     * Database of ISO 3166 data.
     *
     * @var array
     */
    private static $countries /* countries */;

    /**
     * Index of alpha3 codes to speed the lookup.
     *
     * @var array
     */
    private static $alpha3Index /* alpha3_index */;

    /**
     * Index of numeric3 codes to speed the lookup.
     *
     * @var array
     */
    private static $numeric3Index /* numeric3_index */;

    /**
     * Magic method to redirect calls to object methods towards static methods.
     *
     * @param string $method
     * @param array $args
     * @return array
     */
    public function __call($method, $args)
    {
        if (!method_exists($this, $method)) {
            throw new BadMethodCallException;
        }

        return forward_static_call_array([static::class, $method], $args);
    }

    /**
     * Returns true if code is a known identifier.
     *
     * @param mixed $code
     * @return boolean
     */
    public static function exists($code)
    {
        try {
            static::get($code);
        } catch (OutOfBoundsException $e) {
            return false;
        }

        return true;
    }

    /**
     * Try all methods for a result.
     *
     * @param mixed $code
     * @return array
     */
    public static function get($code)
    {
        try {
            return static::getByAlpha2($code);
        } catch (OutOfBoundsException $e) {
            try {
                return static::getByAlpha3($code);
            } catch (OutOfBoundsException $e) {
                try {
                    return static::getByNumeric3($code);
                } catch (OutOfBoundsException $e) {
                    throw new OutOfBoundsException("The code \"{$code}\" is not listed in ISO 4217");
                }
            }
        }
    }

    /**
     * Find and return country by its alphabetic two-character identifier.
     *
     * @param string $alpha2
     * @return array
     */
    public static function getByAlpha2($alpha2)
    {
        $alpha2 = strtoupper($alpha2);

        if (!isset(static::$countries[$alpha2])) {
            throw new OutOfBoundsException("The 2 character alpha code \"$alpha2\" is not listed in ISO 3166");
        }

        return new Country(static::$countries[$alpha2]);
    }

    /**
     * Find and return country by its alphabetic three-character identifier.
     *
     * @param string $alpha3
     * @return array
     */
    public static function getByAlpha3($alpha3)
    {
        $alpha3 = strtoupper($alpha3);

        if (!isset(static::$alpha3Index[$alpha3])) {
            throw new OutOfBoundsException("The 3 character alpha code \"$alpha3\" is not listed in ISO 3166");
        }

        return new Country(static::$countries[static::$alpha3Index[$alpha3]]);
    }

    /**
     * Find and return country by its numeric three-character identifier.
     *
     * @param string $numeric3
     * @return array
     */
    public static function getByNumeric3($numeric3)
    {
        $numeric3 = strtoupper($numeric3);

        if (!isset(static::$numeric3Index[$numeric3])) {
            throw new OutOfBoundsException("The 3 character numeric code \"$numeric3\" is not listed in ISO 3166");
        }

        return new Country(static::$countries[static::$numeric3Index[$numeric3]]);
    }

    /**
     * Return all countries as a numerically-keyed array.
     *
     * @return array
     */
    public static function all()
    {
        return array_values(static::$countries);
    }
}
