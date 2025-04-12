<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>QR Code Scanner Test</title>
    <!-- Include the html5-qrcode library from a CDN -->
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <style>
      body {
        font-family: Arial, sans-serif;
        text-align: center;
        padding: 20px;
      }
      #qr-reader {
        width: 300px;
        margin: 0 auto;
      }
      #result {
        font-size: 20px;
        margin-top: 20px;
        color: #333;
      }
    </style>
  </head>
  <body>
    <h1>QR Code Scanner Test</h1>
    <div id="qr-reader"></div>
    <div id="result">Waiting for scan...</div>

    <script>
      // Called when a QR code is successfully scanned.
      function onScanSuccess(decodedText, decodedResult) {
        try {
          // Our QR code content is expected to be a base64 encoded string in the format: ticketId|signature
          var decoded = atob(decodedText);
          var parts = decoded.split("|");
          if(parts.length < 2) {
            throw new Error("Invalid QR content format.");
          }
          var ticketId = parts[0];

          // Stop scanning to prevent duplicate reads.
          html5QrcodeScanner.clear();

          // Display the extracted ticket ID.
          document.getElementById("result").innerText = "Ticket ID: " + ticketId;
        } catch(e) {
          console.error("Failed to decode QR code", e);
          document.getElementById("result").innerText = "Error decoding QR code.";
        }
      }
      
      // Optionally log scan failures (or ignore them).
      function onScanFailure(error) {
          // Uncomment this line to see scan errors in the console:
          // console.warn(`QR code scan error: ${error}`);
      }
      
      // Configure and start the scanner.
      var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 10, qrbox: 250 }, false);
      html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
  </body>
</html>