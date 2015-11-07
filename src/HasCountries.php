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

trait HasCountries
{
    /**
     * Return a list of countries.
     *
     * @return array
     */
    private function countries()
    {
        return Iso3166::all();
    }

    /**
     * Find a country by any of its identifiers.
     *
     * @param mixed $code
     * @return array
     */
    private function country($code)
    {
        return Iso3166::get($code);
    }
}
