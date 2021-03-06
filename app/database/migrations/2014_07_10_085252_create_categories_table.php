<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	public function up(){
		Schema::create('kcmap_categories', function(Blueprint $table){
			$table->increments('id');
			$table->string('title')->unique()->nullable();
			$table->string('color')->nullable();
			$table->timestamps();
		});
	}


	public function down()	{
		Schema::drop('kcmap_categories');
	}

}
