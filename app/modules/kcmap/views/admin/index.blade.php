@extends('templates.'.AuthAccount::getStartPage())

@section('content')
<h1>Перечень объектов</h1>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom-25 margin-top-10">
        <div class="pull-left margin-right-10">
            @if(Allow::action('kcmap','create'))
            <a class="btn btn-primary" href="{{ link::auth('kcmap/create') }}">Добавить объект</a>
            @endif
        </div>

        <?php

        $cities = City::orderBy('title');
        if (Input::get('category')):
            $cities = $cities->with(array('map_objects' => function ($query) {
                    $query->where('category_id', Input::get('category'));
                }))->get();;
        else:
            $cities = $cities->with('map_objects')->get();;
        endif;
        $categories = Category::orderBy('title');
        if (Input::get('city')):
            $categories = $categories->with(array('map_objects' => function ($query) {
                    $query->where('city_id', Input::get('city'));
                }))->get();;
        else:
            $categories = $categories->with('map_objects')->get();;
        endif;

        //        print_r($cities->find(3)->title);
        //        exit;
        ?>

        @if($cities->count())
        <div class="btn-group pull-left margin-right-10">
            @if ( (int) Input::get('city') > 0)
            <a class="btn btn-default" href="javascript:void(0);">{{ $cities->find(Input::get('city'))->title }} ({{
                count($cities->find(Input::get('city'))->map_objects) }})</a>
            @else
            <a class="btn btn-default" href="javascript:void(0);">Регион</a>
            @endif
            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><span
                    class="caret"></span></a>
            <ul class="dropdown-menu">
                <li>
                    @if(Input::get('page'))
                    <a href="?">Все регионы ({{ $cities->count() }})</a>
                    @else
                    <a href="?page={{ (int) Input::get('page') }}&city=0&category={{ (int) Input::get('category') }}">Все
                        регионы ({{ $cities->count() }})</a>
                    @endif
                </li>
                <li class="divider"></li>
                @foreach($cities as $city)
                <li>
                    @if(Input::get('page'))
                    <a href="?city={{ $city->id }}&category={{ (int) Input::get('category') }}">{{ $city->title }} ({{
                        count($city->map_objects) }})</a>
                    @else
                    <a href="?page={{ (int) Input::get('page') }}&city={{ $city->id }}&category={{ (int) Input::get('category') }}">{{
                        $city->title }} ({{ count($city->map_objects) }})</a>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        @endif
        @if($categories->count())
        <div class="btn-group pull-left margin-right-10">
            @if (Input::get('category'))
            <a class="btn btn-default" href="javascript:void(0);">{{ $categories->find(Input::get('category'))->title }}
                ({{ count($categories->find(Input::get('category'))->map_objects) }})</a>
            @else
            <a class="btn btn-default" href="javascript:void(0);">Категории</a>
            @endif
            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><span
                    class="caret"></span></a>
            <ul class="dropdown-menu">
                <li>
                    @if(Input::get('page'))
                    <a href="?">Все категории ({{ $categories->count() }})</a>
                    @else
                    <a href="?page={{ (int) Input::get('page') }}&city={{ (int) Input::get('city') }}&category=0">Все
                        категории ({{ $categories->count() }})</a>
                    @endif
                </li>
                <li class="divider"></li>
                @foreach($categories as $category)
                <li>
                    @if(Input::get('page'))
                    <a href="?city={{ (int) Input::get('city') }}&category={{ $category->id }}">{{ $category->title }}
                        ({{ count($category->map_objects) }})</a>
                    @else
                    <a href="?page={{ (int) Input::get('page') }}&city={{ (int) Input::get('city') }}&category={{ $category->id }}">{{
                        $category->title }} ({{ count($category->map_objects) }})</a>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>
</div>
@if($map_objects->count())
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <table class="table table-striped table-bordered min-table">
            <thead>
            <tr>
                <th class="text-center">Наименование</th>
                <th class="text-center">Город</th>
                <th class="text-center">Категория</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($map_objects as $object)
            <tr>
                <td>{{ $object->title }}</a></td>
                <td class="text-center">{{ $object->cities->title }}</td>
                <td class="text-center">{{ $object->categories->title }}</td>
                <td>
                    @if(Allow::action('kcmap', 'edit'))
                    <a class="btn btn-default pull-left margin-right-10"
                       href="{{ link::auth('kcmap/edit/'.$object->id) }}">
                        Редактировать
                    </a>
                    @endif
                    @if(Allow::action('kcmap', 'delete'))
                    <form method="POST" action="{{ link::auth('kcmap/destroy/'.$object->id) }}">
                        <button type="button" class="btn btn-default remove-object">
                            Удалить
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        {{ $map_objects->links() }}
    </div>
</div>
@else
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="ajax-notifications custom">
            <div class="alert alert-transparent">
                <h4>Список пуст</h4>
                В данном разделе находится перечень объектов
                <p><br><i class="regular-color-light fa fa-th-list fa-3x"></i></p>
            </div>
        </div>
    </div>
</div>
@endif
@stop


@section('scripts')
<script src="{{ url('js/modules/kcmap.js') }}"></script>
<script type="text/javascript">
    if (typeof pageSetUp === 'function') {
        pageSetUp();
    }
    if (typeof runFormValidation === 'function') {
        loadScript("{{ asset('js/vendor/jquery-form.min.js'); }}", runFormValidation);
    } else {
        loadScript("{{ asset('js/vendor/jquery-form.min.js'); }}");
    }
</script>
@stop

