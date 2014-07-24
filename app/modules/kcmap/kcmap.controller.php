<?php

class KcmapController extends BaseController{

    public static $name = 'kcmap_public';
    public static $group = 'kcmap';

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
            $single_object = '{"city_id" : '.$object->city_id.',"category_id" : '.$object->category_id .',"address": "'.addslashes($object->address) .'",';
            $single_object .= 'coordinate :JSON.stringify('.$object->coordinates.'),balloon : {balloonContentHeader: "'.addslashes($object->title).'",';
            $single_object .= 'balloonContentBody: "'.str_replace("\n","",addslashes($object->description)) .'",balloonContentFooter: "",';
            $single_object .= 'hintContent: "'.addslashes($object->title).'",},marker : {preset: "'.$object->types->marker.'",iconColor: "'.$object->types->color.'"}}';
            $all_objects[] = $single_object;
        endforeach;
        header("content-type: application/javascript");
        echo 'var all_objects = ['.implode(',',$all_objects).'];';
    }

}