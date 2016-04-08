<?php

namespace Inteleon\Pdf;

use FPDF;

/**
 * @author Daniel Nilsson <daniel@smspark.se>
 *
 * This class is heavily based on
 *
 * FPDF_EXTENDED
 * @link https://github.com/hanneskod/fpdf/blob/master/src/fpdf/FPDF/EXTENDED.php
 * @link https://packagist.org/packages/itbz/fpdf
 *
 *
 */
class Pdf extends FPDF
{
    /**
     *
     * Current count of pages.
     *
     * @var int $nrOfPages
     *
     */
    protected $nrOfPages = 0;

    /**
     *
     * Path to search for images in.
     *
     * @var string $imagePath
     *
     */
    protected $imagePath = "";

    /**
     *
     * Keep track of added fonts.
     *
     * @var array $addedFonts
     *
     */
    protected $addedFonts = array();

    /**
     * Rotation angle
     *
     * @var integer
     */
    protected $angle;

    /**
     *
     * Set standard margin, orientation, units used and paper size
     *
     * @param int $margin Marginsize in user units.
     *
     * @param char $orientation Default page orientation. 'P' for portrait or
     * 'L' for landscape
     *
     * @param string $unit User units. 'pt' for points, 'mm' for millimeters,
     * 'cm' for centimetera or 'in' for inches
     *
     * @param string|array $format The size used for pages. 'A3', 'A4', 'A5',
     * 'Letter' or 'Legal'. May also be an array of height and width specified
     * in user units.
     *
     */
    public function __construct(
        $margin = 20,
        $orientation = 'P',
        $unit = 'mm',
        $format = 'A4'
    ) {
        if (defined('FPDF_FONTPATH') == false) {
            define('FPDF_FONTPATH', __DIR__.'/fonts');
        }
        parent::__construct($orientation, $unit, $format);
        $this->AliasNbPages('{{{nb}}}');
        $this->SetMargins($margin, $margin);
        $this->SetAutoPageBreak(true, $margin);
        $this->AddFont('Tahoma', '', 'tahoma.php');
        $this->AddFont('Tahoma', 'B', 'tahomabd.php');
        $this->AddFont('OCRB', '', 'ocrb10.php');
        $this->SetMargins(12, 12, 12);
        $this->SetAutoPageBreak(true, 0);
        $this->angle = 0;
    }

    // FPDF_EXTENDED HELPER METHODS START HERE
    // @codingStandardsIgnoreStart
    // We want to ignore FPDF default function name in our coding standard
    // for backwardscompability

    /**
     *
     * Adds a new page to the document.
     *
     * Extends FPDF by keeping track of number of pages added.
     *
     * @param string $orientation Page orientation. 'P' for portrait or 'L' for
     * landscape. The default value is the one passed to the constructor.
     *
     * @param string $format The size used for pages. 'A3', 'A4', 'A5',
     * 'Letter' or 'Legal'. May also be an array of height and width specified
     * in user units. The default value is the one passed to the constructor.
     *
     * @param  string $rotation
     *
     * @return void
     *
     */
    public function AddPage($orientation = '', $format = '', $rotation = 0)
    {
        $this->nrOfPages++;
        parent::AddPage($orientation, $format, $rotation);
    }

    /**
     *
     * Get the current number of pages added with AddPage().
     *
     * Note that this number will increase as you add more pages. Should not be
     * used to print the total number of pages in document. For this use
     * TotalPagesNo().
     *
     * @return int Number of pages currently in document
     *
     */
    public function PagesAdded()
    {
        return $this->nrOfPages;
    }

    /**
     *
     * Shorthand to get total number of pages in pdf
     *
     * @return string Returns a string that will be replaced with the total
     * number of pages when pdf is rendered
     *
     */
    public function TotalPagesNo()
    {
        return $this->AliasNbPages;
    }

