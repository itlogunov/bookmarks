<?php

use PHPUnit\Framework\TestCase;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class PhpOfficeTest extends TestCase
{
    /**
     * Проверка подключения библиотеки PhpOffice
     */
    public function testPhpOfficeLoading()
    {
        $this->assertInstanceOf('PhpOffice\PhpSpreadsheet\Spreadsheet', new Spreadsheet());
    }
}
