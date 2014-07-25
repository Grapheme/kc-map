<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKcmapObjectsTypesTable extends Migration {

	public function up(){
		Schema::create('kcmap_objects_types', function(Blueprint $table)	{
			$table->increments('id');
            $table->string('title')->unique()->nullable();
            $table->string('marker')->nullable();
            $table->string('color')->nullable();
			$table->timestamps();
		});
	}

	public function down()	{
		Schema::drop('kcmap_objects_types');
	}

}
