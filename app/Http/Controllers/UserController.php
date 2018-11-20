<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::with(['loans' => function($query) {
                                          $query->with(['payments']);
                                        }
                            ])->get();

        return response()->json($users);
    }

    
    public function store(Request $request)
    {
        $userEmail = User::where('email', '=' , $request->inputEmail)->first();

        if (empty($userEmail)) {
            $user = new User;
            $user->name = ucfirst($request->inputFName) . ' ' . ucfirst($request->inputLName);
            $user->email = $request->inputEmail;
            $user->password = bcrypt('12345');
            $user->save();

            return response()->json([
                'code' => '01',
                'status' => 'User Saved'
            ]);

        } else {

            return response()->json([
                'code' => '02',
                'status' => 'User Exist'
            ]);

        }
    }

    public function update(Request $request)
    {
        $userEmail = User::where('email', '=' , $request->inputEmail)->first();
        $user = User::find($userEmail->id);

        if (!empty($user)) {

            $user->name = ucfirst($request->inputFName) . ' ' . ucfirst($request->inputLName);
            $user->save();

            return response()->json([
                'code' => '01',
                'status' => 'Name Updated'
            ]);

        } else {

            return response()->json([
                'code' => '02',
                'status' => 'Invalid User'
            ]);

        }
        
        
    }

    public function destroy(Request $request)
    {
        $userEmail = User::where('email', '=' , $request->inputEmail)->first();
        $user = User::find($userEmail->id);

        if (!empty($user)) {

            $user->delete();

            return response()->json([
                'code' => '01',
                'status' => 'User Deleted'
            ]);

        } else {

            return response()->json([
                'code' => '02',
                'status' => 'Invalid User'
            ]);
            
        }
    }

}
