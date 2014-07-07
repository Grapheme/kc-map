
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{{(isset($page_title))?$page_title:Config::get('app.default_page_title')}}}</title>
        <meta name="description" content="{{{(isset($page_description))?$page_description:''}}}">
        <meta name="viewport" content="width=1280, initial-scale=.5">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        {{ HTML::stylemod('css/fontello.css') }}
        {{ HTML::stylemod('css/fotorama.css') }}
        {{ HTML::stylemod('css/normalize.css') }}
        {{ HTML::stylemod('css/main.css') }}
        {{-- HTML::stylemod('css/jquery.selectbox.css') --}}
        <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

        {{ HTML::scriptmod('js/vendor/modernizr-2.6.2.min.js') }}
