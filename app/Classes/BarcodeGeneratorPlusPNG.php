<?php

namespace App\Classes;

use Picqer\Barcode\BarcodeGenerator;
use Picqer\Barcode\Exceptions\BarcodeException;
use Picqer\Barcode\Exceptions\InvalidCharacterException;
use Picqer\Barcode\Exceptions\UnknownTypeException;

class BarcodeGeneratorPlusPNG extends BarcodeGenerator{

    public function getBarcode($code, $type, $widthFactor = 2, $totalHeight = 30, $color = array(0, 0, 0))
    {
        $barcodeData = $this->getBarcodeData($code, $type);

        // calculate image size
        $width = ($barcodeData['maxWidth'] * $widthFactor);
        $height = $totalHeight;

        if (function_exists('imagecreate')) {
            // GD library
            $imagick = false;
            $png = imagecreate($width, $height);
            $colorBackground = imagecolorallocate($png, 255, 255, 255);
            imagecolortransparent($png, $colorBackground);
            $colorForeground = imagecolorallocate($png, $color[0], $color[1], $color[2]);
        } elseif (extension_loaded('imagick')) {
            $imagick = true;
            $colorForeground = new \imagickpixel('rgb(' . $color[0] . ',' . $color[1] . ',' . $color[2] . ')');
            $png = new \Imagick();
            $png->newImage($width, $height, 'none', 'png');
            $imageMagickObject = new \imagickdraw();
            $imageMagickObject->setFillColor($colorForeground);
        } else {
            throw new BarcodeException('Neither gd-lib or imagick are installed!');
        }

        // print bars
        $positionHorizontal = 0;
        foreach ($barcodeData['bars'] as $bar) {
            $bw = round(($bar['width'] * $widthFactor), 3);
            $bh = round(($bar['height'] * $totalHeight / $barcodeData['maxHeight']), 3);
            if ($bar['drawBar']) {
                $y = round(($bar['positionVertical'] * $totalHeight / $barcodeData['maxHeight']), 3);
                // draw a vertical bar
                if ($imagick && isset($imageMagickObject)) {
                    $imageMagickObject->rectangle($positionHorizontal, $y, ($positionHorizontal + $bw), ($y + $bh));
                } else {
                    imagefilledrectangle($png, $positionHorizontal, $y, ($positionHorizontal + $bw) - 1, ($y + $bh),
                        $colorForeground);
                }
            }
            $positionHorizontal += $bw;
        }
        ob_start();
        if ($imagick && isset($imageMagickObject)) {
            $png->drawImage($imageMagickObject);
            echo $png;
        } else {
            imagepng($png);
            imagedestroy($png);
        }
        $image = ob_get_clean();

        return $image;
    }

