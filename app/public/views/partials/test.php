<?php
require_once __DIR__ . '../../../../vendor/autoload.php';


use Dompdf\Dompdf;
use Dompdf\Options;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

// === Paths
$svgPath = __DIR__ . '/../../../public/assets/orders/tickets/qrcode.svg';
$pdfPath = __DIR__ . '/../../../public/assets/orders/tickets/festival_qr.pdf';
$imgSrc = 'file://' . realpath($svgPath);

// === Generate QR SVG File ===
try {
    $renderer = new ImageRenderer(
        new RendererStyle(200),
        new SvgImageBackEnd()
    );
    $writer = new Writer($renderer);
    $qrSvg = $writer->writeString('https://haarlemfestival.local');

    file_put_contents($svgPath, $qrSvg);
    echo "✅ QR SVG saved<br>";
} catch (Exception $e) {
    echo "❌ QR Error: " . $e->getMessage();
    exit;
}

// === Generate PDF with <img> ===
try {
    // Instantiate and configure Dompdf
    $dompdf = new Dompdf();

    // Read the raw SVG file content
    $svgContent = file_get_contents($imgSrc);

    // Encode as data URI so Dompdf can embed it
    $svgDataURI = 'data:image/svg+xml;base64,' . base64_encode($svgContent);

    // Build the HTML that Dompdf will convert
    $html = "
    <h1>Haarlem Festival Ticket</h1>
    <p>Scan the QR code below:</p>
    <img src=\"$svgDataURI\" width=\"200\" height=\"200\" />
    ";

    // Load the HTML, set paper size/orientation, and render
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    file_put_contents($pdfPath, $dompdf->output());
    echo "✅ PDF created at: $pdfPath<br>";
} catch (Exception $e) {
    echo "❌ PDF Error: " . $e->getMessage();
}