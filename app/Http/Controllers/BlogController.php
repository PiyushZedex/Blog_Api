<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use App\Services\BlogService;
use App\Services\UserService;
use App\Util\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Lcobucci\JWT\Signer\Key;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class BlogController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['register','login', 'refresh', 'logout']]);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createBlog(Request $request)
    {
        $validatedData = $this->validate($request, [
            "title" => "required",
            "body" => "required",
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);



        return BlogService::createBlog($request, $validatedData);
    }

    public function editBlog(Request $request)
    {

        return BlogService::editBlog($request);


    }
    public function deleteBlog(Request $request)
    {
        return BlogService::deleteBlog($request);
    }

    public function getBlogs(Request $request)
    {
        return BlogService::getBlogs($request);
    }



}

