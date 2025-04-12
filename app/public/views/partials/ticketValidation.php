<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Ticket Validation Scanner</title>
    <style>
      body {
        text-align: center;
        font-family: Arial, sans-serif;
        margin-top: 20px;
      }
      video {
        width: 300px;
      }
      canvas {
        display: none;
      }
      #result {
        margin-top: 20px;
        font-size: 20px;
        font-weight: bold;
      }
    </style>
  </head>
  <body>
    <h1>Ticket Validation Scanner</h1>
    <video id="video" autoplay></video>
    <canvas id="canvas"></canvas>
    <div id="result">Waiting for scan...</div>

    <!-- Include jsQR library from CDN -->
    <script src="https://unpkg.com/jsqr/dist/jsQR.js"></script>
    <script>
      const video = document.getElementById('video');
      const canvasElement = document.getElementById('canvas');
      const canvas = canvasElement.getContext('2d');
      const resultDiv = document.getElementById('result');

      // Access the camera.
      navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
        .then(function(stream) {
          video.srcObject = stream;
          video.setAttribute("playsinline", true); // needed for iOS
          video.play();
          requestAnimationFrame(tick);
        })
        .catch(function(err) {
          console.error("Error accessing the camera: " + err);
          resultDiv.innerText = "Error accessing the camera.";
        });

      function tick() {
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
          canvasElement.width = video.videoWidth;
          canvasElement.height = video.videoHeight;
          canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
          const imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);

          const code = jsQR(imageData.data, imageData.width, imageData.height, {
            inversionAttempts: "dontInvert",
          });

          if (code) {
            console.log("Scanned raw data:", code.data);
            try {
              // Attempt to decode the QR code using atob.
              const decoded = atob(code.data);
              const parts = decoded.split("|");
              if (parts.length !== 2) {
                throw new Error("Invalid QR code format.");
              }
              const ticketId = parts[0];
              
              // Now send the scanned QR content to the back-end for validation.
              fetch('/validate/ticket', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify({ qrContent: code.data })
              })
              .then(response => response.json())
              .then(data => {
                if(data.success) {
                  resultDiv.innerText = "Ticket " + ticketId + " validated successfully.";
                } else {
                  resultDiv.innerText = "Validation failed: " + data.message;
                }
              })
              .catch(err => {
                console.error("AJAX error:", err);
                resultDiv.innerText = "AJAX error during validation.";
              });
              
              return;  // stop processing further frames
            } catch(e) {
              console.error("Error processing QR code:", e);
              resultDiv.innerText = "Error decoding QR code.";
            }
          } else {
            resultDiv.innerText = "Scanning...";
          }
        }
        requestAnimationFrame(tick);
      }
    </script>
  </body>
</html>
