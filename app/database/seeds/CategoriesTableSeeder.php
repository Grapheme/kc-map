<?php


class CategoriesSeederTableSeeder extends Seeder {

	public function run(){

        Category::create(array('title' => 'Объекты жилищно-коммунального хозяйства','color' => '#000'));
        Category::create(array('title' => 'Объекты здравоохранения','color' => '#000'));
        Category::create(array('title' => 'Объекты физической культуры и спорта','color' => '#000'));
	}
}
