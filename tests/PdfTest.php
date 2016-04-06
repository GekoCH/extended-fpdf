<?php

namespace Inteleon\Pdf;

class PdfTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test based on:
     * @link https://github.com/hanneskod/fpdf/blob/master/tests/FpdfExtendedTest.php
     *
     */
    public function testPagesAdded()
    {
        $pdf = new Pdf();
        $pdf->AddPage();
        $this->assertSame(1, $pdf->PagesAdded());
        $pdf->AddPage();
        $this->assertSame(2, $pdf->PagesAdded());
    }

    /**
     * Test based on:
     * @link https://github.com/hanneskod/fpdf/blob/master/tests/FpdfExtendedTest.php
     *
     */
    public function testTotalPagesNo()
    {
        $pdf = new Pdf();
        $pdf->AliasNbPages('FOOBAR');
        $this->assertSame('FOOBAR', $pdf->TotalPagesNo());
    }

    /**
     * Test based on:
     * @link https://github.com/hanneskod/fpdf/blob/master/tests/FpdfExtendedTest.php
     *
     */
    public function testPaginationStr()
    {
        $pdf = new Pdf();
        $pdf->AliasNbPages('FOOBAR');
        $pdf->AddPage();
        $this->assertSame('1/FOOBAR', $pdf->PaginationStr());
    }

    /**
     * Test based on:
     * @link https://github.com/hanneskod/fpdf/blob/master/tests/FpdfExtendedTest.php
     *
     */
    public function testMoveX()
    {
        $pdf = new Pdf();
        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->moveX(100);
        $x += 100;
        $this->assertSame($x, $pdf->getX());
        $this->assertSame($y, $pdf->getY());
        $pdf->moveX(-50);
        $x -= 50;
        $this->assertSame($x, $pdf->getX());
        $this->assertSame($y, $pdf->getY());
    }

    /**
     * Test based on:
     * @link https://github.com/hanneskod/fpdf/blob/master/tests/FpdfExtendedTest.php
     *
     */
    public function testMoveY()
    {
        $pdf = new Pdf();
        $x = $pdf->getX();
        $y = $pdf->getY();
        $pdf->moveY(100);
        $y += 100;
        $this->assertSame($x, $pdf->getX());
        $this->assertSame($y, $pdf->getY());
        $pdf->moveY(-50);
        $y -= 50;
        $this->assertSame($x, $pdf->getX());
        $this->assertSame($y, $pdf->getY());
    }
}
