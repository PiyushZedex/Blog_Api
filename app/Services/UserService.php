<?php
namespace App\Services;
use App\Models\Blog;
use App\Models\User;
use App\Util\Util;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class   UserService
{
    public static function register($request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = new User();
            $user->firstname = $request->input('firstname');
            $user->lastname = $request->input('lastname');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            //$user->password = app('hash')->make($plainPassword);
            $user->mobile = $request->input('mobile');
            $user->address = $request->input('address');
            $user->save();
            //UserService::register($request->all());
            return Util::response($user, 201);

        } catch (\Exception $e){
            return Util::response('User Registration Failed', 409);
        }
    }
    public static function getUser(){
        try {
            $token = JWTAuth::getToken();
            JWTAuth::checkOrFail($token);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return Util::response('Token expired', 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return Util::response('Invalid token', 401);
        }
        try {
            return Auth::user();
        }catch(\Exception $e){
            Log::error($e);
            return $e->getMessage();
        }

    }
    public static function editUser($request){
        try {
            $user = User::where('id', $request->id)->first();

            if (!$user) {
                return Util::response(['error' => 'user not found for the specified id'], 404);
            }
            $user->firstname = $request->input('firstname');
            $user->lastname = $request->input('lastname');
            $user->email = $request->input('email');
            $user->password = $request->input('password');
            $user->mobile = $request->input('mobile');
            $user->address = $request->input('address');
            $user->save();
            return Util::response($user, 200);
        } catch (\Exception $e) {
            return Util::response(['error' => $e->getMessage()], 500);
        }
    }

}
