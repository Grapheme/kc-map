<?php

class KcmapController extends BaseController{

    public static $name = 'kcmap_public';
    public static $group = 'kcmap';

    public static $yandex_default_markers = FALSE;
    /****************************************************************************/
    public static function returnRoutes(){

        Route::get('get-objects', __CLASS__ . '@getAllObjects');
    }

    ## Shortcodes of module
    public static function returnShortCodes(){

    }

    /****************************************************************************/

    public function __construct(){

    }

    public function getAllObjects(){

        $all_objects = '';
        foreach (MapObjects::orderBy('title')->with('categories')->with('types')->get() as $object):
            $single_object = '{city_id : '.$object->city_id.',category_id : '.$object->category_id .',address: "'.addslashes($object->address) .'",';
            $single_object .= 'coordinate :JSON.stringify('.$object->coordinates.'),balloon : {balloonContentHeader: "'.addslashes($object->title).'",';
            $single_object .= 'balloonContentBody: "'.str_replace("\n","",addslashes($object->description)) .'",balloonContentFooter: "",';
            $single_object .= 'hintContent: "'.addslashes($object->title).'"},';
            if (self::$yandex_default_markers):
            $single_object .= 'marker : {preset: "'.$object->types->marker.'",iconColor: "'.$object->types->color.'"}}';
            else:
            $single_object .= 'marker : {iconLayout: "default#image", iconImageHref: "'.self::getMarkerImages($object->categories->id,$object->types->id).'",iconImageSize:[30, 42],iconImageOffset: [-3, -42] }}';
            endif;
            $all_objects[] = $single_object;
        endforeach;
        header("content-type: application/javascript");
        echo 'var all_objects = ['.implode(',',$all_objects).'];';
    }

    private function getMarkerImages($category_id = 1,$type_id = 1){

        $markers[1][1] = asset('theme/img/markers/1-1.png');
        $markers[1][2] = asset('theme/img/markers/1-2.png');
        $markers[1][3] = asset('theme/img/markers/1-3.png');
        $markers[1][4] = asset('theme/img/markers/1-4.png');

        $markers[2][1] = asset('theme/img/markers/2-1.png');
        $markers[2][2] = asset('theme/img/markers/2-2.png');
        $markers[2][3] = asset('theme/img/markers/2-3.png');
        $markers[2][4] = asset('theme/img/markers/2-4.png');

        $markers[3][1] = asset('theme/img/markers/3-1.png');
        $markers[3][2] = asset('theme/img/markers/3-2.png');
        $markers[3][3] = asset('theme/img/markers/3-3.png');
        $markers[3][4] = asset('theme/img/markers/3-4.png');

        $markers[4][1] = asset('theme/img/markers/4-1.png');
        $markers[4][2] = asset('theme/img/markers/4-2.png');
        $markers[4][3] = asset('theme/img/markers/4-3.png');
        $markers[4][4] = asset('theme/img/markers/4-4.png');

        $markers[5][1] = asset('theme/img/markers/5-1.png');
        $markers[5][2] = asset('theme/img/markers/5-2.png');
        $markers[5][3] = asset('theme/img/markers/5-3.png');
        $markers[5][4] = asset('theme/img/markers/5-4.png');

        if(isset($markers[$category_id][$type_id])):
            return $markers[$category_id][$type_id];
        else:
            return NULL;
        endif;
    }
}