    /**
     *
     * Shorthand to get current page/total pages.
     *
     * @param string $delim Delimiter used between current and page number and
     * total pages number.
     *
     * @return string Returns a string that will be replaced with current page
     * number, then delimiter, then the total number of pages.
     *
     */
    public function PaginationStr($delim = '/')
    {
        return $this->PageNo() . $delim . $this->TotalPagesNo();
    }

    /**
     *
     * Increase the abscissa of the current position.
     *
     * @param int $x
     *
     * @return void
     *
     */
    public function moveX($x)
    {
        $posX = $this->GetX();
        $posX += $x;
        $this->SetX($posX);
    }

    /**
     *
     * Increase the ordinate of the current position.
     *
     * @param int $y
     *
     * @return void
     *
     */
    public function moveY($y)
    {
        $posX = $this->GetX();
        $posY = $this->GetY();
        $posY += $y;
        $this->SetXY($posX, $posY);
    }

    /**
     *
     * Wrapper to solve utf-8 issues.
     *
     * @param string $title
     *
     * @param bool $isUTF8 Defaults to TRUE.
     *
     * @return void
     *
     */
    public function SetTitle($title, $isUTF8 = true)
    {
        parent::SetTitle($title, $isUTF8);
    }

    /**
     *
     * Wrapper to solve utf-8 issues.
     *
     * @param string $subject
     *
     * @param bool $isUTF8 Defaults to TRUE.
     *
     * @return void
     *
     */
    public function SetSubject($subject, $isUTF8 = true)
    {
        parent::SetSubject($subject, $isUTF8);
    }

    /**
     *
     * Wrapper to solve utf-8 issues.
     *
     * @param string $author
     *
     * @param bool $isUTF8 Defaults to TRUE.
     *
     * @return void
     *
     */
    public function SetAuthor($author, $isUTF8 = true)
    {
        parent::SetAuthor($author, $isUTF8);
    }

    /**
     *
     * Wrapper to solve utf-8 issues.
     *
     * @param string $keywords
     *
     * @param bool $isUTF8 Defaults to TRUE.
     *
     * @return void
     *
     */
    public function SetKeywords($keywords, $isUTF8 = true)
    {
        parent::SetKeywords($keywords, $isUTF8);
    }

    /**
     *
     * Wrapper to solve utf-8 issues.
     *
     * @param string $creator
     *
     * @param bool $isUTF8 Defaults to TRUE.
     *
     * @return void
     *
     */
    public function SetCreator($creator, $isUTF8 = true)
    {
        parent::SetCreator($creator, $isUTF8);
    }

    /**
     *
     * Print text in cell. Solves utf-8 issues.
     *
     * Prints a cell (rectangular area) with optional borders, background color
     * and character string. The upper-left corner of the cell corresponds to
     * the current position. The text can be aligned or centered. After the
     * call, the current position moves to the right or to the next line. It is
     * possible to put a link on the text.
     *
     * If automatic page breaking is enabled (witch is it by default) and the
     * cell goes beyond the limit, a page break is done before outputting.
     *
     * @param int $width Cell width. If 0, the cell extends up to the right
     * margin.
     *
     * @param int $height Cell height. Default value: 0.
     *
     * @param string $txt String to print. Default value: empty string.
     *
     * @param string|int $border Indicates if borders must be drawn around the
     * cell. The value can be either a number: 0 for no border, 1 for a frame.
     * Or a string containing some or all of the following characters (in any
     * order): 'L' for left, 'T' for top, 'R' for right or 'B' for bottom.
     *
     * @param int $ln Indicates where the current position should go after the
     * call. Possible values are: 0 - to the rigth, 1 - to the beginning of the
     * next line or 2 - below.
     *
     * @param char $align Allows to center or align the tex. 'L', 'C' or 'R'.
     *
     * @param bool $fill Indicates if the cell background must be painted (TRUE)
     * or transparent (FALSE). Default value: FALSE.
     *
     * @param string|identifier $link URL or identifier returned by AddLink().
     *
     * @return void
     *
     */
    public function Cell(
        $width,
        $height = 0,
        $txt = '',
        $border = 0,
        $ln = 0,
        $align = '',
        $fill = false,
        $link = ''
    ) {
        $txt = utf8_decode($txt);
        parent::Cell($width, $height, $txt, $border, $ln, $align, $fill, $link);
    }

