<?php

namespace Tests\Unit\Controllers\Admin\Posts;

use App\Models\Post;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PostTest extends TestCase
{
    /** @test */
    public function storePostSuccess()
    {
        $file = new UploadedFile(
            base_path('public\tests\img\img-unittest.png'),
            'img-unittest.png',
            null,
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/post-news/bai-viet', [
            'post_title' => 'Unit test Tao moi bai viet thanh cong 1',
            'post_content' => 'Unit test Tao moi bai viet thanh cong Unit test Tao moi bai viet thanh cong',
            'post_status' => '0',
            'post_type' => '0',
            'post_avatar' => $file,
            'post_author' => 'Trần Tiến Đạt',
            'post_date' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);

        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = Post::orderBy('post_id', 'DESC')->first();
            Storage::disk('postavatar')->delete($findToDel->post_avatar);
            $findToDel->delete();
        }
    }


    /** @test */
    public function storePostTitleEmptyError()
    {
        $file = new UploadedFile(
            base_path('public\tests\img\img-unittest.png'),
            'img-unittest.png',
            null,
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/post-news/bai-viet', [
            'post_title' => ' ',
            'post_content' => 'Unit test Tao moi bai viet thanh cong Unit test Tao moi bai viet thanh cong',
            'post_status' => '0',
            'post_type' => '0',
            'post_avatar' => $file,
            'post_author' => 'Trần Tiến Đạt',
            'post_date' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);

        $check = $response->assertStatus(422);
    }


    /** @test */
    public function storePostContentEmptyError()
    {
        $file = new UploadedFile(
            base_path('public\tests\img\img-unittest.png'),
            'img-unittest.png',
            null,
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/post-news/bai-viet', [
            'post_title' => 'Unit test Tao moi bai viet thanh cong 1',
            'post_content' => '',
            'post_status' => '0',
            'post_type' => '0',
            'post_avatar' => $file,
            'post_author' => 'Trần Tiến Đạt',
            'post_date' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);

        $check = $response->assertStatus(422);
    }


    /** @test */
    public function storePostStatusEmptyError()
    {
        $file = new UploadedFile(
            base_path('public\tests\img\img-unittest.png'),
            'img-unittest.png',
            null,
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/post-news/bai-viet', [
            'post_title' => 'Unit test Tao moi bai viet thanh cong 1',
            'post_content' => 'Unit test Tao moi bai viet thanh cong Unit test Tao moi bai viet thanh cong',
            'post_status' => ' ',
            'post_type' => '0',
            'post_avatar' => $file,
            'post_author' => 'Trần Tiến Đạt',
            'post_date' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);

        $check = $response->assertStatus(422);
    }


    /** @test */
    public function storePostTypeEmptyError()
    {
        $file = new UploadedFile(
            base_path('public\tests\img\img-unittest.png'),
            'img-unittest.png',
            null,
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/post-news/bai-viet', [
            'post_title' => 'Unit test Tao moi bai viet thanh cong 1',
            'post_content' => 'Unit test Tao moi bai viet thanh cong Unit test Tao moi bai viet thanh cong',
            'post_status' => '0',
            'post_type' => ' ',
            'post_avatar' => $file,
            'post_author' => 'Trần Tiến Đạt',
            'post_date' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);

        $check = $response->assertStatus(422);
    }


    /** @test */
    public function updatePostSuccess()
    {
        $file = new UploadedFile(
            base_path('public\tests\img\img-unittest.png'),
            'img-unittest.png',
            null,
            null,
            true
        );

        $this->json('POST', 'api/admin/post-news/bai-viet', [
            'post_title' => 'Tao moi bai viet unit test thanh cong',
            'post_content' => 'Tao moi bai viet unit test thanh congTao moi bai viet unit test thanh congTao moi bai viet unit test thanh congTao moi bai viet unit test thanh congTao moi bai viet unit test thanh congTao moi bai viet unit test thanh congTao moi bai viet unit test thanh cong',
            'post_status' => '0',
            'post_type' => '0',
            'post_avatar' => $file,
            'post_author' => 'Trần Tiến Đạt'
        ]);

        $findToDel = Post::orderBy('post_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/post-news/bai-viet/' . $findToDel->post_id, [
            'post_title' => 'Tao moi bai viet unit test thanh cong 2',
            'post_content' => 'Tao moi bai viet unit test thanh congTao moi bai viet unit test thanh congTao moi bai viet unit test thanh congTao moi bai viet unit test thanh congTao moi bai viet unit test thanh congTao moi bai viet unit test thanh congTao moi bai viet unit test thanh cong 2',
            'post_type' => '0',
            'post_author' => 'Trần Tiến Đạt'
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            Storage::disk('postavatar')->delete($findToDel->post_avatar);
            $findToDel->delete();
        }
    }


    /** @test */
    public function updateFilePostSuccess()
    {
        $file = new UploadedFile(
            base_path('public\tests\img\img-unittest.png'),
            'img-unittest.png',
            null,
            null,
            true
        );

        $file2 = new UploadedFile(
            base_path('public\tests\img\img-unittest.png'),
            'img-unittest.png',
            null,
            null,
            true
        );

        $this->json('POST', 'api/admin/post-news/bai-viet', [
            'post_title' => 'Unit test Tao moi bai viet thanh cong 1',
            'post_content' => 'Unit test Tao moi bai viet thanh cong Unit test Tao moi bai viet thanh cong',
            'post_status' => '0',
            'post_type' => '0',
            'post_avatar' => $file,
            'post_author' => 'Trần Tiến Đạt',
            'post_date' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);

        $findToDel = Post::orderBy('post_id', 'DESC')->first();

        $response = $this->json('POST', 'api/admin/post-news/bai-viet/update-file/' . $findToDel->post_id, [
            'post_title' => 'Unit test Tao moi bai viet thanh cong 1',
            'post_content' => 'Unit test Tao moi bai viet thanh cong 1 Unit test Tao moi bai viet thanh cong 1',
            'post_status' => '0',
            'post_type' => '0',
            'post_avatar' => $file2,
            'post_author' => 'Trần Tiến Đạt',
            'post_date' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);

        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel2 = Post::orderBy('post_id', 'DESC')->first();
            Storage::disk('postavatar')->delete($findToDel2->post_avatar);
            $findToDel->delete();
        }
    }


    /** @test */
    public function destroyPostSuccess()
    {
        $file = new UploadedFile(
            base_path('public\tests\img\img-unittest.png'),
            'img-unittest.png',
            null,
            null,
            true
        );

        $this->json('POST', 'api/admin/post-news/bai-viet', [
            'post_title' => 'Unit test Tao moi bai viet thanh cong 1',
            'post_content' => 'Unit test Tao moi bai viet thanh cong Unit test Tao moi bai viet thanh cong',
            'post_status' => '0',
            'post_type' => '0',
            'post_avatar' => $file,
            'post_author' => 'Trần Tiến Đạt',
            'post_date' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);

        $findToDel = Post::orderBy('post_id', 'DESC')->first();

        $response = $this->json('DELETE', 'api/admin/post-news/bai-viet/' . $findToDel->post_id);

        $check = $response->assertStatus(200);
    }


    /** @test */
    public function changePostSuccess()
    {
        $file = new UploadedFile(
            base_path('public\tests\img\img-unittest.png'),
            'img-unittest.png',
            null,
            null,
            true
        );

        $this->json('POST', 'api/admin/post-news/bai-viet', [
            'post_title' => 'Unit test Tao moi bai viet thanh cong 1',
            'post_content' => 'Unit test Tao moi bai viet thanh cong Unit test Tao moi bai viet thanh cong',
            'post_status' => '0',
            'post_type' => '0',
            'post_avatar' => $file,
            'post_author' => 'Trần Tiến Đạt',
            'post_date' => Carbon::now('Asia/Ho_Chi_Minh'),
        ]);

        $findToDel = Post::orderBy('post_id', 'DESC')->first();

        $response = $this->json('PATCH', 'api/admin/post-news/bai-viet/change/' . $findToDel->post_id);

        $check = $response->assertStatus(200);

        if ($check == true) {
            Storage::disk('postavatar')->delete($findToDel->post_avatar);
            $findToDel->delete();
        }
    }


    /** @test */
    public function destroyAllPostSuccess()
    {
        $file = new UploadedFile(
            base_path('public\tests\img\img-unittest.png'),
            'img-unittest.png',
            null,
            null,
            true
        );

        for ($i = 1; $i < 3; $i++) {
            $this->json('POST', 'api/admin/post-news/bai-viet', [
                'post_title' => 'Unit test Tao moi bai viet thanh cong' . $i,
                'post_content' => 'Unit test Tao moi bai viet thanh cong Unit test Tao moi bai viet thanh cong',
                'post_status' => '0',
                'post_type' => '0',
                'post_avatar' => $file,
                'post_author' => 'Trần Tiến Đạt',
                'post_date' => Carbon::now('Asia/Ho_Chi_Minh'),
            ]);
        }

        $post = array();
        $findToDel = Post::orderBy('post_id', 'DESC')->limit(2)->get();
        foreach ($findToDel as $key => $value) {
            array_push($post, $value->post_id);
            Storage::disk('postavatar')->delete($value->post_avatar);
        }
        $response = $this->json('POST', 'api/admin/post-news/bai-viet/destroyall', [
            'post' => $post,
        ]);
        $response->assertStatus(200);
    }
}
