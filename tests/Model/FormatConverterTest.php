<?php
/**
 * Created by PhpStorm.
 * User: carl
 * Date: 16/01/19
 * Time: 11:23
 */

namespace App\Model;

use PHPUnit\Framework\TestCase;

class FormatConverterTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_get_description()
    {
        $formatConverter = new FormatConverter();
        $string = "EVERITT ARCHITECTS    GREEN GABLES JKA   BBP";
        $this->assertEquals('BBP', $formatConverter->getDescription($string));

        $string = "WYCHAVON DC NNDR      01     500280599   DDR";
        $this->assertEquals('DDR', $formatConverter->getDescription($string));

        $string = "COTSWOLDTRANSPORT     INV1724            BBP";
        $this->assertEquals('BBP', $formatConverter->getDescription($string));

        $string = "REEDS RAINS EVESHA    201093800          BBP";
        $this->assertEquals('BBP', $formatConverter->getDescription($string));

        $string = "********************** COMMISSION FOR       ";
        $this->assertEquals('COMMISSION FOR', $formatConverter->getDescription($string));
    }

    /**
     * @test
     */
    public function it_should_get_description_empty_string_as_default()
    {
        $formatConverter = new FormatConverter();
        $string = "";

        $this->assertEquals('', $formatConverter->getDescription($string));
    }

    /**
     * @test
     */
    public function it_should_get_payee()
    {
        $formatConverter = new FormatConverter();
        $string = "EVERITT ARCHITECTS    GREEN GABLES JKA   BBP";
        $this->assertEquals('EVERITT ARCHITECTS', $formatConverter->getPayee($string));

        $string = "WYCHAVON DC NNDR      01     500280599   DDR";
        $this->assertEquals('WYCHAVON DC NNDR', $formatConverter->getPayee($string));

        $string = "COTSWOLDTRANSPORT     INV1724            BBP";
        $this->assertEquals('COTSWOLDTRANSPORT', $formatConverter->getPayee($string));

        $string = "REEDS RAINS EVESHA    201093800          BBP";
        $this->assertEquals('REEDS RAINS EVESHA', $formatConverter->getPayee($string));

        $string = "********************** COMMISSION FOR       ";
        $this->assertEquals('**********************', $formatConverter->getPayee($string));
    }

    /**
     * @test
     */
    public function it_should_get_payee_empty_string_as_default()
    {
        $formatConverter = new FormatConverter();
        $string = '';
        $this->assertEquals('', $formatConverter->getPayee($string));
    }

    /**
     * @test
     */
    public function it_should_get_reference()
    {
        $formatConverter = new FormatConverter();
        $string = "EVERITT ARCHITECTS    GREEN GABLES JKA   BBP";
        $this->assertEquals('GREEN GABLES JKA', $formatConverter->getReference($string));

        $string = "WYCHAVON DC NNDR      01     500280599   DDR";
        $this->assertEquals('01   500280599', $formatConverter->getReference($string));

        $string = "COTSWOLDTRANSPORT     INV1724            BBP";
        $this->assertEquals('INV1724', $formatConverter->getReference($string));

        $string = "REEDS RAINS EVESHA    201093800          BBP";
        $this->assertEquals('201093800', $formatConverter->getReference($string));
    }

    /**
     * @test
     */
    public function it_should_get_reference_empty_string_as_default()
    {
        $formatConverter = new FormatConverter();
        $string = '';
        $this->assertEquals('', $formatConverter->getPayee($string));
    }

    /**
     * @test
     */
    public function it_should_be_true_if_is_a_header()
    {
        $formatConverter = new FormatConverter();
        $lineArray = ['Number', 'Date', 'Account', 'Amount', 'Subcategory', 'Memo'];
        $this->assertEquals(true, $formatConverter->isHeader($lineArray));
    }

    /**
     * @test
     */
    public function it_should_be_false_if_is_a_header()
    {
        $formatConverter = new FormatConverter();
        $lineArray = ['null', '28/12/2017', '44-44-44 4444444', '50.00', 'FT', 'Example'];
        $this->assertEquals(false, $formatConverter->isHeader($lineArray));
    }
}