    /**
     *
     * Prints a character string. Solves utf-8 issues.
     *
     * The origin is on the left of the first character, on the baseline. This
     * method allows to place a string precisely on the page, but it is usually
     * easier to use Cell(), MultiCell() or Write() which are the standard
     * methods to print text.
     *
     * @param int $x Abscissa of the origin.
     *
     * @param int $y Ordinate of the origin.
     *
     * @param string $txt String to print.
     *
     * @return void
     *
     */
    public function Text($x, $y, $txt)
    {
        $txt = utf8_decode($txt);
        parent::Text($x, $y, $txt);
    }

    /**
     *
     * Print text from the current position.
     *
     * Fix positioning errors when using non-english characters (eg. åäö).
     *
     * When the right margin is reached (or the \n character is met) a line
     * break occurs and text continues from the left margin. Upon method exit,
     * the current position is left just at the end of the text. 
     *
     * @param string $lineHeight Line height.
     *
     * @param string $txt String to print.
     *
     * @param string|identifier $link URL or identifier returned by AddLink().
     *
     * @return void
     *
     * @todo Fix positioning hack..
     *
     */
    public function Write($lineHeight, $txt, $link = '')
    {
        parent::Write($lineHeight, $txt, $link);
        // Uggly hack to help fix positions
        $specChars = preg_replace("/[^åäöÅÄÖ]/", '', $txt);
        $specChars = strlen($specChars)*1.75;
        if ($specChars) {
            $this->moveX($specChars*-1);
        }
    }

    /**
     * Write to position
     *
     * @param  string $x
     * @param  string $y
     * @param  string $line
     * @param  string $txt 
     * @param  string|identifier $link URL or identifier returned by AddLink().
     * @return void
     */
    public function WriteXY($x, $y, $line, $txt, $link = '')
    {
        $this->SetXY($x, $y);
        $this->Write($line, $txt, $link);
    }

    /**
     *
     * Set image path. Enables image() to understand relative paths.
     *
     * @param string $path
     *
     * @return void
     *
     */
    public function setImagePath($path)
    {
        $this->imagePath = realpath($path);
    }

    /**
     * Get image path.
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Get added fonts
     *
     * @return array
     */
    public function getAddedFonts()
    {
        return $this->addedFonts;
    }

    /**
     *
     * Output an image.
     *
     * @param string $file Path or URL of the image. May be relative to
     * path set using setImagePath()
     *
     * @param int $x Abscissa of the upper-left corner. If not specified or
     * equal to NULL, the current abscissa is used.
     *
     * @param int $y Ordinate of the upper-left corner. If not specified or
     * equal to NULL, the current ordinate is used; moreover, a page break is
     * triggered first if necessary (in case automatic page breaking is enabled)
     * and, after the call, the current ordinate is moved to the bottom of the
     * image.
     *
     * @param int $width Width of the image in the page.
     *
     * @param int $height Height of the image in the page. 
     *
     * @param string $type JPG|JPEG|PNG|GIF
     *
     * @param string|identifier $link URL or identifier returned by AddLink().
     *
     * @return void
     *
     */
    public function Image(
        $file,
        $x = NULL,
        $y = NULL,
        $width = 0,
        $height = 0,
        $type = '',
        $link = ''
    ) {
        $absolute = $this->imagePath . DIRECTORY_SEPARATOR . $file;
        if (!is_readable($file) && is_readable($absolute)) {
            $file = $absolute;
        }
        parent::Image($file, $x, $y, $width, $height, $type, $link);
    }
    /**
     *
     * Import a TrueType or Type1 font and make it available.
     *
     * @param string $family
     *
     * @param string $style 'B', 'I' or 'IB'
     *
     * @param string $file The font definition file. By default, the name is
     * built from the family and style, in lower case with no space.
     *
     * @return void
     *
     */
    public function AddFont($family, $style = '', $file = '')
    {
        parent::AddFont($family, $style, $file);
        if (!isset($this->addedFonts[$family])) {
            $this->addedFonts[$family] = array();
        }
        $this->addedFonts[$family][] = $style;
    }

