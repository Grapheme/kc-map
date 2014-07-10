<?php

class MapObjects extends BaseModel {

    protected $table = 'kcmap_objects';

    protected $fillable = array('city_id','category_id','title','description');

    public static $rules = array(
        'title' => 'required',
        'description' => 'required',
        'city' => 'required',
        'category' => 'required',
    );

    public function cities(){
        return $this->belongsTo('City','city_id');
    }

    public function categories(){
        return $this->belongsTo('Category','category_id');
    }
}