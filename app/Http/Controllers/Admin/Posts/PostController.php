<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostNewsResource;
use Validator;
use Session;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'post_title' => ['required', 'max:200', 'min:10', 'unique:tbl_post', 'notspecial_spaces'],
            'post_content' => ['required', 'min:20'],
            'post_status' => ['required'],
        ],[
            'post_title.required' => 'Tiêu đề bài viết không dược để trống!',
            'post_title.max' => 'Tiêu đề bài viết không nhập quá 200 ký tự!',
            'post_title.min' => 'Tiêu đề bài viết phải có 10 ký tự trở lên!',
            'post_title.unique' => 'Tiêu đề bài viết đã tồn tại!',
            'post_title.notspecial_spaces' => 'Tiêu đề bài viết không được chứa ký tự đặc biệt!',

            'post_content.required' => 'Nội dung bài viết không dược để trống!',
            'post_content.min' => 'Nội dung bài viết phải có 20 ký tự trở lên!',

            'post_status.required' => 'Vui lòng chọn trạng thái cho bài viết này!'
        ]);

        $post = new Post();
        $post->post_title = $data['post_title'];
        $post->post_content = $data['post_content'];
        $post->post_status = $data['post_status'];
        $post->post_author = $request->post_author;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $post->post_date = now();
        $post->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($currentEntries)
    {
        return PostNewsResource::collection(Post::orderby('Post_id','DESC')->paginate($currentEntries));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }

    public function change(Request $request, $post)
    {
        $pst = Post::find($post);
        if($pst->post_status==0){
            $pst->post_status=1;
            $pst->save();
        }else{
            $pst->post_status=0;
            $pst->save();
        }
    }
}
