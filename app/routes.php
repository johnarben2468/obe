<?php


Route::get('/', function()
{

	if(Auth::check())
	{
		if(Auth::user()->user_type=="admin")
		{
			return Redirect::to("/admin");
		}


	}
	return Redirect::to("/login");
	
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
	return View::make('admin.view_programs')->with("departments", $departments)->with("program", $program)->with("progcours", $progcours)->with('courses', $courses)->with("programoutcomes", $programoutcomes);
})->before("admin");

Route::post('/admin/programs/add/course', array('uses' => 'AdminController@add_program_course', 'as'=>'add_program_course'))->before("admin");

Route::post('/admin/programs/add/outcome', array('uses' => 'AdminController@add_program_outcome', 'as'=>'add_program_outcome'))->before("admin");


Route::get('/admin/courses', function()
{
	$departments = Department::where("institute_id",Auth::user()->institute_id)->get();
	
	$courses = Course::where("institute_id",Auth::user()->institute_id)->get();
	return View::make('admin.courses')->with("departments", $departments)->with("courses", $courses);
})->before("admin");
Route::post('/admin/courses', array('uses' => 'AdminController@add_course', 'as'=>'add_course'))->before("admin");
Route::get('/admin/courses/view/{id}', function($id)
{
	$course = Course::where("institute_id",Auth::user()->institute_id)->where('id',$id)->first();

	$courseoutcomes = CourseOutcome::where("course_id",$id)->get();
	$topics = Topic::where("course_id",$id)->orderBy('week_no')->get();

	$weeks = DB::table('topics')
	  		->where("course_id",$id)
            ->select(DB::raw('week_no as week_no'))
            ->groupBy('week_no')->orderBy('week_no', 'DESC')
            ->get();
   

	return View::make('admin.view_courses')->with("course", $course)->with("topics", $topics)->with("weeks", $weeks)->with('courseoutcomes', $courseoutcomes);
})->before("admin");

Route::post('/admin/courses/add/topic', array('uses' => 'AdminController@add_course_topic', 'as'=>'add_course_topic'))->before("admin");

Route::post('/admin/courses/add/outcome', array('uses' => 'AdminController@add_course_outcome', 'as'=>'add_course_outcome'))->before("admin");

Route::get('/admin/programs/courses/settings/{id}', function($id)
{
	$progcour = ProgCour::find($id);
	$programoutcomes = ProgramOutcome::where("program_id", $progcour->program_id)->get();
	$courseoutcomes = CourseOutcome::where("course_id", $progcour->course_id)->get();
	
	return View::make('admin.view_program_course_setting')->with("progcour", $progcour)->with("programoutcomes", $programoutcomes)->with("courseoutcomes", $courseoutcomes);
})->before("admin");
Route::post('/admin/programs/courses/settings', array('uses' => 'AdminController@save_program_course_settings', 'as'=>'add_course_outcome'))->before("admin");

Route::get('/curriculum/courses/{id}', function($id)
{
	$progcour = ProgCour::find($id);
	$course = Course::find($progcour->course_id);
	return View::make('view_course_curriculum')->with("course", $course)->with("progcour", $progcour);

})->before("admin");
