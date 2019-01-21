<?php
/**
 * Created by PhpStorm.
 * User: carl
 * Date: 16/01/19
 * Time: 10:55
 */

namespace App\Model;

class ConverterServiceMaker
{
    public function getConverterService() : ConverterService
    {
        $fileHandler = new FileHandler();
        $formatConverter = new FormatConverter();
        return new ConverterService($fileHandler, $formatConverter);
    }
}
