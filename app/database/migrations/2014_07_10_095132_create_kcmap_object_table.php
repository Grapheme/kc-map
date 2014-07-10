<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKcmapObjectTable extends Migration {

	public function up(){
		Schema::create('kcmap_objects', function(Blueprint $table){
			$table->increments('id');
            $table->integer('city_id')->unsigned()->default(0)->index();
            $table->integer('category_id')->unsigned()->default(0)->index();

			$table->string('title')->nullable();
			$table->text('description')->nullable();

            $table->string('address')->nullable();
            $table->string('coordinates')->nullable();

			$table->timestamps();

            $table->foreign('city_id')->references('id')->on('kcmap_cities')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('kcmap_categories')->onDelete('cascade');
		});
	}

	public function down(){
		Schema::drop('kcmap_objects');
	}

}
