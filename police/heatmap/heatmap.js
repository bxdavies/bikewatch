function initMap(){
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: new google.maps.LatLng(51.89934719994831, -2.078342627096383),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    const request = $.post("heatmap_dao.php")
    var locations = [];
    request.done((response) => {
        response = JSON.parse(response)
        response.forEach((location) => {
            var locationObject = new google.maps.LatLng(location.latitude, location.longitude)
            locations.push(locationObject);
        });

        //This is the start of heatmap code
        var heatmap=new google.maps.visualization.HeatmapLayer(
        {
            data:locations,
            map: map,
            radius: 20
        });
    
    });
	
   

}