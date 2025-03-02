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
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

    <h2 style="text-align:center;">📷 Scan Your QR Code</h2>
    <div id="reader"></div> <!-- QR Code Scanner Container -->
    <p id="result"></p>

    <script>
        function onScanSuccess(qrCodeMessage) {
            document.getElementById('result').innerHTML = "✅ Scanned Successfully! Sending Data...";

            // ✅ Send QR Code Data to Backend for Attendance Update
            fetch('https://ccc.in/demo/pms/public/admin/scanner-update', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ qr_code_data: qrCodeMessage })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('result').innerHTML = "✅ " + data.message;
                } else {
                    document.getElementById('result').innerHTML = "❌ " + data.message;
                }
            })
            .catch(error => {
                console.error("Error:", error);
                document.getElementById('result').innerHTML = "❌ Failed to process QR Code.";
            });
        }

        function onScanError(errorMessage) {
            console.error("QR Scan Error:", errorMessage);
            document.getElementById('result').innerHTML = "⚠️ Error: " + errorMessage;
        }

        // 🔹 Fix: Ensure camera access
        navigator.mediaDevices.getUserMedia({ video: true })
        .then(function() {
            let html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
            html5QrcodeScanner.render(onScanSuccess, onScanError);
        })
        .catch(function(error) {
            console.error("Camera Access Denied:", error);
            document.getElementById('result').innerHTML = "🚫 Camera access denied. Please enable camera permissions.";
        });
    </script>

</body>
</html>
