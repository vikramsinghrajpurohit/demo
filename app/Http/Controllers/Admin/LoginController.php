<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

use Validator;


class LoginController extends Controller
{
  public function __construct()
  {
    $this->middleware('guest:admin', ['except' => ['logout']]);
  }

  public function showLoginForm()
  {
    return view('admin.login');
  }

  public function login(Request $request)
  {
    //--- Validation Section
    $rules = [
      'email'   => 'required|email',
      'password' => 'required'
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
      return back()
        ->withErrors($validator->getMessageBag()->toArray())
        ->withInput();
      // return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
    }
    //--- Validation Section Ends

    // Attempt to log the user in
    if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
      // if successful, then redirect to their intended location
      return redirect('admin/admin-user');
    }

    // if unsuccessful, then redirect back to the login with the form data
    return back()->withErrors('Credentials Doesn\'t Match !');
  }

  public function logout()
  {
    Auth::guard('admin')->logout();
    return redirect('/');
  }
}
