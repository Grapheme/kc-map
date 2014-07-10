<?php

class CitiesSeederTableSeeder extends Seeder {

	public function run(){

        City::create(array('title' => 'г. Черкесск','color' => '#000'));
        City::create(array('title' => 'г. Карачаевск','color' => '#000'));
        City::create(array('title' => 'Абазинский район','color' => '#000'));
        City::create(array('title' => 'Адыге-Хабльский район','color' => '#000'));
        City::create(array('title' => 'Зеленчукский район','color' => '#000'));
        City::create(array('title' => 'Карачаевский район','color' => '#000'));
        City::create(array('title' => 'Малокарачаевский район','color' => '#000'));
        City::create(array('title' => 'Ногайский район','color' => '#000'));
        City::create(array('title' => 'Прикубанский район','color' => '#000'));
        City::create(array('title' => 'Урупский район','color' => '#000'));
        City::create(array('title' => 'Усть-Джегутинский район','color' => '#000'));
        City::create(array('title' => 'Хабезский район','color' => '#000'));
	}
}
