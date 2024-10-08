<!DOCTYPE html>
<html>
<head>
    <title>Leaflet Map with Customized Button</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        #map { height: 500px; width: 100%; }
    </style>
</head>
<body>
    <h1>Leaflet Map with Customized Button in Popups</h1>
    <div id="map"></div>
    <script>
        // Set map to your location or a default view
        var map = L.map('map').setView([10.948713, 123.336492], 12); // Default map location

        // Load and display OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Fetch GPS locations from the database via AJAX
        fetch('index.php')
            .then(response => response.json())
            .then(data => {
                // Loop through the data and add markers to the map
                data.forEach(location => {
                    var lat = 10.949461773876305;  // Assuming 'lat' is a column in your 'gps_locations' table
                    var lng = 123.33953189692694;  // Assuming 'lng' is a column in your 'gps_locations' table
                    
                    var marker = L.marker([lat, lng]).addTo(map);

                    // Customize popup with a button
                    var popupContent = `
                        <div>
                            <strong>Location:</strong> ${lat}, ${lng}<br>
                            <button onclick="handleButtonClick(${lat}, ${lng})">Click Me</button>
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
