<?php
/**
 * Created by PhpStorm.
 * User: carl
 * Date: 16/01/19
 * Time: 10:46
 */

namespace App\Model;


class FormatConverter
{
    /**
     * @param array $dataArray
     * @return array
     */
    public function format(array $dataArray)
    {
        $formattedArray = [
            ['*Date', '*Amount', 'Payee', 'Description', 'Reference', 'Cheque Number']
        ];
        foreach ($dataArray as $key => $lineArray) {
            if ($this->isHeader($lineArray)) {
                continue;
            }

            $description = $this->getDescription($lineArray[5]);
            $payee = $this->getPayee($lineArray[5]);
            $reference = $this->getReference($lineArray[5]);


            $formattedArray[] = [
                $lineArray[1], $lineArray[3], $payee, $description, $reference, ''
            ];
        }
        return $formattedArray;
    }

    public function getDescription($string)
    {
        $parts = explode('   ', $string);
        if (!isset($parts[2])) {
            return '';
        }

        if (isset($parts[0]) && $parts[0] === '********************** COMMISSION FOR') {
            return 'COMMISSION FOR';
        }

        return trim(array_pop($parts));
    }

    public function getPayee($string)
    {
        $parts = explode('    ', $string);
        if (!isset($parts[0])) {
            return '';
        }

        if (isset($parts[0]) && $parts[0] === '********************** COMMISSION FOR') {
            return '**********************';
        }

        return trim($parts[0]);
    }

    public function getReference($string)
    {
        $parts = explode('   ', $string);
        if (!isset($parts[1])) {
            return '';
        }

        if (count($parts) >= 4) {
            $string = '';
            $newarray = array_slice($parts, 1, -1);
            foreach ($newarray as $bit) {
                $string .= $bit. ' ';
            }
            return trim($string);
        } else {
            return trim($parts[1]);
        }
    }

    public function isHeader($lineArray)
    {
        if (count($lineArray) === 6) {
            if ($lineArray[1] === 'Date') {
                return true;
            }
            if ($lineArray[3] === 'Amount') {
                return true;
            }
            if ($lineArray[5] === 'Memo') {
                return true;
            }
        }
        return false;
    }
}
