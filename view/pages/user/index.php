<?php
$title = "User";
require_once('../../components/header.php')?>
<div class="my-3">

    <h3 class="ms-2"><strong>Incident Map</strong></h3>
    <div id="map" style="height: 500px; margin: 5px"></div> <!-- Set a height for the map -->
    <div class="m-3">
        <p>Red <img src="../../../assets/images/red_marker.png" alt="" srcset="" width="20"> High Risk</p>
        <p>Yellow <img src="../../../assets/images/yellow_marker.png" alt="" srcset="" width="20"> Medium Risk</p>
        <p>Blue <img src="../../../assets/images/blue_marker.png" alt="" srcset="" width="20"> Low Risk</p>
        <p>Green <img src="../../../assets/images/green_marker.png" alt="" srcset="" width="20"> User Location</p> <!-- Added green marker description -->
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

    // Add a green icon for the user's location
    var greenIcon = L.icon({
        iconUrl: '../../../assets/images/green_marker.png', // Your green icon URL
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
                        <a class="btn btn-primary w-100 text-white" href="location_incident.php?locID=${locID}&lat=${lat}&long=${lng}">Check</a>
                    </div>`);
            });
        })
        .catch(error => {
            console.error('Error fetching GPS data:', error);
        });

    // Function to get user's current location
    function getUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        var userLat = position.coords.latitude;
        var userLng = position.coords.longitude;

        // Center the map on user's location
        map.setView([userLat, userLng], 14);

        // Add a marker for the user's location using the green icon
        L.marker([userLat, userLng], { icon: greenIcon }).addTo(map)
            .bindPopup("You are here!")
            .openPopup();
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert("User denied the request for Geolocation.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Location information is unavailable.");
                break;
            case error.TIMEOUT:
                alert("The request to get user location timed out.");
                break;
            case error.UNKNOWN_ERROR:
                alert("An unknown error occurred.");
                break;
        }
    }

    // Get user's location when the page loads
    window.onload = getUserLocation;
</script>

<?php require_once('../../components/footer.php')?>
