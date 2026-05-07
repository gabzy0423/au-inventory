<?php

namespace App\Services;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Output\QRMarkupSVG;
use chillerlan\QRCode\Common\EccLevel;

class QrService
{
    /**
     * Generate a QR code SVG for a given text
     *
     * @param string $text
     * @return string Raw SVG markup
     */
    public function generate($text)
    {
        $options = [
            'version' => 5,
            'outputInterface' => QRMarkupSVG::class,
            'outputBase64' => false,
            'eccLevel' => EccLevel::L,
            'addQuietzone' => true,
            'drawCircularModules' => false,
        ];

        $qrcode = new QRCode($options);
        return $qrcode->render($text);
    }

    /**
     * Generate a QR code PNG (Base64) for a given text
     *
     * @param string $text
     * @return string Base64 encoded PNG
     */
    public function generatePng($text)
    {
        $options = new QROptions([
            'version'             => 5,
            'outputType'          => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'            => EccLevel::L,
            'addQuietzone'        => true,
            'imageBase64'         => true,
            'scale'               => 10, // Increase scale for higher quality
            'drawCircularModules' => false,
        ]);

        $qrcode = new QRCode($options);
        return $qrcode->render($text);
    }
}
