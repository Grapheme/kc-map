<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    @include('templates.site.head')
    @yield('style')
</head>
<body>
    <!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
        your browser</a> to improve your experience.</p>
    <![endif]-->

    @include('templates.site.header')
	
	<div id="legend">
		<ul>
			<li><span>Обозначения на карте:</span></li>
			<li><img src="/theme/img/markers/1-1.png" alt="" />Образование</li>
			<li><img src="/theme/img/markers/2-1.png" alt="" />ЖКХ</li>
			<li><img src="/theme/img/markers/3-1.png" alt="" />Здравоохранение</li>
			<li><img src="/theme/img/markers/4-1.png" alt="" />Спорт</li>
			<li><img src="/theme/img/markers/5-1.png" alt="" />Культура</li>
		</ul>
	</div>
    <div id="content clearfix">
        @include('templates.site.sidebar')
        @yield('content', @$content)
    </div>

    @include('templates.site.footer')
    @include('templates.site.scripts')
    @yield('scripts')
</body>
</html>