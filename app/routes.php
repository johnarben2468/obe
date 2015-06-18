<?php


Route::get('/', function()
{

	return View::make('login');
	
});

Route::get('/register', function()
{

	return View::make('register');
	
});

Route::post('register', array('uses' => 'AuthController@register', 'as'=>'register'));

Route::get('/login', function()
{

	return View::make('login');
	
});

Route::post('login', array('uses' => 'AuthController@login', 'as'=>'login'));

Route::get('logout', array('uses' => 'AuthController@logout', 'as'=>'logout'));




Route::get('/admin', function()
{
	return View::make('admin.index');
})->before("admin");

Route::get('/admin/settings', function()
{
	return View::make('admin.edit_settings');
})->before("admin");
Route::post('/admin/settings', array('uses' => 'AdminController@edit_settings', 'as'=>'edit_settings'))->before("admin");

Route::get('/admin/departments', function()
{
	$departments = Department::where("institute_id",Auth::user()->institute_id)->get();
	return View::make('admin.departments')->with("departments", $departments);
})->before("admin");
Route::post('/admin/departments', array('uses' => 'AdminController@add_department', 'as'=>'add_department'))->before("admin");

Route::get('/admin/programs', function()
{
	$programs = Program::where("institute_id",Auth::user()->institute_id)->get();
	return View::make('admin.programs')->with("programs", $programs);
})->before("admin");
Route::post('/admin/programs', array('uses' => 'AdminController@add_program', 'as'=>'add_program'))->before("admin");

Route::get('/admin/programs/view/{id}', function($id)
{
	$program = Program::where("id",$id)->where("institute_id",Auth::user()->institute_id)->first();
	$courses = Course::where("institute_id",Auth::user()->institute_id)->get();
	$progcours = ProgCour::where("program_id",$id)->get();
	$programoutcomes = ProgramOutcome::where("program_id",$id)->get();
	$departments = Department::where("institute_id",Auth::user()->institute_id)->get();
	return View::make('admin.program')->with("departments", $departments)->with("program", $program)->with("progcours", $progcours)->with('courses', $courses)->with("programoutcomes", $programoutcomes);
})->before("admin");


Route::post('/admin/programs/add/outcome', array('uses' => 'AdminController@add_program_outcome', 'as'=>'add_program_outcome'))->before("admin");
