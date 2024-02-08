<?php
namespace App\Http\Controllers;

use App\Models\Blog;
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

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['register','login', 'refresh', 'logout']]);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */

    public function register(Request $request){
        $validated = $this->validate($request,[
            'firstname' => 'bail|required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'mobile' => 'required|unique:users|numeric',
            'address' => 'required',
        ]);
        return UserService::register($request);
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only(['email', 'password']);

        if(! $token = Auth::attempt($credentials)) {
            return Util::response('Unauthorized', 401);
        }

        return $this->respondWithToken($token);
    }

        public function getUser(Request $request)
        {
            return UserService::getUser();
        }

        public function editUser(Request $request){
            return UserService::editUser($request);
        }



}

