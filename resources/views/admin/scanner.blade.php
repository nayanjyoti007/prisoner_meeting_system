<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        #reader {
            width: 100%;
            max-width: 400px;
            margin: auto;
            text-align: center;
        }
        #result {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            text-align: center;
            background: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            display: none; /* Hide initially */
            white-space: pre-line;
        }
        #newScan {
            display: none; /* Hide initially */
            margin: 10px auto;
            padding: 10px 15px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        #newScan:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h2 style="text-align:center;">📷 Scan Your QR Code</h2>
    <div id="reader"></div> <!-- QR Code Scanner Container -->
    <p id="result"></p>
    <button id="newScan" onclick="startNewScan()">🔄 New Scan</button>

    <script>
        function onScanSuccess(qrCodeMessage) {
            try {
                // ✅ Decode Base64 First
                let decodedData = atob(qrCodeMessage.trim());

                // ✅ Convert JSON to Object
                let qrData = JSON.parse(decodedData);

                // ✅ Display Data in Readable Format
                let displayText = `✅ Scanned Successfully!\n\n` +
                                  `📌 Meeting ID: ${qrData["Meeting ID"]}\n` +
                                  `👤 Visitor: ${qrData["Visitor"]}\n` +
                                  `🔒 Prisoner: ${qrData["Prisoner"]}\n` +
                                  `🏢 Jail: ${qrData["Jail"]}\n` +
                                  `📅 Date: ${qrData["Date"]}\n` +
                                  `⏰ Time: ${qrData["Time"]}\n` +
                                  `📜 Status: ${qrData["Status"]}\n\n` +
                                  `🔗 URL: <a href="${qrData["URL"]}" target="_blank">${qrData["URL"]}</a>`;

                document.getElementById('result').innerHTML = displayText;
                document.getElementById('result').style.display = "block";
                document.getElementById('newScan').style.display = "block";

                // Stop scanning
                html5QrcodeScanner.clear();
                document.getElementById('reader').style.display = "none";

            } catch (error) {
                console.error("Invalid QR Code or Decoding Error:", error);
                document.getElementById('result').innerHTML = "⚠️ Invalid QR Code!";
                document.getElementById('result').style.display = "block";
            }
        }
    </script>


</body>
</html>
