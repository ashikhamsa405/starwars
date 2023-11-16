<?php
//namespace
namespace App\Http\Controllers;
//dependencies
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * This controller class lewads the jwt authentication 
 */

class AuthController extends Controller
{

    //enable authorization except login and create accounts
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }


    //function to login exisiting account
    public function login(Request $request)
    {
        //validate email format and password
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);


        //filter email and password from request
        $credentials = $request->only('email', 'password');

        //fetch existing token 
        $token = Auth::attempt($credentials);
        //if failed send error message
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        //if success thenretrive authenticated user details
        $user = Auth::user();

        //send token  as response with user details
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

    //function to register new user
    public function register(Request $request){
        /**
         * request validations 
         * name is required and max characters limit set
         * email meets its format and should be unique
         * password must be 6 letters atleast
         */

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        //create user with hashing password

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //fetch token
        $token = Auth::login($user);
        //send response with user details and authorization details
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    //funtion to logout user
    public function logout()
    {
        //logout, remove token and send response
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    //function to regenerate new token by removing existing token
    public function refresh()
    {
        
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}
