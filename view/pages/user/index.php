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
        #map { height: 500px; width: 100%; }
    </style>
</head>
<body>
    <h1>Incident Reports</h1>
    <div id="map"></div>

    <script>
        // Set map to your location or a default view
        var map = L.map('map').setView([10.948713, 123.336492], 14); // Default map location

        // Load and display OpenStreetMap tiles
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

        // Fetch GPS locations from the database via AJAX
        fetch('../admin/incident_location.php')
            .then(response => response.json())
            .then(data => {
                // Loop through the data and add custom markers to the map
                data.forEach(location => {
                    var lat = parseFloat(location.latitude);
                    var lng = parseFloat(location.longitude);
                    var cases = parseInt(location.location_count);

                    // Choose the appropriate icon based on the number of cases
                    var icon;
                    if (cases === 1) {
                        icon = blueIcon;
                    } else if (cases === 2) {
                        icon = yellowIcon;
                    } else if (cases >= 3) {
                        icon = redIcon;
                    }

                    // Add a custom marker
                    var marker = L.marker([lat, lng], { icon: icon }).addTo(map);

                    // Customize popup with a button
                    var popupContent = `
                        <div>
                            <strong>Incident Cases:</strong> ${cases}<br>
                            <button class="btn btn-primary" onclick="handleButtonClick(${lat}, ${lng})">Click Me</button>
                        </div>
                    `;

                    marker.bindPopup(popupContent);
                });
            })
            .catch(error => {
                console.error('Error fetching GPS data:', error);
            });

        // Function to handle button click event
        function handleButtonClick(lat, lng) {
            alert('Button clicked at location: ' + lat + ', ' + lng);
            // You can add further actions here, such as opening a modal or redirecting to another page
        }

    </script>
</body>
</html>
