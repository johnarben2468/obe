<?php

class AdminController extends BaseController {



  public function edit_settings()
  {
    $rules = array(
      'institute_name'    => 'required|min:3|max:100',
      'mission'    => 'required|min:3|max:100',
      'vision'    => 'required|min:3|max:100',
    );
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      Session::put('msgfail', 'Invalid input.');
      return Redirect::back()
        ->withErrors($validator)
        ->withInput(); 
    } 
    else {
        $institute = Institute::find(Auth::user()->institute_id);
        $institute->name = strip_tags(Input::get('institute_name'));
        $institute->mission = strip_tags(Input::get('mission'));
        $institute->vision = strip_tags(Input::get('vision'));
        if (Input::hasFile('header_file'))
        {
          $file = Input::file('header_file');
          $file->move('public/upload', $file->getClientOriginalName());
          $institute->header_file = "../upload/" . $file->getClientOriginalName();
        }
        $institute->save();

        Session::put('msgsuccess', 'You have successfully editted your settings.');
        return Redirect::to('/login');

    }
  }
 public function add_department()
  {
    $rules = array(
      'name'    => 'required|min:3|max:100',
      'mission'    => 'required|min:3|max:100',
      'vision'    => 'required|min:3|max:100',
    );
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      Session::put('msgfail', 'Invalid input.');
      return Redirect::back()
        ->withErrors($validator)
        ->withInput(); 
    } 
    else {
        $department = new Department;
        $department->name = strip_tags(Input::get('name'));
        $department->mission = strip_tags(Input::get('mission'));
        $department->vision = strip_tags(Input::get('vision'));
        $department->institute_id = Auth::user()->institute_id;
        $department->save();

        Session::put('msgsuccess', 'You have successfully added a department.');
        return Redirect::back();

    }
  }
  public function add_program()
  {
    $rules = array(
      'title'    => 'required|min:3|max:100',
      'description'    => 'required|min:3|max:100',
    );
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      Session::put('msgfail', 'Invalid input.');
      return Redirect::back()
        ->withErrors($validator)
        ->withInput(); 
    } 
    else {
        $program = new Program;
        $program->title = strip_tags(Input::get('title'));
        $program->description = strip_tags(Input::get('description'));
        $program->institute_id = Auth::user()->institute_id;
        $program->save();

        Session::put('msgsuccess', 'You have successfully added a program.');
        return Redirect::back();

    }
  }
  public function add_course()
  {
    $rules = array(
      'title'    => 'required|min:3|max:100',
      'description'    => 'required|min:3|max:100',
      'objectives'    => 'required|min:3|max:100',
      'type'    => 'required|min:3|max:100',
      'department'    => 'required',
    );
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      Session::put('msgfail', 'Invalid input.');
      return Redirect::back()
        ->withErrors($validator)
        ->withInput(); 
    } 
    else {
        $course = new Course;
        $course->title = strip_tags(Input::get('title'));
        $course->description = strip_tags(Input::get('description'));
        $course->objectives = strip_tags(Input::get('objectives'));
        $course->institute_id = Auth::user()->institute_id;
        $course->department_id = strip_tags(Input::get('department'));
        $course->type = Input::get('type');
        if(Input::get('type')=="LEC")
        {
          $course->lec_code = Input::get('lec_code');
          $course->lec_units = Input::get('lec_units');
        }
        else if(Input::get('type')=="LAB")
        {
          $course->lab_code = Input::get('lab_code');
          $course->lab_units = Input::get('lab_units');
        }
        else if(Input::get('type')=="LEC/LAB")
        {
          $course->lec_code = Input::get('lec_code');
          $course->lec_units = Input::get('lec_units');
          $course->lab_code = Input::get('lab_code');
          $course->lab_units = Input::get('lab_units');
        }


        $course->save();

        Session::put('msgsuccess', 'You have successfully added a course.');
        return Redirect::back();

    }
  }
  public function add_program_course()
  {
    $rules = array(
      'courses'    => 'required',
      
    );
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      Session::put('msgfail', 'Invalid input.');
      return Redirect::back()
        ->withErrors($validator)
        ->withInput(); 
    } 
    else {
        $courses= Input::get('courses');
        foreach ($courses as $course) 
        {
        $progcour = new ProgCour;
        $progcour->program_id = strip_tags(Input::get('program_id'));
        $progcour->course_id = $course;
        $progcour->save();
        }

        Session::put('msgsuccess', 'You have successfully added a course to the program.');
        return Redirect::back();

    }
  }
  public function add_program_outcome()
  {
    $rules = array(
      'outcome'    => 'required|min:3|max:100',
      
    );
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      Session::put('msgfail', 'Invalid input.');
      return Redirect::back()
        ->withErrors($validator)
        ->withInput(); 
    } 
    else {
      
        $programoutcome = new ProgramOutcome;
        $programoutcome->program_id = strip_tags(Input::get('program_id'));
        $programoutcome->outcome= strip_tags(Input::get('outcome'));
        $programoutcome->save();
        

        Session::put('msgsuccess', 'You have successfully added a program outcome.');
        return Redirect::back();

    }
  }
  public function add_course_outcome()
  {
    $rules = array(
      'outcome'    => 'required|min:3|max:100',
      
    );
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      Session::put('msgfail', 'Invalid input.');
      return Redirect::back()
        ->withErrors($validator)
        ->withInput(); 
    } 
    else {
      
        $courseoutcome = new CourseOutcome;
        $courseoutcome->course_id = strip_tags(Input::get('course_id'));
        $courseoutcome->outcome= strip_tags(Input::get('outcome'));
        $courseoutcome->save();
        

        Session::put('msgsuccess', 'You have successfully added a course outcome.');
        return Redirect::back();

    }
  }
  public function add_course_topic()
  {
    $rules = array(
      'title'    => 'required|min:3|max:100',
      'week_no'    => 'required|numeric',
      'week_no'    => 'required',
      
    );
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      Session::put('msgfail', 'Invalid input.');
      return Redirect::back()
        ->withErrors($validator)
        ->withInput(); 
    } 
    else {
        
        $topic = new Topic;
        $topic->course_id = strip_tags(Input::get('course_id'));
        $topic->title= strip_tags(Input::get('title'));
        $topic->week_no= strip_tags(Input::get('week_no'));
        $topic->save();
        
        $clos= Input::get('clo');
        foreach ($clos as $clo) 
        {
        $clotopic = new CLOTopic;
        $clotopic->topic_id = $topic->id;
        $clotopic->course_outcome_id = $clo;
        $clotopic->save();
        }

        Session::put('msgsuccess', 'You have successfully added a course outcome.');
        return Redirect::back();

    }
  }
  public function save_program_course_settings()
  {

    $progcour = ProgCour::find(Input::get('prog_cour_id'));

    $programoutcomes = ProgramOutcome::where("program_id", $progcour->program_id)->get();
   
    $rules = array(
      
      
    );
    $validator = Validator::make(Input::all(), $rules);

    if ($validator->fails()) {
      Session::put('msgfail', 'Invalid input.');
      return Redirect::back()
        ->withErrors($validator)
        ->withInput(); 
    } 
    else {
        ProgCourOutcome::where("prog_cour_id", $progcour->program_id)->delete();

        foreach ($programoutcomes as $programoutcome) {
          $input = Input::get("outcomes_".$programoutcome->id);
          if($input==NULL)
            continue;
          $progcouroutcome = new ProgCourOutcome;
          $progcouroutcome->prog_cour_id = $progcour->id;
          $progcouroutcome->program_outcome_id= $programoutcome->id;
          $progcouroutcome->course_outcome_id= $input;
          $progcouroutcome->save();
          
        }
        Session::put('msgsuccess', 'You have successfully saved changes.');
        return Redirect::back();

    }
  }

}
