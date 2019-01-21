<?php
/**
 * Created by PhpStorm.
 * User: carl
 * Date: 16/01/19
 * Time: 10:53
 */

namespace App\Model;


class ConverterService
{
    /**
     * @var FileHandler
     */
    private $fileHandler;
    /**
     * @var FormatConverter
     */
    private $formatConverter;

    public function __construct(FileHandler $fileHandler, FormatConverter $formatConverter)
    {
        $this->fileHandler = $fileHandler;
        $this->formatConverter = $formatConverter;
    }

    public function ConvertCsvs($pathToCSVs, $pathToSave)
    {
        $dataArray= $this->fileHandler->getCsvFilesAsArray($pathToCSVs);
        $formattedDataArray = $this->formatConverter->format($dataArray);
        return $this->fileHandler->saveCsv($formattedDataArray, $pathToSave);
    }
}
