<?php

class Category extends BaseModel {

    protected $table = 'kcmap_categories';

    protected $fillable = array('title','color');

    public function map_objects(){

        return $this->hasMany('MapObjects','category_id');
    }
}