    protected function getBarcodeData($code, $type): array
    {
        switch (strtoupper($type)) {
            case self::TYPE_CODE_39: { // CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
                $arrcode = $this->barcode_code39($code, false, false);
                break;
            }
            case self::TYPE_CODE_39_CHECKSUM: { // CODE 39 with checksum
                $arrcode = $this->barcode_code39($code, false, true);
                break;
            }
            case self::TYPE_CODE_39E: { // CODE 39 EXTENDED
                $arrcode = $this->barcode_code39($code, true, false);
                break;
            }
            case self::TYPE_CODE_39E_CHECKSUM: { // CODE 39 EXTENDED + CHECKSUM
                $arrcode = $this->barcode_code39($code, true, true);
                break;
            }
            case self::TYPE_CODE_93: { // CODE 93 - USS-93
                $arrcode = $this->barcode_code93($code);
                break;
            }
            case self::TYPE_STANDARD_2_5: { // Standard 2 of 5
                $arrcode = $this->barcode_s25($code, false);
                break;
            }
            case self::TYPE_STANDARD_2_5_CHECKSUM: { // Standard 2 of 5 + CHECKSUM
                $arrcode = $this->barcode_s25($code, true);
                break;
            }
            case self::TYPE_INTERLEAVED_2_5: { // Interleaved 2 of 5
                $arrcode = $this->barcode_i25($code, false);
                break;
            }
            case self::TYPE_INTERLEAVED_2_5_CHECKSUM: { // Interleaved 2 of 5 + CHECKSUM
                $arrcode = $this->barcode_i25($code, true);
                break;
            }
            case self::TYPE_CODE_128: { // CODE 128
                $arrcode = $this->barcode_c128($code, '');
                break;
            }
            case self::TYPE_CODE_128_A: { // CODE 128 A
                $arrcode = $this->barcode_c128($code, 'A');
                break;
            }
            case self::TYPE_CODE_128_B: { // CODE 128 B
                $arrcode = $this->barcode_c128($code, 'B');
                break;
            }
            case self::TYPE_CODE_128_C: { // CODE 128 C
                $arrcode = $this->barcode_c128($code, 'C');
                break;
            }
            case self::TYPE_EAN_2: { // 2-Digits UPC-Based Extention
                $arrcode = $this->barcode_eanext($code, 2);
                break;
            }
            case self::TYPE_EAN_5: { // 5-Digits UPC-Based Extention
                $arrcode = $this->barcode_eanext($code, 5);
                break;
            }
            case self::TYPE_EAN_8: { // EAN 8
                $arrcode = $this->barcode_eanupc($code, 8);
                break;
            }
            case self::TYPE_EAN_13: { // EAN 13
                $arrcode = $this->barcode_eanupc($code, 13);
                break;
            }
            case self::TYPE_UPC_A: { // UPC-A
                $arrcode = $this->barcode_eanupc($code, 12);
                break;
            }
            case self::TYPE_UPC_E: { // UPC-E
                $arrcode = $this->barcode_eanupc($code, 6);
                break;
            }
            case self::TYPE_MSI: { // MSI (Variation of Plessey code)
                $arrcode = $this->barcode_msi($code, false);
                break;
            }
            case self::TYPE_MSI_CHECKSUM: { // MSI + CHECKSUM (modulo 11)
                $arrcode = $this->barcode_msi($code, true);
                break;
            }
            case self::TYPE_POSTNET: { // POSTNET
                $arrcode = $this->barcode_postnet($code, false);
                break;
            }
            case self::TYPE_PLANET: { // PLANET
                $arrcode = $this->barcode_postnet($code, true);
                break;
            }
            case self::TYPE_RMS4CC: { // RMS4CC (Royal Mail 4-state Customer Code) - CBC (Customer Bar Code)
                $arrcode = $this->barcode_rms4cc($code, false);
                break;
            }
            case self::TYPE_KIX: { // KIX (Klant index - Customer index)
                $arrcode = $this->barcode_rms4cc($code, true);
                break;
            }
            case self::TYPE_IMB: { // IMB - Intelligent Mail Barcode - Onecode - USPS-B-3200
                $arrcode = $this->barcode_imb($code);
                break;
            }
            case self::TYPE_CODABAR: { // CODABAR
                $arrcode = $this->barcode_codabar($code);
                break;
            }
            case self::TYPE_CODE_11: { // CODE 11
                $arrcode = $this->barcode_code11($code);
                break;
            }
            case self::TYPE_PHARMA_CODE: { // PHARMACODE
                $arrcode = $this->barcode_pharmacode($code);
                break;
            }
            case self::TYPE_PHARMA_CODE_TWO_TRACKS: { // PHARMACODE TWO-TRACKS
                $arrcode = $this->barcode_pharmacode2t($code);
                break;
            }
            default: {
                throw new UnknownTypeException();
                break;
            }
        }

        if ( ! isset($arrcode['maxWidth'])) {
            $arrcode = $this->convertBarcodeArrayToNewStyle($arrcode);
        }

        return $arrcode;
    }


