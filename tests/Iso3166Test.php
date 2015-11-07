<?php

namespace Tjbp\Countries;

use PHPUnit_Framework_TestCase;

class Iso3166Test extends PHPUnit_Framework_TestCase
{
    /**
     * @covers \Tjbp\Countries\Iso3166::__construct
     */
    public function testCanBeConstructed()
    {
        $this->assertInstanceOf(Iso3166::class, new Iso3166);
    }

    /**
     * @covers \Tjbp\Countries\Iso3166::get
     * @depends testCanBeConstructed
     */
    public function testObjectReturnsCountryObject()
    {
        $iso3166 = new Iso3166;

        $this->assertInstanceOf(Country::class, $iso3166->get('GB'));
    }

    /**
     * @covers \Tjbp\Countries\Iso3166::get
     * @depends testCanBeConstructed
     * @expectedException BadMethodCallException
     */
    public function testInvalidObjectMethod()
    {
        $iso3166 = new Iso3166;

        $iso3166->badMethodCall();
    }

    /**
     * @covers \Tjbp\Countries\Iso3166::get
     */
    public function testStaticReturnsCountryObject()
    {
        $this->assertInstanceOf(Country::class, Iso3166::get('GB'));
    }

    /**
     * @expectedException OutOfBoundsException
     */
    public function testUnknownCodeFails()
    {
        Iso3166::get('ZZ');
    }

    /**
     * @expectedException OutOfBoundsException
     */
    public function testUnknownAlpha2Fails()
    {
        Iso3166::getByAlpha3('ZZ');
    }

    /**
     * @expectedException OutOfBoundsException
     */
    public function testUnknownAlpha3Fails()
    {
        Iso3166::getByAlpha3('ZZZ');
    }

    /**
     * @expectedException OutOfBoundsException
     */
    public function testUnknownNumeric3Fails()
    {
        Iso3166::getByNumeric3('000');
    }

    /**
     * @covers \Tjbp\Countries\Iso3166::get
     * @depends testStaticReturnsCountryObject
     */
    public function testCountryObjectHasAlpha3()
    {
        $this->assertObjectHasAttribute('alpha3', Iso3166::get('GB'));
    }

    /**
     * @covers \Tjbp\Countries\Iso3166::get
     * @depends testStaticReturnsCountryObject
     */
    public function testCountryObjectHasNumeric3()
    {
        $this->assertObjectHasAttribute('numeric3', Iso3166::get('GB'));
    }

    /**
     * @covers \Tjbp\Countries\Iso3166::all
     */
    public function testGetAllReturnsArray()
    {
        $this->assertInternalType('array', Iso3166::all());
    }

    /**
     * @covers \Tjbp\Countries\Iso3166::all
     * @depends testGetAllReturnsArray
     */
    public function testHasCountries()
    {
        $this->assertNotEmpty(Iso3166::all());
    }
}
