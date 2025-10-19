<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class QrPublicController extends Controller
{
    /**
     * EL-BAR QR Kod gösterimi (Public)
     */
    public function index()
    {
        // https://el-bar.com için QR kod oluştur
        $url = 'https://el-bar.com';
        $size = 400;

        // chillerlan/php-qrcode kullanarak QR oluştur
        $options = new QROptions([
            'version'      => 5,
            'outputType'   => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'     => QRCode::ECC_L,
            'scale'        => 10,
            'imageBase64'  => false,
        ]);

        $qrcode = new QRCode($options);
        $qrCode = base64_encode($qrcode->render($url));

        return view('public.qr.index', compact('qrCode', 'url', 'size'));
    }
}