    protected function barcode_code39($code, $extended = false, $checksum = false): array
    {
        $chr = [];
        $chr['0'] = '111331311';
        $chr['1'] = '311311113';
        $chr['2'] = '113311113';
        $chr['3'] = '313311111';
        $chr['4'] = '111331113';
        $chr['5'] = '311331111';
        $chr['6'] = '113331111';
        $chr['7'] = '111311313';
        $chr['8'] = '311311311';
        $chr['9'] = '113311311';
        $chr['A'] = '311113113';
        $chr['B'] = '113113113';
        $chr['C'] = '313113111';
        $chr['D'] = '111133113';
        $chr['E'] = '311133111';
        $chr['F'] = '113133111';
        $chr['G'] = '111113313';
        $chr['H'] = '311113311';
        $chr['I'] = '113113311';
        $chr['J'] = '111133311';
        $chr['K'] = '311111133';
        $chr['L'] = '113111133';
        $chr['M'] = '313111131';
        $chr['N'] = '111131133';
        $chr['O'] = '311131131';
        $chr['P'] = '113131131';
        $chr['Q'] = '111111333';
        $chr['R'] = '311111331';
        $chr['S'] = '113111331';
        $chr['T'] = '111131331';
        $chr['U'] = '331111113';
        $chr['V'] = '133111113';
        $chr['W'] = '333111111';
        $chr['X'] = '131131113';
        $chr['Y'] = '331131111';
        $chr['Z'] = '133131111';
        $chr['-'] = '131111313';
        $chr['.'] = '331111311';
        $chr[' '] = '133111311';
        $chr['$'] = '131313111';
        $chr['/'] = '131311131';
        $chr['+'] = '131113131';
        $chr['%'] = '111313131';
        $chr['*'] = '131131311';

        $code = strtoupper($code);

        if ($extended) {
            // extended mode
            $code = $this->encode_code39_ext($code);
        }

        if ($checksum) {
            // checksum
            $code .= $this->checksum_code39($code);
        }

        // add start and stop codes
        $code = '*' . $code . '*';

        $bararray = array('code' => $code, 'maxw' => 0, 'maxh' => 1, 'bcode' => array());
        $k = 0;
        $clen = strlen($code);
        for ($i = 0; $i < $clen; ++$i) {
            $char = $code[$i];
            if ( ! isset($chr[$char])) {
                throw new InvalidCharacterException('Char ' . $char . ' is unsupported');
            }
            for ($j = 0; $j < 9; ++$j) {
                if (($j % 2) == 0) {
                    $t = true; // bar
                } else {
                    $t = false; // space
                }
                $w = $chr[$char][$j];
                $bararray['bcode'][$k] = array('t' => $t, 'w' => $w, 'h' => 1, 'p' => 0);
                $bararray['maxw'] += $w;
                ++$k;
            }
            // intercharacter gap
            $bararray['bcode'][$k] = array('t' => false, 'w' => 1, 'h' => 1, 'p' => 0);
            $bararray['maxw'] += 1;
            ++$k;
        }

        return $bararray;
    }

