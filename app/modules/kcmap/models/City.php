<?php

class City extends BaseModel{

    protected $table = 'kcmap_cities';

	protected $fillable = ['title','color'];

    public function map_objects(){

        return $this->hasMany('MapObjects','city_id');
    }
}