<?php

namespace App\Services;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CategoryMapper;
use App\Models\User;
use App\Util\Util;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class BlogService
{
    public static function createBlog($request, $validatedData)
    {
        try {
            DB::beginTransaction();
            $blog = new Blog();
            $blog->user_id = Auth::id();
            $blog->title = $request->input('title');
            $blog->body = $request->input('body');
            $categoryId = $request->input('category_id');
            //$blog->categories()->attach($validatedData['categories']);
            $blog->save();
            foreach ($validatedData['categories'] as $categoryId) {
                $categoryMapper = new CategoryMapper();
                $categoryMapper->blog_id = $blog->id;
                $categoryMapper->category_id = $categoryId;
                $categoryMapper->save();
            }
            try
            {
                DB::commit();
            }
            catch (\Exception $e)
            {
                DB::rollback();
            }
            //DB::commit();
            return Util::response($blog, '202');
        } catch (\Exception $e){
                return $e;
}


    }
    public static function editBlog($request){
        try {
            $blog = Blog::where([['id', $request->id], ['user_id', Auth::id()]])->first();

            if (!$blog) {
                return Util::response(['error' => 'Unauthorized'], 404);
            }

            $blog->title = $request->input('title');
            $blog->body = $request->input('body');
            $blog->save();

            return Util::response($blog, 200);
        } catch (\Exception $e) {
            return Util::response(['error' => $e->getMessage()], 500);
        }
    }

    public static function deleteBlog($request){
        try {
            $blog = Blog::where('id', $request->id)->first();

            if (!$blog) {
                return Util::response(['error' => 'Blog not found for the specified conditions'], 404);
            }

            if (Auth::id() !== $blog->user_id) {
                return Util::response(['error' => 'Unauthorized'], 403);
            }

            $blog->delete('cascade');

            return Util::response(['message' => 'Blog deleted successfully'], 200);
        } catch (\Exception $e) {
            return Util::response(['error' => $e->getMessage()], 500);
        }

    }

    public static function getBlogs($request)
    {
        try {
            $user = Auth::user();
            $blogs = $user->blogs()->where('title', 'like', '%'.$request->title.'%')->with(['categories:id,category,category-slug'])->paginate(5);
            return Util::response($blogs, 200);
        } catch (\Exception $e) {
            return Util::response(['error' => $e->getMessage()], 500);
        }


    }


}
