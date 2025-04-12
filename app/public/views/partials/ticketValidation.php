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

    <script src="https://unpkg.com/jsqr/dist/jsQR.js"></script>
    <script src="../../assets/js/ticket.js"></script>
  </body>
</html>
