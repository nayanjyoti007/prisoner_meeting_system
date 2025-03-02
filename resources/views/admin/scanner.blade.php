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
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <h2 style="text-align: center;">📷 Scan Your QR Code</h2>
    <div id="reader"></div> <!-- QR Code Scanner Container -->
    <p id="result"></p>

    <script>
        function onScanSuccess(qrCodeMessage) {
            console.log("✅ Scanned QR Code:", qrCodeMessage); // ✅ Log scanned QR code

            document.getElementById('result').innerHTML = "⏳ Scanning Success! Sending Data...";

            // ✅ Send QR Code Data to Laravel Backend
            fetch('https://pakhiinfotech.in/demo/pms/public/admin/scanner-update', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ qr_code_data: qrCodeMessage })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP Error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log("✅ Server Response:", data); // ✅ Log server response

                if (data.success) {
                    document.getElementById('result').innerHTML = "✅ " + data.message;
                } else {
                    throw new Error(data.message || "Unknown error occurred.");
                }
            })
            .catch(error => {
                console.error("❌ Fetch Error:", error);
                document.getElementById('result').innerHTML = `❌ Error: ${error.message}`;
            });
        }

        function onScanError(errorMessage) {
            console.error("⚠️ Scan Error:", errorMessage);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner("reader", {
            fps: 10,  // Frames per second
            qrbox: { width: 300, height: 300 } // Set the QR scan area size
        });

        html5QrcodeScanner.render(onScanSuccess, onScanError);
    </script>

</body>
</html>
