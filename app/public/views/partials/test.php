<?php
require_once __DIR__ . '../../../../vendor/autoload.php';


use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd; // or ImagickImageBackEnd if available
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

try {
    $renderer = new ImageRenderer(
        new RendererStyle(200),
        new ImagickImageBackEnd()
    );
    $writer = new Writer($renderer);
    $qr = $writer->writeString('Hello QR!');
    file_put_contents('qrcode.png', $qr);
    echo "✅ QR Code created";
} catch (Exception $e) {
    echo "❌ QR Error: " . $e->getMessage();
}
