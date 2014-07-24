@extends(Helper::layout())

@section('style')
<style type="text/css">
    html, body, #map {
        width: 100%; padding: 0; margin: 0;
        font-family: Arial;
    }

    #map {
        height: 500px;
    }
    /* Оформление меню (начало)*/
    .menu {
        list-style: none;
        padding: 5px;

        margin: 0;
    }
    .submenu {
        list-style: none;

        margin: 0 0 0 20px;
        padding: 0;
    }
    .submenu li {
        font-size: 90%;
    }
    /* Оформление меню (конец)*/
</style>
@stop

@section('content')
@include('kcmap/views/default')
@stop

@section('scripts')
{{ HTML::script('//api-maps.yandex.ru/2.1/?lang=ru_RU') }}
{{ HTML::script('get-objects') }}
<script type="application/javascript">
    var KcMap = KcMap || {};
    ymaps.ready(function(){
        KcMap = new ymaps.Map('map',{center: [44.226863,42.04677],zoom: 8,controls: ['zoomControl', 'fullscreenControl']});
        refreshDataMap();
    });
    function refreshDataMap(){
        KcMap.geoObjects.removeAll();
        $(".show-map-objects:checked").each(function (element_index, element) {
            $.each(all_objects, function (object_index, object_value) {
                if (object_value.city_id == $(element).attr('data-city') && object_value.category_id == $(element).attr('data-category')) {
                    coordinate = $.parseJSON(object_value.coordinate);
                    if ((coordinate.x == '' || coordinate.y == '') && object_value.address != '') {
                        setMarkerByAddress(object_value);
                    }else if(coordinate.x != '' && coordinate.y != ''){
                        setMarkerByCoordinate(object_value);
                    }
                }
            });
        });
    }
    function setMarkerByAddress(object) {

        ymaps.geocode(object.address, {
            results: 1
        }).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0),
                coords = firstGeoObject.geometry.getCoordinates(),
                bounds = firstGeoObject.properties.get('boundedBy');
            KcMap.geoObjects.add(firstGeoObject);
            KcMap.setBounds(bounds, {checkZoomRange: true});
            console.log(object.address+' - '+coords);
            var newPlacemark = new ymaps.Placemark(coords, {
                hintContent : object.balloon.hintContent,
                balloonContentHeader : object.balloon.balloonContentHeader,
                balloonContentBody: object.balloon.balloonContentBody,
                balloonContentFooter : object.balloon.balloonContentFooter
            }, {
                preset: object.marker.preset,
                iconColor: object.marker.iconColor
            });
            KcMap.geoObjects.add(newPlacemark);
            KcMap.setCenter([44.226863,42.04677],8,{checkZoomRange: true});
        });

    }
    function setMarkerByCoordinate(object) {
        console.log(object.coordinate);
        KcMap.geoObjects
            .add(new ymaps.Placemark([object.coordinate.x, object.coordinate.y], {
                hintContent : object.balloon.hintContent,
                balloonContentHeader : object.balloon.balloonContentHeader,
                balloonContentBody: object.balloon.balloonContentBody,
                balloonContentFooter : object.balloon.balloonContentFooter
            }, {
                preset: object.marker.preset,
                iconColor: object.marker.iconColor
            }));
    }

    $(function () {
        $(".show-map-objects").click(function () {refreshDataMap();});
    });
</script>
@stop