<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ticket Validation Scanner</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
      padding-top: 20px;
    }
    #scannerContainer {
      display: none;
    }
    #video {
      width: 100%;
      max-width: 400px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      margin: 0 auto;
      display: block;
    }
    #canvas {
      display: none;
    }
  </style>
</head>
<body>
  <div class="container text-center">
    <h1 class="mb-4">Ticket Validation Scanner</h1>
    
    <div id="startSection" class="mb-4">
      <button id="startBtn" class="btn btn-primary">Start Scanning</button>
    </div>
    
    <div id="scannerContainer" class="mb-3">
      <video id="video" autoplay playsinline></video>
      <canvas id="canvas"></canvas>
    </div>
    
    <div id="result" class="alert alert-info text-center">
      Waiting to start scanning...
    </div>
    
    <div id="nextSection" class="mt-3" style="display: none;">
      <button id="nextBtn" class="btn btn-secondary">Scan Next Ticket</button>
    </div>
  </div>

  <!-- Include jsQR Library -->
  <script src="https://unpkg.com/jsqr/dist/jsQR.js"></script>
  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    let scanning = false;
    const video = document.getElementById('video');
    const canvasElement = document.getElementById('canvas');
    const canvas = canvasElement.getContext('2d');
    const resultDiv = document.getElementById('result');
    const startBtn = document.getElementById('startBtn');
    const nextBtn = document.getElementById('nextBtn');
    const scannerContainer = document.getElementById('scannerContainer');
    const startSection = document.getElementById('startSection');
    const nextSection = document.getElementById('nextSection');

    startBtn.addEventListener('click', startScanning);
    nextBtn.addEventListener('click', resetScanning);

    function startScanning() {
      // Hide the start section, show the scanner, and update message.
      startSection.style.display = "none";
      scannerContainer.style.display = "block";
      resultDiv.innerText = "Scanning...";
      resultDiv.className = "alert alert-info text-center";

      navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
        .then(function(stream) {
          video.srcObject = stream;
          video.play();
          scanning = true;
          requestAnimationFrame(tick);
        })
        .catch(function(err) {
          console.error("Error accessing camera: " + err);
          resultDiv.innerText = "Error accessing camera.";
          resultDiv.className = "alert alert-danger text-center";
        });
    }

    function tick() {
      if (!scanning) return;
      if (video.readyState === video.HAVE_ENOUGH_DATA) {
        // Set canvas dimensions to match video.
        canvasElement.width = video.videoWidth;
        canvasElement.height = video.videoHeight;
        canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
        const imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
        const code = jsQR(imageData.data, imageData.width, imageData.height, { inversionAttempts: "dontInvert" });
        if (code) {
          console.log("Scanned raw data:", code.data);
          try {
            // Expect QR code content in base64: "ticketId|signature"
            const decoded = atob(code.data);
            const parts = decoded.split("|");
            if(parts.length !== 2) {
              throw new Error("Invalid QR code format.");
            }
            const ticketId = parts[0];
            // Stop scanning for this ticket.
            scanning = false;
            // Send AJAX call to validate ticket.
            fetch('/validate/ticket', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ qrContent: code.data })
            })
            .then(response => response.json())
            .then(data => {
              if(data.success) {
                resultDiv.innerHTML = "<strong>Ticket Validated!</strong><br>Ticket ID: " + ticketId;
                resultDiv.className = "alert alert-success text-center";
              } else {
                resultDiv.innerHTML = "<strong>Ticket Invalid!</strong><br>" + data.message;
                resultDiv.className = "alert alert-danger text-center";
              }
              nextSection.style.display = "block";
            })
            .catch(err => {
              console.error("AJAX error:", err);
              resultDiv.innerHTML = "<strong>AJAX error during validation!</strong>";
              resultDiv.className = "alert alert-danger text-center";
              nextSection.style.display = "block";
            });
            return; // Stop processing further frames.
          } catch(e) {
            console.error("Error decoding QR code:", e);
            resultDiv.innerHTML = "<strong>Error decoding QR code!</strong>";
            resultDiv.className = "alert alert-danger text-center";
          }
        } else {
          resultDiv.innerText = "Scanning...";
          resultDiv.className = "alert alert-info text-center";
        }
      }
      requestAnimationFrame(tick);
    }

    function resetScanning() {
      // Reset alert message.
      resultDiv.innerText = "Scanning...";
      resultDiv.className = "alert alert-info text-center";
      // Hide the next button.
      nextSection.style.display = "none";
      // Resume scanning.
      scanning = true;
      requestAnimationFrame(tick);
    }
  </script>
</body>
</html>
