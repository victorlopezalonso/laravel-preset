<?php

namespace App\Classes;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory as Reader;
use PhpOffice\PhpSpreadsheet\IOFactory as Writer;
use PhpOffice\PhpSpreadsheet\Worksheet\RowIterator;

/**
 * Class Excel.
 */
class Excel
{
    /** @var bool Loops through existing cells */
    const iterateOnlyInExistingCells = true;

    /** @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet */
    private $xls;

    /** @var array Excel headers */
    private $keys;

    /** @var array Excel rows */
    private $rows;

    /** @var RowIterator */
    private $rowIterator;

    /**
     * Excel constructor.
     *
     * @param string $file
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function __construct(string $file)
    {
        $reader = Reader::createReaderForFile($file);

        $this->xls = $reader->load($file)->getActiveSheet();

        $this->setKeys();

        $this->setRows();
    }

    /**
     * Create an Excel file and return a public asset.
     *
     * @param string $fileName
     * @param array  $headers
     * @param array  $rows
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     * @return string
     */
    public static function createFile(string $fileName, array $headers, array $rows)
    {
        $filePath = storage_path()."/app/public/${fileName}";

        /** Create a new Spreadsheet Object */
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->fromArray(array_merge([$headers], $rows));

        $writer = Writer::createWriter($spreadsheet, 'Xlsx');
        $writer->save($filePath);

        return asset('storage/'.$fileName);
    }

    /**
     * Return the rows array.
     *
     * @return array
     */
    public function rows()
    {
        return $this->rows;
    }

    /**
     * Set the keys using the first row of the file.
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function setKeys()
    {
        //Set rows iterator
        $this->rowIterator = $this->xls->getRowIterator();

        //Cell iterator
        $cellIterator = $this->rowIterator->current()->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(self::iterateOnlyInExistingCells);

        //Create keys using headers
        foreach ($cellIterator as $cell) {
            $this->keys[$cell->getColumn()] = $cell->getValue();
        }
    }

    /**
     * Create an array of objects using headers as keys and colums as values.
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    private function setRows()
    {
        $this->rows = [];

        //Next iteration to avoid using headers as values
        $this->rowIterator->resetStart(2);

        foreach ($this->rowIterator as $row) {
            $object = new \stdClass();

            //Cell iterator
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(self::iterateOnlyInExistingCells);

            //Relate each cell with its key
            foreach ($cellIterator as $cell) {
                if ($key = $this->keys[$cell->getColumn()] ?? null) {
                    $value = $cell->getValue() ?? '';

                    $object->{$key} = $value;
                }
            }

            //Each cell as object
            $this->rows[] = $object;
        }
    }
}
