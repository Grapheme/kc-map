<?php
$cities = City::orderBy('title')->with(array('map_objects' => function ($query) {
        $query->with('categories');
        $query->groupBy('city_id');
        $query->groupBy('category_id');
    }))->get();
?>

<aside class="aside clearfix">
    <h2 class="aside-header">Объекты на карте</h2>
    <ul class="aside-list list-unstyled clearfix">
        @foreach($cities as $city)
        @if($city->map_objects->count())
        <li id="parent-{{ $city->id }}">{{ $city->title }}</li><br/>
        <ul id="child-{{ $city->id }}" class="aside-list inside-block list-unstyled clearfix">
            @foreach($city->map_objects as $object)
            @if(isset($object->categories->title))
            <li>
                <label class="checkbox">
                    <input type="checkbox" data-city="{{ $city->id }}" data-category="{{ $object->categories->id }}"
                           class="show-map-objects" name="categories[]"> {{ $object->categories->title }}
                </label>
            </li>
            @endif
            @endforeach
        </ul>
        @endif
        @endforeach
    </ul>
</aside>