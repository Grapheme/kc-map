<?php

class GalleriesController extends BaseController {

    public static $name = 'galleries_public';
    public static $group = 'galleries';

    /****************************************************************************/

    ## Routing rules of module
    public static function returnRoutes($prefix = null) {
    }
    
    ## Shortcodes of module
    public static function returnShortCodes() {

        $tpl = static::returnTpl();

    	shortcode::add("gallery",
        
            function($params = null) use ($tpl) {

                $default = array(
                    'tpl' => "gallery-default",
                );
                $params = array_merge($default, (array)$params);

                if(empty($params['tpl']) || !View::exists($tpl.$params['tpl'])) {
                    throw new Exception('Template not found: ' . $tpl.$params['tpl']);
                }

                if (!isset($params['id'])) {
                    #return false;
                    #return "Error: id of gallery is not defined!";
                    throw new Exception('ID of gallery is not defined');
                }

                $gallery_id = $params['id'];

                $gallery = Gallery::where('id', $gallery_id)->first();

                if (!is_object($gallery) || !@$gallery->id) {
                    return false;
    	        	#return "Error: gallery #{$gallery_id} doesn't exist!";
                }
                
                $photos = $gallery->photos;
                
                if (!$photos->count()) {
                    return false;
                }
                
                #dd($tpl.$params['tpl']);
                #dd(compact($photos));
                
                #return View::make($tpl.$params['tpl'], compact($photos)); ## don't work
                return View::make($tpl.$params['tpl'], array('photos' => $photos));
    	    }
        );
        
    }


    ## Actions of module (for distribution rights of users)
    ## return false;   # for loading default actions from config
    ## return array(); # no rules will be loaded
    /*
    public static function returnActions() {
        return array();
    }
    */
    
    ## Info about module (now only for admin dashboard & menu)
    /*
    public static function returnInfo() {
    }
    */
    
    /****************************************************************************/

	public function __construct(){

        $this->tpl = static::returnTpl();
        View::share('module_name', self::$name);

        $this->tpl = $this->gtpl = static::returnTpl();
        View::share('module_tpl', $this->tpl);
        View::share('module_gtpl', $this->gtpl);
    }
    
    /*
    |--------------------------------------------------------------------------
    | Раздел "Новости" - I18N
    |--------------------------------------------------------------------------
    */
    ## Функция для просмотра полной мультиязычной новости
    public function showFullByUrl($url){

        return NULL;
	}

}