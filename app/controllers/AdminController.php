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
}
