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
    // Generate the QR code as an SVG string in memory.
    $renderer = new ImageRenderer(
        new RendererStyle(200),   // Set size to 200x200 pixels (adjust as needed)
        new SvgImageBackEnd()       // Use the SVG backend
    );
    $writer = new Writer($renderer);
    
    // Replace 'Your QR Code Content Here' with the data you want encoded.
    $svgQrCode = $writer->writeString('Your QR Code Content Here');
    
    // Convert the SVG to a Base64 data URI for embedding.
    $svgDataURI = 'data:image/svg+xml;base64,' . base64_encode($svgQrCode);
    
    // Build the HTML for Dompdf. The QR code is inserted via the data URI.
    $html = "
        <h1>Haarlem Festival Ticket</h1>
        <p>Scan the QR code below:</p>
        <img src=\"$svgDataURI\" width=\"200\" height=\"200\" />
    ";
    
    // Create and configure the PDF.
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    file_put_contents($pdfPath, $dompdf->output());
    
    echo "✅ PDF created at: $pdfPath<br>";
} catch (Exception $e) {
    echo "❌ PDF Error: " . $e->getMessage();
}