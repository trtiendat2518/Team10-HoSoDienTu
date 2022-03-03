<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $post_noti = Post::where('post_type', 0)->orderby('post_id', 'DESC')->limit(4)->get();
        $post_news = Post::where('post_type', 1)->orderby('post_id', 'DESC')->limit(6)->get();

        return view('student.pages.main')->with(compact('post_noti', 'post_news'));
    }
}
