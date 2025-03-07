<?php 

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class AuthController extends Controller
{
 
    
    // Registration Method
    // public function register(Request $request){
    //     $registerUserData = $request->validate([
    //         'name'=>'required|string',
    //         'email'=>'required|string|email|unique:users',
    //         'password'=>'required|min:8',
    //         'c_password'=>'required|same:password',
    //         'role'=>'required'
    //     ]);
    //     $user = User::create([
    //         'name' => $registerUserData['name'],
    //         'email' => $registerUserData['email'],
    //         'password' => Hash::make($registerUserData['password']),
    //         'role' => $registerUserData['role'],
    //     ]);
    //     return response()->json([
    //         'message' => 'User registered successfully.',
    //         'user' => $user,
    //     ]);
    // }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
            ]);
        
            $credentials = request(['email','password']);
            if(!Auth::attempt($credentials))
            {
            return response()->json([
                'message' => 'Unauthorized'
            ],401);
            }
        
            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;
            //$token = "gdfhf";
        
            return response()->json([
            'message' => 'Login successful',
            'accessToken' =>$token,
            'token_type' => 'Bearer',
            ]);
    }
    
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
          "message"=>"logged out"
        ]);
    }
  
 }

