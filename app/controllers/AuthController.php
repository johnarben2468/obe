<?php

class AuthController extends BaseController {


	public function logout()
	{
		Auth::logout();
		Session::flush();
		return Redirect::to('/')->with('msgsuccess','You have logged out.');	
	}

	
  public function login()
  {
    $userdata = array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
        );

    if (Auth::Attempt($userdata)) 
    {
      $checkUser = User::find(Auth::id());
     
      return Redirect::to('/')->with( 'msgsuccess' , 'You have logged in successfully.');

    }

    return Redirect::back()->withInput(Input::except('password'))->with( 'msgfail', 'Invalid credentials.');
  }

	

  public function register()
  {
    $rules = array(
      'username'    => 'required|alphaNum|min:3|max:20|unique:users', 
      'password'    => 'required|min:3|max:20|confirmed',
      'password_confirmation'    => 'required',
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
        $institute = new Institute;
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

        $user = new User;
        $user->username = strip_tags(Input::get('username'));
        $user->password = strip_tags(Hash::make(Input::get('password')));
        $user->user_type = "admin";
        $user->institute_id = $institute->id;
        $user->save();

        

        Session::put('msgsuccess', 'You have successfully registered.');
        return Redirect::to('/login');

    }
  }

}
