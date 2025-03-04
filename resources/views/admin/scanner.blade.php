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
            background: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            display: none;
        }

        #newScan {
            display: none;
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

    @if (session('success'))
        <p>
            {{ session('success') }}
        </p>
    @endif

    @if (session('error'))
        <p>
            {{ session('error') }}
        </p>
    @endif


    <div id="reader"></div> <!-- QR Code Scanner Container -->
    <p id="result"></p>
    <button id="newScan" onclick="startNewScan()">🔄 New Scan</button>

    <script>
        let html5QrcodeScanner;

        function onScanSuccess(qrCodeMessage) {
            try {
                console.log("Raw Scanned Data:", qrCodeMessage); // Debugging Log

                // ✅ Decode Base64 First
                let decodedData = atob(qrCodeMessage.trim());
                console.log("Decoded QR Code Data:", decodedData); // Debugging Log

                // ✅ Convert JSON to Object
                let qrData = JSON.parse(decodedData);

                // ✅ Extract Meeting ID & URL
                let meetingId = qrData["Meeting ID"];
                let meetingUrl = qrData["URL"];

                // ✅ Display Scan Result
                document.getElementById('result').innerHTML = `✅ Scanned Successfully!<br>📌 Meeting ID: ${meetingId}`;
                document.getElementById('result').style.display = "block";
                document.getElementById('newScan').style.display = "block";

                // Stop scanning
                html5QrcodeScanner.clear();
                document.getElementById('reader').style.display = "none";

                // ✅ Redirect to Meeting URL After 3 Seconds
                setTimeout(() => {
                    window.location.href = meetingUrl;
                }, 3000);

            } catch (error) {
                console.error("Invalid QR Code or Decoding Error:", error);
                document.getElementById('result').innerHTML = "⚠️ Invalid QR Code!";
                document.getElementById('result').style.display = "block";
            }
        }

        function onScanError(errorMessage) {
            console.error("QR Scan Error:", errorMessage);
        }

        function startNewScan() {
            document.getElementById('result').style.display = "none";
            document.getElementById('newScan').style.display = "none";
            document.getElementById('reader').style.display = "block";

            // Restart the scanner
            html5QrcodeScanner = new Html5QrcodeScanner("reader", {
                fps: 10,
                qrbox: 250
            });
            html5QrcodeScanner.render(onScanSuccess, onScanError);
        }

        // Ensure camera access before starting scanner
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(function() {
                startNewScan(); // Start the scanner on page load
            })
            .catch(function(error) {
                console.error("Camera Access Denied:", error);
                document.getElementById('result').innerHTML =
                    "🚫 Camera access denied. Please enable camera permissions.";
                document.getElementById('result').style.display = "block";
            });
    </script>

</body>

</html>
