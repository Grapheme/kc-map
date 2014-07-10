<?php


class CategoriesTableSeeder extends Seeder {

	public function run(){

        Category::create(array('title' => 'Объекты образования','color' => '#000'));
        Category::create(array('title' => 'Объекты жилищно-коммунального хозяйства','color' => '#000'));
        Category::create(array('title' => 'Объекты здравоохранения','color' => '#000'));
        Category::create(array('title' => 'Объекты физической культуры и спорта','color' => '#000'));
        Category::create(array('title' => 'Объекты культуры','color' => '#000'));
	}
}