    /**
     *
     * Sets the font used to print character strings.
     *
     * @param string $family Family font. It can be either a name defined by
     * AddFont() or one of the standard families (case insensitive): Courier,
     * Helvetica or Arial, Times, Symbol or ZapfDingbats.
     *
     * @param string $style 'B', 'I', 'U' or any combination.
     *
     * @param int $size Font size in points. The default value is the current
     * size. If no size has been specified since the beginning of the document,
     * the value taken is 12.
     *
     * @return void
     *
     */
    public function SetFont($family, $style = '', $size = 0)
    {
        $style = strtoupper($style);
        
        // U is not handled by AddFont(), hence needs special treatment
        $addU = '';
        if (strpos($style, 'U') !== FALSE) {
            $addU = 'U';
            $style = str_replace('U', '', $style);
        }
        
        if (isset($this->addedFonts[$family])) {
            if (!in_array($style, $this->addedFonts[$family]) ) {
                // Requested style is missing
                if (in_array('', $this->addedFonts[$family])) {
                    // Using no style
                    $style = '';
                } else {
                    // Use first added style
                    $style = $this->addedFonts[$family][0];
                }
            }
        }
        $style = $style.$addU;
        parent::SetFont($family, $style, $size);
    }

    /**
     *
     * Send the document to a given destination
     *
     * @param string $name The name of the file. If not specified, the document
     * will be sent to the browser (destination I) with the name doc.pdf.
     *
     * @param char $dest Destination where to send the document. It can take one
     * of the following values: 'I' - send the file inline to the browser.
     * 'D' - send to the browser and force a file download with the name given
     * by name. 'F' - save to a local file with the name given by name (may
     * include a path). 'S' - return the document as a string. name is ignored.
     *
     * @param bool $isUTF8
     *
     * @return string
     *
     */
    public function Output($dest = '', $name = '', $isUTF8 = true)
    {
        $this->draw();
        return parent::Output($name, $dest, $isUTF8);
    }

    /**
     *
     * Shorthand for direct string output
     *
     * @return string Raw PDF
     *
     */
    public function GetPdf()
    {
        return $this->Output('', 'S');
    }

    /**
     *
     * Perform actions just before Output
     *
     * @return void
     *
     */
    protected function draw()
    {
    }
    // End of FPDF_EXTENDED helpermethods
    // @codingStandardsIgnoreEnd


