<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\Review;
use DB;
use Auth;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = Post::select('post.*', 'users.name', DB::raw('COUNT(postLike.id) as likes'))
            ->where('post.status', 'Active')
            ->join('users', 'post.user_id', 'users.id')
            ->leftJoin('postLike', 'post.id', 'postLike.post_id')
            ->groupBy('post.id')
            ->paginate(6);
        $myLike = array();
        if (Auth::id()) {
            $likeData = PostLike::select('post_id')->where('user_id', Auth::id())->get()->toArray();
            foreach ($likeData as $like) {
                $myLike[$like['post_id']] = $like['post_id'];
            }
        }
        return view('home', compact('data', 'myLike'));
    }

    public function details($postId)
    {
        $data = Post::findOrFail($postId);
        $review = Review::where('post_id',$postId)->get()->toArray();
        return view('post.details', compact('data','review'));
    }

    public function reviewSave(Request $request)
    {
        //--- Validation Section
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'comment' => 'required'
        ];

        $customs = [
            'name' => 'The Name is required.',
            'email' => 'The Email-Id is required.',
            'comment' => 'The Comment is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $customs);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator->getMessageBag()->toArray())
                ->withInput();

            // return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        //--- Logic Section
        $data = new Review();
        $input = $request->all();
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section
        return redirect()->to('post-details/'.$request->post_id)->with('success', 'Review Submit successfully!');
        //--- Redirect Section Ends
    }
}
