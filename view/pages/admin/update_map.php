<?php
require_once('../../../controller/AdminController.php');
$title = 'Update';
if (isset($_GET['PatientID'])) {
    $PatientID = $_GET['PatientID'];
}else{
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Incident Reports</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        #map { height: 500px; width: 88%; margin: 10px}
    </style>
</head>
<body>
    <h1>Incident Reports</h1>
    <div id="map"></div>

    <script>
        // Initialize the map
        var map = L.map('map').setView([10.948713, 123.336492], 12);

        // Load OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Define custom icons for different case counts
        var blueIcon = L.icon({
            iconUrl: '../../../assets/images/blue_marker.png', // Your blue icon URL
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        var yellowIcon = L.icon({
            iconUrl: '../../../assets/images/yellow_marker.png', // Your yellow icon URL
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        var redIcon = L.icon({
            iconUrl: '../../../assets/images/red_marker.png', // Your red icon URL
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        // Fetch GPS locations from the database
        fetch('incident_cases_json.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(location => {
                    var lat = parseFloat(location.latitude);
                    var lng = parseFloat(location.longitude);
                    var locID = location.locationID_fk;
                    var cases = parseInt(location.location_count);

                    // Select the appropriate icon based on case count
                    var icon;
                    if (cases === 1) {
                        icon = blueIcon;
                    } else if (cases === 2) {
                        icon = yellowIcon;
                    } else if (cases >= 3) {
                        icon = redIcon;
                    }

                    // Add marker with popup
                    L.marker([lat, lng], { icon: icon }).addTo(map)
                        .bindPopup(`<div>
                            <strong>Incident Cases:</strong> ${cases}<br>
                            <a class="btn btn-info w-100 text-white" href="update.php?PatientID=<?php echo $PatientID ?>&locID=${locID}&lat=${lat}&long=${lng}")">Select this Location</a>
                        </div>`);
                });
            })
            .catch(error => {
                console.error('Error fetching GPS data:', error);
            });

        // Function to handle confirming a location and redirecting to create.php
        function confirmLocation(lat, lng) {
            // Redirect to create.php with latitude and longitude as URL parameters
            window.location.href = `update.php?PatientID=<?php echo $PatientID ?>&lat=${lat}&long=${lng}`;
        }


        // Add click event listener to the map
        map.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(8);
            var lng = e.latlng.lng.toFixed(8);

            // Popup content for confirming the location
            var popupContent = `
                <div>
                    <p>Don't have Case Here!</p>
                    <button class="btn btn-warning w-100" onclick="confirmLocation(${lat}, ${lng})">Select this Location</button>
                </div>
            `;

            L.popup()
                .setLatLng(e.latlng)
                .setContent(popupContent)
                .openOn(map);
        });
    </script>
</body>
</html>
