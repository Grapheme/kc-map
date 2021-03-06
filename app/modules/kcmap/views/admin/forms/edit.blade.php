{{ Form::model($map_object,array('url'=>link::auth('kcmap/update/'.$map_object->id),'class'=>'smart-form','id'=>'kcmap-form','role'=>'form','method'=>'post')) }}

<div class="row margin-top-10">
    <section class="col col-6">
        <div class="well">
            <header>Для редактирования объекта заполните форму:</header>
            <fieldset>
                <section>
                    <label class="label">Наименование</label>
                    <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                        {{ Form::text('title',NULL) }}
                    </label>
                </section>
                <section>
                    <label class="label">Регион</label>
                    <label class="select">
                        {{ Form::select('city',
                        City::orderBy('title')->lists('title','id'),$map_object->city_id,array('autocomplete'=>'off'))
                        }} <i></i>
                    </label>
                </section>
                <section>
                    <label class="label">Категория</label>
                    <label class="select">
                        {{ Form::select('category',
                        Category::orderBy('title')->lists('title','id'),$map_object->category_id,array('autocomplete'=>'off'))
                        }} <i></i>
                    </label>
                </section>
                 <section>
                    <label class="label">Тип</label>
                    <label class="select">
                        {{ Form::select('type',
                        KcMapObjecType::orderBy('title')->lists('title','id'),$map_object->type_id,array('autocomplete'=>'off')) }} <i></i>
                    </label>
                </section>
            </fieldset>
            <fieldset>
                <section>
                    <label class="label">Адрес</label>
                    <label class="input"> <i class="icon-append fa fa-home"></i>
                        {{ Form::text('address',NULL) }}
                    </label>
                </section>
                <?php
                $coordinates = json_decode($map_object->coordinates, TRUE);
                ?>
                <div class="row">
                    <section class="col col-2">
                        <label class="label">Координаты</label>
                        <label class="input">
                            {{ Form::text('coordinates[x]',$coordinates['x']) }}
                        </label>
                    </section>
                    <section class="col col-2">
                        <label class="label">&nbsp;</label>
                        <label class="input">
                            {{ Form::text('coordinates[y]',$coordinates['y']) }}
                        </label>
                    </section>
                </div>
            </fieldset>
            <fieldset>
                <section>
                    <label class="label">Примечание</label>
                    <label class="textarea">
                        {{ Form::textarea('description',NULL,array('class'=>'redactor redactor_450')) }}
                    </label>
                </section>
            </fieldset>
        </div>
    </section>
</div>
<section class="col-6">
    <footer>
        <a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{URL::previous()}}">
            <i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
        </a>
        <button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
            <i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Сохранить</span>
        </button>
    </footer>
</section>

{{ Form::close() }}