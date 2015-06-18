<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->text('descriptions');
			$table->text('objectives');
			$table->string('lec_code');
			$table->string('lab_code');
			$table->string('type');
			$table->integer('lec_units');
			$table->integer('lab_units');
			$table->integer('department_id');
			$table->integer('institute_id');
			$table->timestamps();
		});

	}

	/**s
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('courses');
	}

}
