<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseOutcomesTable extends Migration {

/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_outcomes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('outcome');
			$table->integer('course_id');
			$table->timestamps();
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('course_outcomes');
	}

}
