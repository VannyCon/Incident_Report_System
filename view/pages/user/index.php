<?php
$title = "User";
require_once('../../components/header.php')?>
    <div class="my-3">

        <h3 class="ms-2"><strong>Incident Map</strong></h3>
            <div id="map"></div>
            <div class="m-3">
                <p>Red <img src="../../../assets/images/red_marker.png" alt="" srcset="" width="20"> High Risk</p>
                <p>Yellow <img src="../../../assets/images/yellow_marker.png" alt="" srcset="" width="20"> Medium Risk</p>
                <p>Blue <img src="../../../assets/images/blue_marker.png" alt="" srcset="" width="20"> Low Risk</p>
            </div>
    </div>
   
    <script>
        // Initialize the map
        var map = L.map('map').setView([10.948713, 123.336492], 14);

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
                            <a class="btn btn-primary w-100 text-white" href="location_incident.php?locID=${locID}&lat=${lat}&long=${lng}")">Check</a>
                        </div>`);
                });
            })
            .catch(error => {
                console.error('Error fetching GPS data:', error);
            });

    </script>

<?php require_once('../../components/footer.php')?>
