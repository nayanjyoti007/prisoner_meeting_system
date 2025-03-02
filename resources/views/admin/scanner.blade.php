<script>
    let html5QrcodeScanner;

    function onScanSuccess(qrCodeMessage) {
        try {
            let qrData = JSON.parse(qrCodeMessage); // ✅ Parse JSON data
            let displayText = `✅ Scanned Successfully!\n\n`;

            // ✅ Display Data Properly
            for (let key in qrData) {
                displayText += `📌 ${key}: ${qrData[key]}\n`;
            }

            document.getElementById('result').innerHTML = displayText;
            document.getElementById('result').style.display = "block";
            document.getElementById('newScan').style.display = "block";

            // Stop scanning
            html5QrcodeScanner.clear();
            document.getElementById('reader').style.display = "none";
        } catch (error) {
            console.error("QR Parsing Error:", error);
            document.getElementById('result').innerHTML = "❌ Invalid QR Code Format!";
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
        html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    }

    // Ensure camera access before starting scanner
    navigator.mediaDevices.getUserMedia({ video: true })
    .then(function() {
        startNewScan(); // Start the scanner on page load
    })
    .catch(function(error) {
        console.error("Camera Access Denied:", error);
        document.getElementById('result').innerHTML = "🚫 Camera access denied. Please enable camera permissions.";
        document.getElementById('result').style.display = "block";
    });
</script>
