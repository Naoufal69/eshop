<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => env('APP_ENV') === 'local' ? $e->validator->errors() : 'Invalid input',
            ], 422);
        }



        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Génération du token d'authentification
        /** @var \App\Models\User $user */
        $token = $user->createToken('token')->plainTextToken;
        switch ($user->profile_id) {
            case 1:
                $profile_type = 'user';
                break;
            case 2:
                $profile_type = 'seller';
                break;
            case 3:
                $profile_type = 'admin';
                break;
            default:
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid profile type',
                ], 422);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'id' => $user->id,
            'name' => $user->name,
            'mail' => $user->email,
            'tokenCreatedAt' => date('Y-m-d H:i:s'),
            'profileType' => $profile_type,
            'token' => $token,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validation des données
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'nullable|string|max:15',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'profile_id' => 'nullable|integer|exists:profiles,id',
                'birthdate' => 'required|date',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => env('APP_ENV') === 'local' ? $e->validator->errors() : 'Invalid input',
            ], 422);
        }

        // Enregistrement de l'image
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            try {
                $file->move(public_path('images'), $filename);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to upload profile picture',
                    'error' => env('APP_ENV') === 'local' ? $e->getMessage() : 'An error occurred',
                ], 500);
            }
            $request->merge(['profile_picture' => $filename]);
        } else {
            // Si l'utilisateur n'a pas téléchargé d'image, on utilise une image par défaut
            $filename = 'default.png';
        }

        // Vérification de l'age de l'utilisateur
        $birthdate = \Carbon\Carbon::parse($request->birthdate);
        $age = $birthdate->diffInYears(now());
        if ($age < 18) {
            return response()->json([
                'status' => 'error',
                'message' => "L'utilisateur doit avoir au moins 18 ans",
            ], 422);
        }

        // Enregistrement de l'utilisateur
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->profile_picture = $filename;
            $user->profile_id = $request->profile_id;
            $user->birthdate = $request->birthdate;
            $user->save();
            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create user',
                'error' => env('APP_ENV') === 'local' ? $e->getMessage() : 'An error occurred',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'profile_picture' => asset('images/' . $user->profile_picture),
        ], 200);
    }

    public function passwordUpdate(Request $request, $id){
        // Vérification de l'authentification
        try {
            $request->validate([
                'verifyEmail' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
                'newPassword' => 'required|string|min:8|confirmed',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => env('APP_ENV') === 'local' ? $e->validator->errors() : 'Invalid input',
            ], 422);
        }

        // Vérification des identifiants de l'utilisateur
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        // Vérification de l'email
        if ($user->email !== $request->verifyEmail) {
            return response()->json([
                'status' => 'error',
                'message' => env('APP_ENV') === 'local' ? 'Invalid email' : 'Invalid credentials',
            ], 401);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' =>  env('APP_ENV') === 'local' ? 'Invalid password' : 'Invalid credentials',
            ], 401);
        }

        // Mise à jour du mot de passe
        try {
            $user->password = Hash::make($request->newPassword);
            $user->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Password updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => env('APP_ENV') === 'local' ? $e->getMessage() : 'An error occurred while updating the password',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // Vérification de l'authentification
        try {
            $request->validate([
                'verifyEmail' => 'required|string|email|max:255',
                'email' => 'string|email|max:255|unique:users,email,' . $id,
                'name' => 'string|max:255',
                'phone' => 'string|max:15',
                'birthDate' => 'date',
                'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'password' => 'required|string|min:8',

            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => env('APP_ENV') === 'local' ? $e->validator->errors() : 'Invalid input',
            ], 422);
        }

        // Vérification des identifiants de l'utilisateur
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        // Vérification de l'email
        if ($user->email !== $request->verifyEmail) {
            return response()->json([
                'status' => 'error',
                'message' => env('APP_ENV') === 'local' ? 'Invalid email' : 'Invalid credentials',
            ], 401);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' =>  env('APP_ENV') === 'local' ? 'Invalid password' : 'Invalid credentials',
            ], 401);
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }
        if ($request->has('birthDate')) {
            $birthdate = explode('-',$request->birthDate);
            $age = date('Y') - $birthdate[0];
        if ($age < 18) {
            $message = "L'utilisateur doit avoir au moins 18 ans";
            return response()->json([
                'status' => 'error',
                'message' => env('APP_ENV') === 'local' ? $message . ' - age : '. $age. ' - birth : ' . $birthdate[0] : $message,
            ], 422);
        }
            $user->birthdate = $request->birthDate;
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            try {
                $file->move(public_path('images'), $filename);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to upload profile picture',
                    'error' => env('APP_ENV') === 'local' ? $e->getMessage() : 'An error occurred',
                ], 500);
            }
            $user->profile_picture = $filename;
        }

        try {
            $user->save();
            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update user',
                'error' => env('APP_ENV') === 'local' ? $e->getMessage() : 'An error occurred',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
