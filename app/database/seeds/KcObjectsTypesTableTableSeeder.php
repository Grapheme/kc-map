<?php


class KcObjectsTypesTableTableSeeder extends Seeder {

	public function run(){

        KcMapObjecType::create(array('title'=>'Законченное строительство','marker'=>'islands#icon','color'=>'#00CC33'));
        KcMapObjecType::create(array('title'=>'Строящиеся объекты','marker'=>'islands#dotIcon','color'=>'#993300'));
        KcMapObjecType::create(array('title'=>'Проектирование (план строительства)','marker'=>'islands#circleIcon','color'=>'#CCFF33'));
        KcMapObjecType::create(array('title'=>'Срочно необходимо дополнительное финансирование','marker'=>'islands#circleDotIcon','color'=>'#FF33FF'));
	}
}
