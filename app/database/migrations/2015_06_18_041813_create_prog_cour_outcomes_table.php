<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgCourOutcomesTable extends Migration {
/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prog_cour_outcomes', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('prog_cour_id');
			$table->integer('course_outcome_id');
			$table->integer('program_outcome_id');
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
		Schema::drop('prog_cour_outcomes');
	}

}
