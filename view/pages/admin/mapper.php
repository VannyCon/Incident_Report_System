<!DOCTYPE html>
<html>
<head>
    <title>Leaflet Map - Get Coordinates and Confirm</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        #map { height: 500px; width: 100%; }
        #locationForm { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Click on the Map to Get Latitude and Longitude</h1>
    
    <!-- Map Container -->
    <div id="map"></div>
    <!-- Form to show the clicked latitude and longitude -->
    <div id="locationForm">
        <label>Latitude: <input type="text" id="latitude" readonly></label><br>
        <label>Longitude: <input type="text" id="longitude" readonly></label>
    </div>

    <script>
        // Set map to a default view (your location or another place)
        var map = L.map('map').setView([10.948713, 123.336492], 13);

        // Load and display OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Function to handle the confirm button click event
        function confirmLocation(lat, lng) {
            // Set the latitude and longitude values in the input fields
            document.getElementById('latitude').value = lat.toFixed(8);
            document.getElementById('longitude').value = lng.toFixed(8);
        }

        // Event listener for map clicks
        map.on('click', function(e) {
            // Get latitude and longitude from the event
            var lat = e.latlng.lat.toFixed(8);
            var lng = e.latlng.lng.toFixed(8);

            // Customize the popup with a confirm button
            var popupContent = `
                <div>
                    <strong>Latitude:</strong> ${lat}<br>
                    <strong>Longitude:</strong> ${lng}<br><br>
                    <button onclick="confirmLocation(${lat}, ${lng})">Confirm Location</button>
                </div>
            `;

            // Display the popup with the confirm button
            var popup = L.popup()
                .setLatLng(e.latlng)
                .setContent(popupContent)
                .openOn(map);
        });
    </script>
</body>
</html>
