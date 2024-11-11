<?php


// THIS PART USE IF YOU WANT TO UPDATE THE LOCATION OF THE INCIDENT
require_once('../../../controller/AdminController.php');
$title = 'Update';
if (isset($_GET['IncidentID'])) {
    $incidentID = $_GET['IncidentID'];
}else{
    header("Location: map.php");
    exit();
}
?>
<?php require_once('../../components/header.php')?>
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
                            <a class="btn btn-info w-100 text-white" href="update.php?IncidentID=<?php echo $incidentID ?>&locID=${locID}&lat=${lat}&long=${lng}")">Select this Location</a>
                        </div>`);
                });
            })
            .catch(error => {
                console.error('Error fetching GPS data:', error);
            });

        // Function to handle confirming a location and redirecting to create.php
        function confirmLocation(lat, lng) {
            // Redirect to create.php with latitude and longitude as URL parameters
            window.location.href = `update.php?IncidentID=<?php echo $incidentID ?>&lat=${lat}&long=${lng}`;
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

        fetch('sagay_city_geojson.php')
        .then(response => response.json())
        .then(geoData => {
            // Define a style for the GeoJSON layer
            const geoJsonStyle = {
                color: 'blue', // Outline color
                fillColor: 'lightblue', // Fill color
                fillOpacity: 0.2, // Fill opacity (0.0 to 1.0)
                weight: 2 // Outline weight
            };

            // Add the GeoJSON layer to the map with the specified style
            L.geoJSON(geoData, { style: geoJsonStyle }).addTo(map);
        })
        .catch(error => {
            console.error('Error fetching GeoJSON data:', error);
        });
    </script>
<?php require_once('../../components/footer.php')?>