    /**
     * create a rounded Rectangle.
     *
     * @param int    $x
     * @param int    $y
     * @param int    $w
     * @param int    $h
     * @param int    $r
     * @param string $corners
     * @param string $style
     */
    public function roundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F') {
            $op = 'f';
        } elseif ($style == 'FD' || $style == 'DF') {
            $op = 'B';
        } else {
            $op = 'S';
        }
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));

        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));
        if (strpos($corners, '2') === false) {
            $this->out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $y) * $k));
        } else {
            $this->arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
        }

        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        if (strpos($corners, '3') === false) {
            $this->out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - ($y + $h)) * $k));
        } else {
            $this->arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
        }

        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        if (strpos($corners, '4') === false) {
            $this->out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - ($y + $h)) * $k));
        } else {
            $this->arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
        }

        $xc = $x + $r;
        $yc = $y + $r;
        $this->out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
        if (strpos($corners, '1') === false) {
            $this->out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $y) * $k));
            $this->out(sprintf('%.2F %.2F l', ($x + $r) * $k, ($hp - $y) * $k));
        } else {
            $this->arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        }
        $this->out($op);
    }

    /**
     * Create an Arc.
     *
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $y2
     * @param int $x3
     * @param int $y3
     */
    public function arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->out(
            sprintf(
                '%.2F %.2F %.2F %.2F %.2F %.2F c ',
                $x1 * $this->k,
                ($h - $y1) * $this->k,
                $x2 * $this->k,
                ($h - $y2) * $this->k,
                $x3 * $this->k,
                ($h - $y3) * $this->k
            )
        );
    }

    /**
     * create a circle.
     *
     * @param int    $x
     * @param int    $y
     * @param int    $r
     * @param string $style
     */
    public function circle($x, $y, $r, $style = 'D')
    {
        $this->Ellipse($x, $y, $r, $r, $style);
    }

    /**
     * Create an elipse.
     *
     * @param int    $x
     * @param int    $y
     * @param int    $rx
     * @param int    $ry
     * @param string $style
     */
    public function ellipse($x, $y, $rx, $ry, $style = 'D')
    {
        if ($style == 'F') {
            $op = 'f';
        } elseif ($style == 'FD' || $style == 'DF') {
            $op = 'B';
        } else {
            $op = 'S';
        }
        $lx = 4 / 3 * (M_SQRT2 - 1) * $rx;
        $ly = 4 / 3 * (M_SQRT2 - 1) * $ry;
        $k = $this->k;
        $h = $this->h;
        $this->out(
            sprintf(
                '%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c',
                ($x + $rx) * $k,
                ($h - $y) * $k,
                ($x + $rx) * $k,
                ($h - ($y - $ly)) * $k,
                ($x + $lx) * $k,
                ($h - ($y - $ry)) * $k,
                $x * $k,
                ($h - ($y - $ry)) * $k
            )
        );

        $this->out(
            sprintf(
                '%.2F %.2F %.2F %.2F %.2F %.2F c',
                ($x - $lx) * $k,
                ($h - ($y - $ry)) * $k,
                ($x - $rx) * $k,
                ($h - ($y - $ly)) * $k,
                ($x - $rx) * $k,
                ($h - $y) * $k
            )
        );

        $this->out(
            sprintf(
                '%.2F %.2F %.2F %.2F %.2F %.2F c',
                ($x - $rx) * $k,
                ($h - ($y + $ly)) * $k,
                ($x - $lx) * $k,
                ($h - ($y + $ry)) * $k,
                $x * $k,
                ($h - ($y + $ry)) * $k
            )
        );

        $this->out(
            sprintf(
                '%.2F %.2F %.2F %.2F %.2F %.2F c %s',
                ($x + $lx) * $k,
                ($h - ($y + $ry)) * $k,
                ($x + $rx) * $k,
                ($h - ($y + $ly)) * $k,
                ($x + $rx) * $k,
                ($h - $y) * $k,
                $op
            )
        );
    }

    public function polygon($points, $style = 'D')
    {
        //Draw a polygon
        if ($style == 'F') {
            $op = 'f';
        } elseif ($style == 'FD' || $style == 'DF') {
            $op = 'b';
        } else {
            $op = 's';
        }

        $h = $this->h;
        $k = $this->k;

        $points_string = '';
        for ($i = 0; $i < count($points); $i += 2) {
            $points_string .= sprintf('%.2F %.2F', $points[$i] * $k, ($h - $points[$i + 1]) * $k);
            if ($i == 0) {
                $points_string .= ' m ';
            } else {
                $points_string .= ' l ';
            }
        }
        $this->out($points_string.$op);
    }

    /**
     *  Barcode.
     *
     * @param int   $x
     * @param int   $y
     * @param int   $val
     * @param float $w
     * @param int   $h
     */
    public function printCode128($x, $y, $val, $w = 0.5, $h = 10)
    {
        $d = 0;
        $string = '';

        $T128[] = array(2, 1, 2, 2, 2, 2);           //0 : [ ]
        $T128[] = array(2, 2, 2, 1, 2, 2);           //1 : [!]
        $T128[] = array(2, 2, 2, 2, 2, 1);           //2 : ["]
        $T128[] = array(1, 2, 1, 2, 2, 3);           //3 : [#]
        $T128[] = array(1, 2, 1, 3, 2, 2);           //4 : [$]
        $T128[] = array(1, 3, 1, 2, 2, 2);           //5 : [%]
        $T128[] = array(1, 2, 2, 2, 1, 3);           //6 : [&]
        $T128[] = array(1, 2, 2, 3, 1, 2);           //7 : [']
        $T128[] = array(1, 3, 2, 2, 1, 2);           //8 : [(]
        $T128[] = array(2, 2, 1, 2, 1, 3);           //9 : [)]
        $T128[] = array(2, 2, 1, 3, 1, 2);           //10 : [*]
        $T128[] = array(2, 3, 1, 2, 1, 2);           //11 : [+]
        $T128[] = array(1, 1, 2, 2, 3, 2);           //12 : [,]
        $T128[] = array(1, 2, 2, 1, 3, 2);           //13 : [-]
        $T128[] = array(1, 2, 2, 2, 3, 1);           //14 : [.]
        $T128[] = array(1, 1, 3, 2, 2, 2);           //15 : [/]
        $T128[] = array(1, 2, 3, 1, 2, 2);           //16 : [0]
        $T128[] = array(1, 2, 3, 2, 2, 1);           //17 : [1]
        $T128[] = array(2, 2, 3, 2, 1, 1);           //18 : [2]
        $T128[] = array(2, 2, 1, 1, 3, 2);           //19 : [3]
        $T128[] = array(2, 2, 1, 2, 3, 1);           //20 : [4]
        $T128[] = array(2, 1, 3, 2, 1, 2);           //21 : [5]
        $T128[] = array(2, 2, 3, 1, 1, 2);           //22 : [6]
        $T128[] = array(3, 1, 2, 1, 3, 1);           //23 : [7]
        $T128[] = array(3, 1, 1, 2, 2, 2);           //24 : [8]
        $T128[] = array(3, 2, 1, 1, 2, 2);           //25 : [9]
        $T128[] = array(3, 2, 1, 2, 2, 1);           //26 : [:]
        $T128[] = array(3, 1, 2, 2, 1, 2);           //27 : [;]
        $T128[] = array(3, 2, 2, 1, 1, 2);           //28 : [<]
        $T128[] = array(3, 2, 2, 2, 1, 1);           //29 : [=]
        $T128[] = array(2, 1, 2, 1, 2, 3);           //30 : [>]
        $T128[] = array(2, 1, 2, 3, 2, 1);           //31 : [?]
        $T128[] = array(2, 3, 2, 1, 2, 1);           //32 : [@]
        $T128[] = array(1, 1, 1, 3, 2, 3);           //33 : [A]
        $T128[] = array(1, 3, 1, 1, 2, 3);           //34 : [B]
        $T128[] = array(1, 3, 1, 3, 2, 1);           //35 : [C]
        $T128[] = array(1, 1, 2, 3, 1, 3);           //36 : [D]
        $T128[] = array(1, 3, 2, 1, 1, 3);           //37 : [E]
        $T128[] = array(1, 3, 2, 3, 1, 1);           //38 : [F]
        $T128[] = array(2, 1, 1, 3, 1, 3);           //39 : [G]
        $T128[] = array(2, 3, 1, 1, 1, 3);           //40 : [H]
        $T128[] = array(2, 3, 1, 3, 1, 1);           //41 : [I]
        $T128[] = array(1, 1, 2, 1, 3, 3);           //42 : [J]
        $T128[] = array(1, 1, 2, 3, 3, 1);           //43 : [K]
        $T128[] = array(1, 3, 2, 1, 3, 1);           //44 : [L]
        $T128[] = array(1, 1, 3, 1, 2, 3);           //45 : [M]
        $T128[] = array(1, 1, 3, 3, 2, 1);           //46 : [N]
        $T128[] = array(1, 3, 3, 1, 2, 1);           //47 : [O]
        $T128[] = array(3, 1, 3, 1, 2, 1);           //48 : [P]
        $T128[] = array(2, 1, 1, 3, 3, 1);           //49 : [Q]
        $T128[] = array(2, 3, 1, 1, 3, 1);           //50 : [R]
        $T128[] = array(2, 1, 3, 1, 1, 3);           //51 : [S]
        $T128[] = array(2, 1, 3, 3, 1, 1);           //52 : [T]
        $T128[] = array(2, 1, 3, 1, 3, 1);           //53 : [U]
        $T128[] = array(3, 1, 1, 1, 2, 3);           //54 : [V]
        $T128[] = array(3, 1, 1, 3, 2, 1);           //55 : [W]
        $T128[] = array(3, 3, 1, 1, 2, 1);           //56 : [X]
        $T128[] = array(3, 1, 2, 1, 1, 3);           //57 : [Y]
        $T128[] = array(3, 1, 2, 3, 1, 1);           //58 : [Z]
        $T128[] = array(3, 3, 2, 1, 1, 1);           //59 : [[]
        $T128[] = array(3, 1, 4, 1, 1, 1);           //60 : [\]
        $T128[] = array(2, 2, 1, 4, 1, 1);           //61 : []]
        $T128[] = array(4, 3, 1, 1, 1, 1);           //62 : [^]
        $T128[] = array(1, 1, 1, 2, 2, 4);           //63 : [_]
        $T128[] = array(1, 1, 1, 4, 2, 2);           //64 : [`]
        $T128[] = array(1, 2, 1, 1, 2, 4);           //65 : [a]
        $T128[] = array(1, 2, 1, 4, 2, 1);           //66 : [b]
        $T128[] = array(1, 4, 1, 1, 2, 2);           //67 : [c]
        $T128[] = array(1, 4, 1, 2, 2, 1);           //68 : [d]
        $T128[] = array(1, 1, 2, 2, 1, 4);           //69 : [e]
        $T128[] = array(1, 1, 2, 4, 1, 2);           //70 : [f]
        $T128[] = array(1, 2, 2, 1, 1, 4);           //71 : [g]
        $T128[] = array(1, 2, 2, 4, 1, 1);           //72 : [h]
        $T128[] = array(1, 4, 2, 1, 1, 2);           //73 : [i]
        $T128[] = array(1, 4, 2, 2, 1, 1);           //74 : [j]
        $T128[] = array(2, 4, 1, 2, 1, 1);           //75 : [k]
        $T128[] = array(2, 2, 1, 1, 1, 4);           //76 : [l]
        $T128[] = array(4, 1, 3, 1, 1, 1);           //77 : [m]
        $T128[] = array(2, 4, 1, 1, 1, 2);           //78 : [n]
        $T128[] = array(1, 3, 4, 1, 1, 1);           //79 : [o]
        $T128[] = array(1, 1, 1, 2, 4, 2);           //80 : [p]
        $T128[] = array(1, 2, 1, 1, 4, 2);           //81 : [q]
        $T128[] = array(1, 2, 1, 2, 4, 1);           //82 : [r]
        $T128[] = array(1, 1, 4, 2, 1, 2);           //83 : [s]
        $T128[] = array(1, 2, 4, 1, 1, 2);           //84 : [t]
        $T128[] = array(1, 2, 4, 2, 1, 1);           //85 : [u]
        $T128[] = array(4, 1, 1, 2, 1, 2);           //86 : [v]
        $T128[] = array(4, 2, 1, 1, 1, 2);           //87 : [w]
        $T128[] = array(4, 2, 1, 2, 1, 1);           //88 : [x]
        $T128[] = array(2, 1, 2, 1, 4, 1);           //89 : [y]
        $T128[] = array(2, 1, 4, 1, 2, 1);           //90 : [z]
        $T128[] = array(4, 1, 2, 1, 2, 1);           //91 : [{]
        $T128[] = array(1, 1, 1, 1, 4, 3);           //92 : [|]
        $T128[] = array(1, 1, 1, 3, 4, 1);           //93 : [}]
        $T128[] = array(1, 3, 1, 1, 4, 1);           //94 : [~]
        $T128[] = array(1, 1, 4, 1, 1, 3);           //95 : [DEL]
        $T128[] = array(1, 1, 4, 3, 1, 1);           //96 : [FNC3]
        $T128[] = array(4, 1, 1, 1, 1, 3);           //97 : [FNC2]
        $T128[] = array(4, 1, 1, 3, 1, 1);           //98 : [SHIFT]
        $T128[] = array(1, 1, 3, 1, 4, 1);           //99 : [Cswap]
        $T128[] = array(1, 1, 4, 1, 3, 1);           //100 : [Bswap]
        $T128[] = array(3, 1, 1, 1, 4, 1);           //101 : [Aswap]
        $T128[] = array(4, 1, 1, 1, 3, 1);           //102 : [FNC1]
        $T128[] = array(2, 1, 1, 4, 1, 2);           //103 : [Astart]
        $T128[] = array(2, 1, 1, 2, 1, 4);           //104 : [Bstart]
        $T128[] = array(2, 1, 1, 2, 3, 2);           //105 : [Cstart]
        $T128[] = array(2, 3, 3, 1, 1, 1,2);           //106 : [STOP]

        $string .= chr(208); //[Astart]
        $string .= $val;    //Värdet
        $string .= chr($this->c128ToChr($this->getCode128CheckNum($val))); //Kontrollsiffra
        $string .= chr(211); // [STOP]
        $j = 0;
        for ($i = 0; $i < strlen($string); $i++) {
            foreach ($T128[$this->chrToC128(ord(substr($string, $i, 1)))] as $bw) {
                if ($j % 2 === 0) {
                    //horizontell
                    $this->rect(($x + ($w * $d)), $y, $w * $bw, $h, 'F');
                    //vertikal
                    //$this->Rect($x2,$y2+($w2*$d2),$h2,$w2*$bw2,'F');
                }

                $d += $bw;
                $j++;
            }
        }
    }

    /**
     * check character.
     *
     * @param int $chr
     *
     * @return int
     */
    public function chrToC128($chr)
    {
        if ($chr >= 200) {
            $val = $chr - 105;
        } else {
            $val = $chr - 32;
        }

        return $val;
    }

    /**
     * @param int $val
     *
     * @return int
     */
    public function c128ToChr($val)
    {
        if ($val < 95) {
            $chr = $val + 32;
        } else {
            $chr = $val + 105;
        }

        return $chr;
    }

    /**
     * helper method get Code 128.
     *
     * @param string $val
     *
     * @return int
     */
    public function getCode128CheckNum($val)
    {
        $sum = 103;
        for ($i = 0; $i < strlen($val); $i++) {
            $sum += ($i + 1) * $this->ChrToC128(ord(substr($val, $i, 1)));
        }

        $ch_num = $sum % 103;

        return $ch_num;
    }

    /**
     * alias method for FPDF _out.
     *
     * @param string $s
     */
    private function out($s)
    {
        parent::_out($s);
    }

    /**
     *  Rotate object
     *  based on:
     *
     * @link http://www.fpdf.org/en/script/script2.php
     *
     * @param int    $angle degrees
     * @param int    $x     x position
     * @param int    $y     y position
     */
    public function rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1) {
            $x = $this->x;
        }
        if ($y == -1) {
            $y = $this->y;
        }
        if ($this->angle!=0) {
            $this->_out('Q');
        }
        $this->angle = $angle;
        if ($angle != 0) {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf(
                'q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',
                $c,
                $s,
                -$s,
                $c,
                $cx,
                $cy,
                -$cx,
                -$cy
            ));
        }
    }

    /**
     * Get angle
     *
     * @return int
     */
    public function getAngle()
    {
        return $this->angle;
    }

    /**
     * Override default _endpage
     * @link http://www.fpdf.org/en/script/script2.php
     *
     * @return void
     */
    public function _endpage()
    {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    /**
     * Rotate text
     * @link http://www.fpdf.org/en/script/script2.php
     *
     * @param  int $x
     * @param  int $y
     * @param  string $txt
     * @param  int $angle
     *
     * @return void
     */
    public function rotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->rotate(0);
    }
}
