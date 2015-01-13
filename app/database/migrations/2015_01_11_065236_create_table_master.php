<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMaster extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ms_roles',function($table){
			$table->increments('id');
			$table->string('nama');
		});
		Schema::create('ms_users',function($table){
			$table->increments('id');
			$table->string('username');
			$table->string('password');
			$table->string('email');
			$table->integer('ms_roles_id');
			$table->rememberToken();
		});


		Schema::create('ms_competitions',function($table){
			$table->increments('id');
			$table->string('name');
		});
		Schema::create('ms_categories',function($table){
			$table->increments('id');
			$table->string('name');
			$table->text('description');
			$table->integer('ms_competitions_id');
		});
		Schema::create('ms_questions',function($table){
			$table->increments('id');
			$table->string('name');
			$table->string('file');
			$table->integer('ms_categories_id');
		});
		Schema::create('ms_choices',function($table){
			$table->increments('id');
			$table->string('name');
			$table->integer('ms_questions_id');
		});

		Schema::create('tr_sesi',function($table){
			$table->increments('id');
			$table->string('name');
			$table->dateTime('mulai');
			$table->dateTime('selesai');
			$table->timestamps();
		});

		Schema::create('tr_usersesi',function($table){
			$table->increments('id');
			$table->integer('ms_users_id');
			$table->integer('tr_sesi_id');
			$table->timestamps();
		});

		Schema::create('tr_answers',function($table){
			$table->increments('id');
			$table->integer('tr_usersesi_id');
			$table->integer('ms_questions_id');
			$table->string('answer');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ms_roles');
		Schema::dropIfExists('ms_user');
		Schema::dropIfExists('ms_competitions');
		Schema::dropIfExists('ms_categories');
		Schema::dropIfExists('ms_questions');
		Schema::dropIfExists('ms_choices');
		Schema::dropIfExists('tr_sesi');
		Schema::dropIfExists('tr_usersesi');
		Schema::dropIfExists('tr_answers');
	}
}
