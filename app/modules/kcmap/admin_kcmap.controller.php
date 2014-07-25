<?php

class AdminKcmapController extends BaseController {

    public static $name = 'kcmap';
    public static $group = 'kcmap';

    /****************************************************************************/
    ## Routing rules of module
    public static function returnRoutes($prefix = null) {
        $class = __CLASS__;
        Route::group(array('before' => 'auth', 'prefix' => $prefix), function() use ($class) {
            Route::controller($class::$group, $class,array('except'=>'show'));
        });
    }

    ## Shortcodes of module
    public static function returnShortCodes() {

    }

    ## Actions of module (for distribution rights of users)
    ## return false;   # for loading default actions from config
    ## return array(); # no rules will be loaded
    public static function returnActions() {
        return array(
            'view'   => 'Просмотр',
            'create' => 'Создание',
            'edit'   => 'Редактирование',
            'delete' => 'Удаление',
        );
    }

    ## Info about module (now only for admin dashboard & menu)
    public static function returnInfo() {
        return array(
            'name' => self::$name,
            'group' => self::$group,
            'title' => 'Перечень объектов',
            'visible' => 1,
        );
    }

    ## Menu elements of the module
    public static function returnMenu() {
        return array(
            array(
                'title' => 'Перечень объектов',
                'link' => self::$group,
                'class' => 'fa-location-arrow',
                'permit' => 'view',
            ),
        );
    }

    /****************************************************************************/
    protected $map_object;

    public function __construct(MapObjects $map_object){

        $this->map_object = $map_object;
        $this->beforeFilter('map_object');
        $this->locales = Config::get('app.locales');

        View::share('module_name', self::$name);

        $this->tpl = static::returnTpl('admin');
        $this->gtpl = static::returnTpl();
        View::share('module_tpl', $this->tpl);
        View::share('module_gtpl', $this->gtpl);

    }

    public function getIndex(){

        $map_objects = $this->map_object->orderBy('id','DESC')->with('cities')->with('categories');

            if (Input::get('city')):
                $map_objects = $map_objects->where('city_id',Input::get('city'));
            endif;
            if (Input::get('category')):
                $map_objects = $map_objects->where('category_id',Input::get('category'));
            endif;

        $map_objects = $map_objects->paginate(15);
        $map_objects->appends(array('city'=>(int)Input::get('city'),'category'=>(int)Input::get('category')));
        return View::make($this->tpl.'index', array('map_objects' => $map_objects, 'locales' => $this->locales));
    }

    public function getCreate(){

        $this->moduleActionPermission('kcmap','create');
        return View::make($this->tpl.'create', array('locales' => $this->locales));
    }

    public function postStore(){

        $this->moduleActionPermission('kcmap','create');
        $json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
        if(Request::ajax()):
            $validator = Validator::make(Input::all(), MapObjects::$rules);
            if($validator->passes()):
                self::saveKcMapModel();
                $json_request['responseText'] = 'Объект создан';
                $json_request['redirect'] = link::auth('kcmap');
                $json_request['status'] = TRUE;
            else:
                $json_request['responseText'] = 'Неверно заполнены поля';
                $json_request['responseErrorText'] = $validator->messages()->all();
            endif;
        else:
            return App::abort(404);
        endif;
        return Response::json($json_request,200);
    }

    public function getEdit($id){

        $this->moduleActionPermission('kcmap','edit');
        if(!$map_object = $this->map_object->find($id)):
            return App::abort(404);
        endif;
        return View::make($this->tpl.'edit', array('map_object'=>$map_object, 'locales' => $this->locales));
    }

    public function postUpdate($id){

        $this->moduleActionPermission('kcmap','edit');
        $json_request = array('status'=>FALSE,'responseText'=>'','responseErrorText'=>'','redirect'=>FALSE);
        if(Request::ajax()):
            $validator = Validator::make(Input::all(), MapObjects::$rules);
            if($validator->passes()):
                $map_object = $this->map_object->find($id);
                self::saveKcMapModel($map_object);
                $json_request['responseText'] = 'Объект сохранен';
                $json_request['redirect'] = link::auth('kcmap');
                $json_request['status'] = TRUE;
            else:
                $json_request['responseText'] = 'Неверно заполнены поля';
                $json_request['responseErrorText'] = $validator->messages()->all();
            endif;
        else:
            return App::abort(404);
        endif;
        return Response::json($json_request,200);
    }

    public function deleteDestroy($id){

        $this->moduleActionPermission('kcmap', 'delete');
        $json_request = array('status'=>FALSE, 'responseText'=>'');
        if(Request::ajax()):
            $this->map_object->find($id)->delete();
            $json_request['responseText'] = 'Объект удален';
            $json_request['status'] = TRUE;
        else:
            return App::abort(404);
        endif;
        return Response::json($json_request,200);
    }

    private function saveKcMapModel($map_object = NULL){

        if(is_null($map_object)):
            $map_object = $this->map_object;
        endif;

        $map_object->city_id = Input::get('city');
        $map_object->category_id = Input::get('category');
        $map_object->type_id = Input::get('type');

        $map_object->title = Input::get('title');
        $map_object->description = Input::get('description');
        $map_object->address = Input::get('address');
        $map_object->coordinates = json_encode(array_merge(Input::get('coordinates')));
        ## Сохраняем в БД
        $map_object->save();
        $map_object->touch();
        return $map_object->id;
    }

}