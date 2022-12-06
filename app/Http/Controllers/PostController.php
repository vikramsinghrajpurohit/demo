<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostLike;
use Auth;
use Validator;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    //*** GET Request
    public function index()
    {
        $data = Post::where('user_id', Auth::id())->paginate(10);
        return view('post.index', compact('data'));
    }

    //*** GET Request
    public function create()
    {
        return view('post.create');
    }

    //*** POST Request
    public function save(Request $request)
    {
        //--- Validation Section
        if (isset($request->id)) {
            $rules = [
                'image' => 'mimes:jpeg,jpg,png,svg',
                'title' => 'required',
                'details' => 'required'
            ];
        } else {
            $rules = [
                'image' => 'required|mimes:jpeg,jpg,png,svg',
                'title' => 'required',
                'details' => 'required'
            ];
        }
        $customs = [
            'image.mimes' => 'Image Type is Invalid.',
            'title' => 'The Title is required.',
            'details' => 'The Title is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $customs);

        if ($validator->fails()) {
            return redirect('create-post')
                ->withErrors($validator->getMessageBag()->toArray())
                ->withInput();

        }
        //--- Validation Section Ends

        //--- Logic Section
        if (isset($request->id)) {
            $data = Post::find($request->id);
        } else {
            $data = new Post();
        }
        $input = $request->all();
        $input['user_id'] = Auth::id();
        if (request()->hasfile('image')) {

            if (isset($data->image) && file_exists(public_path() . '/posts/' . $data->image)) {
                unlink(public_path() . '/posts/' . $data->image);
            }

            $avatarName = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('posts'), $avatarName);
            $input['image'] = $avatarName;
        }
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section
        return redirect('my-post')->with('success', 'Post Save successfully!');;
        //--- Redirect Section Ends
    }

    //*** GET Request
    public function edit($id)
    {
        $data = Post::findOrFail($id);
        return view('post.create', compact('data'));
    }

    public function delete($id)
    {
        $data = Post::findOrFail($id);
        //If fileName Doesn't Exist
        if ($data->image == null) {
            $data->delete();
            //--- Redirect Section
            return redirect('my-post')->with('success', 'Post Delete successfully!');
            //--- Redirect Section Ends
        }
        //If fileName Exist
        if (file_exists(public_path() . '/posts/' . $data->image)) {
            unlink(public_path() . '/posts/' . $data->image);
        }

        $data->delete();
        return redirect('my-post')->with('success', 'Post Delete successfully!');
    }

    //*** GET Request
    public function like($postId)
    {
        $data = new PostLike();
        $input = array(
            'user_id' => Auth::id(),
            'post_id' => $postId
        );
        $data->fill($input)->save();
        return redirect('home')->with('success', 'Post Like Successfully!');
    }
    //*** GET Request
    public function unlike($postId)
    {
        PostLike::where('user_id', Auth::id())->where('post_id', $postId)->delete();
        return redirect('home')->with('success', 'Post Unlike Successfully!');
    }

   
}
