<?php
/**
 * Created by PhpStorm.
 * User: carl
 * Date: 16/01/19
 * Time: 10:45
 */

namespace App\Model;

class FileHandler
{
    public function getCsvFilesAsArray($pathToCSVs) : array
    {
        $files = $this->getFiles($pathToCSVs);
        return $this->readFilesToArray($files, $pathToCSVs);
    }

    /**
     * @param $pathToCSVs
     * @return array
     */
    private function getFiles($pathToCSVs): array
    {
        $files = [];
        if ($handle = opendir($pathToCSVs)) {

            while (false !== ($entry = readdir($handle))) {

                if ($entry !== '.' && $entry !== '..') {

                    $files[] = $entry;
                }
            }
            closedir($handle);
        }
        return $files;
    }

    private function readFilesToArray(array $files, $pathToCSVs) : array
    {
        $data = [];
        foreach ($files as $fileName) {
            if ($fileName === 'file.csv') {
                continue;
            }
            $file = fopen($pathToCSVs. DIRECTORY_SEPARATOR . $fileName, 'rb');
            while (($getData = fgetcsv($file, 10000, ',')) !== FALSE) {
                $data[] = $getData;
            }
        }
        return $data;
    }

    public function saveCsv(array $formattedDataArray, $pathToSave)
    {
        if (file_exists($pathToSave. DIRECTORY_SEPARATOR . 'file.csv')) {
            unlink($pathToSave. DIRECTORY_SEPARATOR . 'file.csv');
        }
        $fp = fopen($pathToSave. DIRECTORY_SEPARATOR . 'file.csv', 'wb');

        foreach ($formattedDataArray as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        return $pathToSave. DIRECTORY_SEPARATOR . 'file.csv';
    }
}
