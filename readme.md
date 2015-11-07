# tjbp/countries

A PHP lib providing fast and lightweight utilities for ISO 3166 country data.

## Installation

Run the following within your project directory to install as a dependency:

```sh
composer require tjbp/countries
```

## Usage

### Quick start

```php
use Tjbp\Currencies\Iso3166;

Iso3166::get('GB')->name; // "United Kingdom of Great Britain and Northern Ireland (the)"
```

### More detailed

```php
use Tjbp\Countries\Iso3166;

// Country object is returned with four properties
Iso3166::get('GB')->name; //
Iso3166::get('GB')->alpha2; // GB
Iso3166::get('GB')->alpha3; // GBR
Iso3166::get('GB')->numeric3; // 826

// Alternatively use an object
$countries = new Iso3166;

$countries->get('GB')->alpha2; // GB

// Or get by specific identifiers if you prefer
Iso3166::getByAlpha2('GB')->alpha2; // GB
Iso3166::getByAlpha3('GBR')->alpha2; // GB
Iso3166::getByNumeric3(826)->alpha2; // GB



// Use the Iso3166::get() method to return a Country object
$country = Iso3166::get('GB');

// Country has four properties
$country->name; // "United Kingdom of Great Britain and Northern Ireland (the)"
$country->alpha2; // "GB"
$country->alpha3; // "GBR"
$country->numeric3; // 826

// Alternatively instantiate Iso3166
$iso4217 = new Iso3166;
$country = $iso4217->get('GBP');

// There are also specific identifiers if you prefer
$country = Iso3166::getByAlpha2('GB');
$country = Iso3166::getByAlpha3('GBP');
$country = Iso3166::getByNumeric3(827);
```

Additionally you can use the HasCountries trait to access the Iso3166::get() method from within an object:

```php
use Tjbp\Currencies\HasCountries;

class Example
{
    use HasCountries;

    public method example()
    {
        $this->countries('GB')->name; // "United Kingdom of Great Britain and Northern Ireland (the)"
    }
}
```

## Building

Run `bin/build` if you wish to regenerate the library using the latest ISO3166 data (though the packaged source should be up-to-date).

## Contributing

Changes to the Iso3166 class are made to `src/templates/Iso3166.php`, since `src/Iso3166.php` will be overwritten when new versions are built.

## Notes

Take a look at [https://packagist.org/packages/tjbp/currencies](tjbp/currencies)
