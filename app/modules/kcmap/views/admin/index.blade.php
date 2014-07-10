@extends('templates.'.AuthAccount::getStartPage())

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="margin-bottom-25 margin-top-10 ">
            @if(Allow::action('kcmap','create'))
            <a class="btn btn-primary" href="{{ link::auth('kcmap/create') }}">Добавить объект</a>
            @endif
        </div>
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
                <td>{{ $object->title  }}</a></td>
                <td class="text-center">{{ $object->cities->title }}</td>
                <td class="text-center">{{ $object->categories->title }}</td>
                <td>
                    @if(Allow::action('kcmap', 'edit'))
                    <a class="btn btn-default pull-left margin-right-10" href="{{ link::auth('kcmap/edit/'.$object->id) }}">
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
        {{ $map_objects->links(); }}
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
    if(typeof pageSetUp === 'function'){pageSetUp();}
    if(typeof runFormValidation === 'function'){
        loadScript("{{ asset('js/vendor/jquery-form.min.js'); }}", runFormValidation);
    }else{
        loadScript("{{ asset('js/vendor/jquery-form.min.js'); }}");
    }
</script>
@stop