    protected function encode_code39_ext($code): string
    {
        $encode = array(
            chr(0)   => '%U',
            chr(1)   => '$A',
            chr(2)   => '$B',
            chr(3)   => '$C',
            chr(4)   => '$D',
            chr(5)   => '$E',
            chr(6)   => '$F',
            chr(7)   => '$G',
            chr(8)   => '$H',
            chr(9)   => '$I',
            chr(10)  => '$J',
            chr(11)  => '£K',
            chr(12)  => '$L',
            chr(13)  => '$M',
            chr(14)  => '$N',
            chr(15)  => '$O',
            chr(16)  => '$P',
            chr(17)  => '$Q',
            chr(18)  => '$R',
            chr(19)  => '$S',
            chr(20)  => '$T',
            chr(21)  => '$U',
            chr(22)  => '$V',
            chr(23)  => '$W',
            chr(24)  => '$X',
            chr(25)  => '$Y',
            chr(26)  => '$Z',
            chr(27)  => '%A',
            chr(28)  => '%B',
            chr(29)  => '%C',
            chr(30)  => '%D',
            chr(31)  => '%E',
            chr(32)  => ' ',
            chr(33)  => '/A',
            chr(34)  => '/B',
            chr(35)  => '/C',
            chr(36)  => '/D',
            chr(37)  => '/E',
            chr(38)  => '/F',
            chr(39)  => '/G',
            chr(40)  => '/H',
            chr(41)  => '/I',
            chr(42)  => '/J',
            chr(43)  => '/K',
            chr(44)  => '/L',
            chr(45)  => '-',
            chr(46)  => '.',
            chr(47)  => '/O',
            chr(48)  => '0',
            chr(49)  => '1',
            chr(50)  => '2',
            chr(51)  => '3',
            chr(52)  => '4',
            chr(53)  => '5',
            chr(54)  => '6',
            chr(55)  => '7',
            chr(56)  => '8',
            chr(57)  => '9',
            chr(58)  => '/Z',
            chr(59)  => '%F',
            chr(60)  => '%G',
            chr(61)  => '%H',
            chr(62)  => '%I',
            chr(63)  => '%J',
            chr(64)  => '%V',
            chr(65)  => 'A',
            chr(66)  => 'B',
            chr(67)  => 'C',
            chr(68)  => 'D',
            chr(69)  => 'E',
            chr(70)  => 'F',
            chr(71)  => 'G',
            chr(72)  => 'H',
            chr(73)  => 'I',
            chr(74)  => 'J',
            chr(75)  => 'K',
            chr(76)  => 'L',
            chr(77)  => 'M',
            chr(78)  => 'N',
            chr(79)  => 'O',
            chr(80)  => 'P',
            chr(81)  => 'Q',
            chr(82)  => 'R',
            chr(83)  => 'S',
            chr(84)  => 'T',
            chr(85)  => 'U',
            chr(86)  => 'V',
            chr(87)  => 'W',
            chr(88)  => 'X',
            chr(89)  => 'Y',
            chr(90)  => 'Z',
            chr(91)  => '%K',
            chr(92)  => '%L',
            chr(93)  => '%M',
            chr(94)  => '%N',
            chr(95)  => '%O',
            chr(96)  => '%W',
            chr(97)  => '+A',
            chr(98)  => '+B',
            chr(99)  => '+C',
            chr(100) => '+D',
            chr(101) => '+E',
            chr(102) => '+F',
            chr(103) => '+G',
            chr(104) => '+H',
            chr(105) => '+I',
            chr(106) => '+J',
            chr(107) => '+K',
            chr(108) => '+L',
            chr(109) => '+M',
            chr(110) => '+N',
            chr(111) => '+O',
            chr(112) => '+P',
            chr(113) => '+Q',
            chr(114) => '+R',
            chr(115) => '+S',
            chr(116) => '+T',
            chr(117) => '+U',
            chr(118) => '+V',
            chr(119) => '+W',
            chr(120) => '+X',
            chr(121) => '+Y',
            chr(122) => '+Z',
            chr(123) => '%P',
            chr(124) => '%Q',
            chr(125) => '%R',
            chr(126) => '%S',
            chr(127) => '%T'
        );
        $code_ext = '';
        $clen = strlen($code);
        for ($i = 0; $i < $clen; ++$i) {
            if (ord($code[$i]) > 127) {
                throw new InvalidCharacterException('Only supports till char 127');
            }
            $code_ext .= $encode[$code[$i]];
        }

        return $code_ext;

    }

    protected function checksum_code39($code): string
    {
        $chars = array(
            '0',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'U',
            'V',
            'W',
            'X',
            'Y',
            'Z',
            '-',
            '.',
            ' ',
            '$',
            '/',
            '+',
            '%'
        );
        $sum = 0;
        $codelength = strlen($code);
        for ($i = 0; $i < $codelength; ++$i) {
            $k = array_keys($chars, $code[$i]);
            $sum += $k[0];
        }
        $j = ($sum % 43);

        return $chars[$j];
    }



}