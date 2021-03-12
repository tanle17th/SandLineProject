/**
 * This function uses goggle.maps.Map() method to display a map to the console
 * It gets the map div element in create.blade.php class to initialize the actual map
 */
function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
        // Zoom ratio and center position of initial map
      zoom: 7,
      center: { lat: 45.2497533, lng: -76.3606619 },
    });
    const geocoder = new google.maps.Geocoder();
    const infowindow = new google.maps.InfoWindow();
    // When get current location button is clicked
    // Pass (geocoder, map, infowindow) into geocodeLatLng() function
    document.getElementById("submit").addEventListener("click", () => {
      geocodeLatLng(geocoder, map, infowindow);
    });
  }

  /**
   * This function uses a different API of Google Maps to get and return latitude/longitude
   * @param {*} geocoder param to display the actual map
   * @param {*} map param to display the actual map
   * @param {*} infowindow param to display the actual map
   */
  function geocodeLatLng(geocoder, map, infowindow) {
    if (navigator.geolocation) {
        // This method (navigator.geolocation.getCurrentPosition)
        // get current position based on GPS of user
        navigator.geolocation.getCurrentPosition(
            // Save latitude/longitude to a variable (I guess this is JSON/array)
          (position) => {
            const pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude,
            };
            // Zoom in the current location, and display a marker
            geocoder.geocode({ location: pos }, (results, status) => {
            if (status === "OK") {
                if (results[0]) {
                map.setZoom(11);
                // Display marker method here
                const marker = new google.maps.Marker({
                    position: pos,
                    map: map,
                });
                // Two console.log just for testing purpose
                console.log(results[0].address_components[1]);
                console.log(results[0]);
                // This setContent of the map infowindown
                infowindow.setContent(results[0].formatted_address);
                // Below if/else statement get the id of the location either start or end location
                // and pass the full location (results[0].formatted_address) into CREATE FORM
                // as a String value
                if(document.getElementById("start_location") != null) {
                    document.getElementById("start_location").value = results[0].formatted_address;
                } else {
                    document.getElementById("end_location").value = results[0].formatted_address;
                }
                // Finally open the map, display the marker in the infowindow
                infowindow.open(map, marker);
                } else {
                window.alert("No results found");
                }
            } else {
                window.alert("Geocoder failed due to: " + status);
            }
            });
            console.log(pos);
        }
        )};
    }

