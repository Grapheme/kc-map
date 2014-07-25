@extends(Helper::layout())

@section('style')
<style type="text/css">
    html, body {
        height: 100%; width: 100%; padding: 0; margin: 0;
        font-family: 'Open Sans', sans-serif;
        font-size: 12px;
        line-height: 1.4em;
    }
    ul {
    	margin: 0;
    	padding: 0;
    	list-style: none;
    }
    ul.aside-list > li {
    	margin: 0 0 0 1.5em;
    	line-height: 1.7em;
    }
    ul.inside-block {
    	display: none;
    }
    h2 {
    	font-weight: 300;
    	margin: 0 0 1em;
    }
    h2.aside-header + ul.aside-list > li {
    	font-weight: 600;
    	margin: 1em 0 0.5em 0;
    	border-bottom: 1px dotted;
    	display: inline-block;
    	line-height: 1.2em;
    	cursor: pointer;
    }

	.map-wrapper {
		width: 68%;
		float: left;
		height: 600px;
		max-height: 90%;
	}
	.ymaps-map .ymaps-balloon-content__header {
		font: 600 16px 'Open Sans', sans-serif !important;
		text-align: left !important;
	}
	.ymaps-map p, .ymaps-map *, .ymaps-map *:before, .ymaps-map *:after {
		font: 400 12px/1.4em 'Open Sans', sans-serif !important;
	}

    #map {
        height: 600px;
        width: 100%;
    }
    .aside {
    	width: 30%;
    	max-width: 320px;
    	float: left;
    	padding: 0 1em 0 2em;
    }
    /* Оформление меню (начало)*/
    .menu {
        list-style: none;
        padding: 5px;
        margin: 0;
    }
    .submenu {
        list-style: none;

        margin: 0 0 0 5px;
        padding: 0;
    }
    .submenu li {
        
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
	$(function(){
		$('h2.aside-header + ul.aside-list > li').click(function(){
			var id = $(this).attr('id').replace('parent-',''); 
			$('#child-'+id).toggle();
		});
	})

    var KcMap = KcMap || {};
    ymaps.ready(function(){
        KcMap = new ymaps.Map('map',{center: [44.226863,42.04677],zoom: 9,controls: ['zoomControl', 'fullscreenControl']});
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

        /*
        * preset: object.marker.preset,
        * iconColor: object.marker.iconColor
        */
        ymaps.geocode(object.address, {
            results: 1
        }).then(function (res) {
            var newGeoObject = res.geoObjects.get(0),
                coords = newGeoObject.geometry.getCoordinates(),
                bounds = newGeoObject.properties.get('boundedBy');
            KcMap.setBounds(bounds, {checkZoomRange: true});

            console.log(object.address+' - '+coords);

            var newPlacemark = new ymaps.Placemark(coords, {
                hintContent : object.balloon.hintContent,
                balloonContentHeader : object.balloon.balloonContentHeader,
                balloonContentBody: object.balloon.balloonContentBody,
                balloonContentFooter : object.balloon.balloonContentFooter
            }, {
                iconLayout: object.marker.iconLayout,
                iconImageHref: object.marker.iconImageHref,
                iconImageSize: object.marker.iconImageSize,
                iconImageOffset: object.marker.iconImageOffset
            });
            KcMap.geoObjects.add(newPlacemark);
            KcMap.setCenter([44.226863,42.04677],9,{checkZoomRange: true});
        });

    }
    function setMarkerByCoordinate(object) {
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
        KcMap.geoObjects.add(newPlacemark);
        KcMap.setCenter([44.226863,42.04677],8,{checkZoomRange: true});
    }

    $(function () {
        $(".show-map-objects").click(function () {refreshDataMap();});
    });
</script>
@stop