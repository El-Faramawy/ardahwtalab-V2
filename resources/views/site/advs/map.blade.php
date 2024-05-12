<div class="form-row">
    <div class="label-div">
        <label>الموقع على الخريطة</label>
    </div>
    <div class="input-div">
        <input type="hidden" id="map-lat" name="lat">
        <input type="hidden" id="map-lng" name="lng">
        <input name="address" class="aFixx mapButton" id="map-address">
        <input type="hidden" id="locationBtn">
        <div id="mapi" style="height:350px;">
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript"
    src='//maps.google.com/maps/api/js?key=AIzaSyA4TQI_nfTodvieDCX9pCB3WpMmaWu0Ywc&libraries=places&language=ar'>
</script>
<!-- map -->
<script>
    var mapDiv = document.getElementById('mapi');
var geocoder = new google.maps.Geocoder;
var infoWindow = new google.maps.InfoWindow;
// Set the Map
var itemlat = parseFloat("{{ $info->lat ?? '24.69023' }}");
var itemlng = parseFloat("{{ $info->lng ?? '46.685' }}");
var map = new google.maps.Map(mapDiv, {
    center: {
        lat: itemlat,
        lng: itemlng
    },
    zoom: 10
});

// Set the Markers
var marker = new google.maps.Marker({
    position: {
        lat: itemlat,
        lng: itemlng
    },
    map: map,
    icon: "{{ url('site/images/marker.png') }}",
    draggable: true,
    animation: google.maps.Animation.xo
});

//auth complete box
var defaultBounds = new google.maps.LatLngBounds(
    new google.maps.LatLng(itemlat, itemlng),
    new google.maps.LatLng(itemlat, itemlng));

var input = document.getElementById('map-address');
var options = {
    bounds: defaultBounds,
    types: ['establishment']
};

autocomplete = new google.maps.places.Autocomplete(input, options);
autocomplete.addListener('place_changed', fillInAddress);

function fillInAddress() {
    marker.setPosition(autocomplete.getPlace().geometry.location);
    var lat = autocomplete.getPlace().geometry.location.lat();
    var lng = autocomplete.getPlace().geometry.location.lng();
    $('#map-lat').val(lat);
    $('#map-lng').val(lng);
    var center = new google.maps.LatLng(lat, lng);
    map.setCenter(center);
}

function run_map() {
    setLocation(map, geocoder, marker);

    start_location();


    google.maps.event.addListener(map, 'click', function (event) {
        marker.setPosition(event.latLng);
        setLocation(map, geocoder, marker);
    });

    // Set Address manually
    google.maps.event.addListener(marker, 'dragend', function () {
        setLocation(map, geocoder, marker);
    });

    google.maps.event.addListener(marker, 'center_changed', function () {
        setLocation(map, geocoder, marker);
    });
}

function setLocation(map, geocoder, marker) {
    var lat = marker.getPosition().lat();
    var lng = marker.getPosition().lng();
    $('#map-lat').val(lat);
    $('#map-lng').val(lng);
    $('#map-address').trigger('change');
    map.setZoom(map.getZoom() + 1);
    geocoder.geocode({
        'latLng': marker.getPosition()
    }, function (results, status) {
        $('#map-address').val(results[0]['formatted_address']);
    });
}
run_map();
@if(isset($info) && $info->id && $info->lat && $info->lng)
    $(this).removeClass('openMap');
    function start_location(){
        var myPosition = new google.maps.LatLng("{{ $info->lat }}", "{{ $info->lng }}");
                map.setCenter(myPosition);
                marker.setPosition(myPosition);
        geocoder.geocode({
            'latLng': myPosition
        }, function (results, status) {
            $('#map-address').val(results[0]['formatted_address']);
        });
    }
    console.log(itemlng);

@else
    function start_location(){
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var myPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                map.setCenter(myPosition);
                marker.setPosition(myPosition);
                geocoder.geocode({
                    'latLng': myPosition
                }, function (results, status) {
                    $('#map-address').val(results[0]['formatted_address']);
                });
            }, function () {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }
    }
@endif

</script>
@endpush
