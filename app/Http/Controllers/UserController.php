<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    //The authenticate method attempts to log a user in and generates an authorization token if the user is found in the database. It throws an error if the user is not found or if an exception occurred while trying to find the user.
    public function authenticate(Request $request)//this actually login. 
    {
        $credentials = $request->only('email', 'password');//take the email and the password from the request, and put them into the $credentials.

        try {
            if (! $token = JWTAuth::attempt($credentials)) {//this creates toke: $token = JWTAuth::attempt($credentials). '!' means: if there is no token created

                return response()->json(['error' => 'invalid_credentials'], 400);//with return, we are ending this try immediatelly.
            }
        } catch (JWTException $e) {// if something went wrong whilst attempting to encode the token, then catch
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));//if everything is OK, return a token. The compact() here is same as the compact() what we use for returning blade views with data. So, that is why 'token' is actually $token. And the $token is created a few lines above this.
    }



    //The register method validates a user input and creates a user if the user credentials are validated. The user is then passed on to JWTAuth to generate an access token for the created user. This way, the user would not need to log in to get it.
    public function register(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);//durign a succesfull registration we are also making a token...

        return response()->json(compact('user','token'),201);//...and we are also returning to the user
    }


    //We have the getAuthenticatedUser method which returns the user object based on the authorization token that is passed.
    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }
}
