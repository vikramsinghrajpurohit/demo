<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** GET Request
    public function index()
    {
        $data = User::paginate(10);
        return view('admin.user.index', compact('data'));
    }

    //*** GET Request
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('admin.user.edit', compact('data'));
    }

    //*** POST Request
    public function update(Request $request)
    {
        $id = $request->id;
        //--- Validation Section
        $rules = [
            'avatar' => 'mimes:jpeg,jpg,png,svg',
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'username' => 'required|unique:users,username,' . $id
        ];

        $customs = [
            'avatar.mimes' => 'Image Type is Invalid.',
            'name' => 'The Name is required.',
            'email' => 'The Email-Id is required.',
            'username' => 'The Username is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator->getMessageBag()->toArray())
                ->withInput();

        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = User::find($request->id);

        $input = $request->all();

        if(request()->hasfile('avatar')){
            
            if (file_exists(public_path() . '/avatars/' . $data->avatar)) {
                unlink(public_path() . '/avatars/' . $data->avatar);
            }
    
            $avatarName = time().'.'.request()->avatar->getClientOriginalExtension();
            request()->avatar->move(public_path('avatars'), $avatarName);
            $input['avatar'] = $avatarName;
        }

        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section
        return redirect('admin/admin-user')->with('success', 'User Update successfully!');;
        //--- Redirect Section Ends
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);
        //If fileName Doesn't Exist
        if ($data->avatar == null) {
            $data->delete();
            //--- Redirect Section
            return redirect('admin/admin-user')->with('success', 'User Delete successfully!');
            //--- Redirect Section Ends
        }
        //If fileName Exist
        if (file_exists(public_path() . '/avatars/' . $data->avatar)) {
            unlink(public_path() . '/avatars/' . $data->avatar);
        }

        $data->delete();
        return redirect('admin/admin-user')->with('success', 'User Delete successfully!');
    }
}
