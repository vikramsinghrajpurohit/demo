<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** GET Request
    public function index()
    {
        $data = Post::with('user')->paginate(10);
        return view('admin.post.index', compact('data'));
    }

    //*** GET Request
    public function edit($id)
    {
        $data = Post::findOrFail($id);
        return view('admin.post.edit', compact('data'));
    }

    //*** POST Request
    public function update(Request $request)
    {
        //--- Validation Section
        $rules = [
            'image' => 'mimes:jpeg,jpg,png,svg',
            'title' => 'required',
            'details' => 'required'
        ];

        $customs = [
            'image.mimes' => 'Image Type is Invalid.',
            'title' => 'The Title is required.',
            'details' => 'The Title is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator->getMessageBag()->toArray())
                ->withInput();

        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = Post::find($request->id);

        $input = $request->all();
        
        if (request()->hasfile('image')) {
            if (file_exists(public_path() . '/posts/' . $data->image)) {
                unlink(public_path() . '/posts/' . $data->image);
            }
            
            $avatarName = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('posts'), $avatarName);
            $input['image'] = $avatarName;
        }
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section
        return redirect('admin/admin-post')->with('success', 'Post Update successfully!');;
        //--- Redirect Section Ends
    }

    public function delete($id)
    {
        $data = Post::findOrFail($id);
        //If fileName Doesn't Exist
        if ($data->image == null) {
            $data->delete();
            //--- Redirect Section
            return redirect('admin/admin-post')->with('success', 'Post Delete successfully!');
            //--- Redirect Section Ends
        }
        //If fileName Exist
        if (file_exists(public_path() . '/posts/' . $data->image)) {
            unlink(public_path() . '/posts/' . $data->image);
        }

        $data->delete();
        return redirect('admin/admin-post')->with('success', 'Post Delete successfully!');
    }
}
