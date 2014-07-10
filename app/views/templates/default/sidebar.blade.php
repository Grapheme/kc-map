<?php
$cities = City::orderBy('title')->with(array('map_objects' => function ($query) {
        $query->with('categories');
        $query->groupBy('city_id');
        $query->groupBy('category_id');
    }))->get();
?>

<aside class="aside col-xs-2 col-sm-2 col-md-2 col-lg-2">
    <h2 class="aside-header">Объекты</h2>
    <ul class="aside-list list-unstyled">
        @foreach($cities as $city)
        @if($city->map_objects->count())
        <li>{{ $city->title }}</li>
        <ul class="aside-list list-unstyled">
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