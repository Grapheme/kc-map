<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TruncateTables extends Command {

	protected $name = 'kcmap:truncate';

	protected $description = 'Очистка справочных табли';

	public function __construct(){
		parent::__construct();
	}

	public function fire(){

        DB::table('kcmap_cities')->truncate();
        DB::table('kcmap_categories')->truncate();
        DB::table('kcmap_objects')->truncate();
	}


	protected function getArguments(){
		return array();
	}

	protected function getOptions(){
		return array();
	}
}
