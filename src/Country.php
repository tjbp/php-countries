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

class Country
{
    /**
     * English language name of the country.
     *
     * @var $name
     */
    public $name;

    /**
     * Alphabetic two-character identifier for the country.
     *
     * @var $alpha2
     */
    public $alpha2;

    /**
     * Alphabetic three-character identifier for the country.
     *
     * @var $alpha3
     */
    public $alpha3;

    /**
     * Numeric three-character identifier for the country.
     *
     * @var $numeric3
     */
    public $numeric3;

    /**
     * Assign data to properties.
     *
     * @param array $currencyData
     * @return void
     */
    public function __construct(Array $countryData)
    {
        $this->name = $countryData['name'];

        $this->alpha2 = $countryData['alpha2'];

        $this->alpha3 = $countryData['alpha3'];

        $this->numeric3 = $countryData['numeric3'];
    }
}
