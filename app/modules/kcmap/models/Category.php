<?php

class Category extends BaseModel {

    protected $table = 'kcmap_categories';

    protected $fillable = array('title','color');
}