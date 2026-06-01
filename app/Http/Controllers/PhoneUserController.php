<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhoneUser;
use Illuminate\Support\Facades\Auth;

class PhoneUserController extends Controller
{
    public function index(Request $request)
    {
        $query = PhoneUser::query();
    
        // Search by Name or Phone
        if ($request->has('search') && $request->search != null) {
            $query->where('name', 'LIKE', "%{$request->search}%")
                  ->orWhere('phone', 'LIKE', "%{$request->search}%");
        }
    
        // Filter by Date
        if ($request->has('date') && $request->date != null) {
            $query->whereDate('created_at', $request->date)
                  ->orWhereDate('updated_at', $request->date);
        }
    
        $users = $query->latest()->paginate(10);
    
        return view('admin.phone_users.index', compact('users'));
    }


    public function create()
    {
        return view('admin.phone_users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|unique:phone_users|regex:/^\+?[0-9]{10,15}$/'
        ]);

        $user = PhoneUser::create([
            'name' => $request->name,
            'phone' => $request->phone
        ]);

        return redirect()->route('phone-users.index')->with('success', 'User registered successfully!');
    }

    public function edit($id)
    {
        $user = PhoneUser::findOrFail($id);
        return view('admin.phone_users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|unique:phone_users,phone,'.$id,
        ]);

        $user = PhoneUser::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('phone-users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        PhoneUser::findOrFail($id)->delete();
        return redirect()->route('phone-users.index')->with('success', 'User deleted successfully.');
    }

    public function registerOrLogin(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'required|regex:/^\+?[0-9]{10,15}$/'
        ]);

        // Check if user exists
        $user = PhoneUser::where('phone', $request->phone)->first();

        if (!$user) {
            $user = PhoneUser::create([
                'name' => $request->name,
                'phone' => $request->phone
            ]);
        }

        // Log the user in using the phoneUser guard
        Auth::guard('phoneUser')->login($user);

        // Redirect to dashboard
        return redirect()->route('phone-user.dashboard')->with('success', 'Successfully logged in.');
    }
    
    public function dashboard()
    {
        if (!Auth::guard('phoneUser')->check()) {
            return redirect('/register-user')->with('error', 'Please register or log in first.');
        }
    
        $user = Auth::guard('phoneUser')->user();
        return view('phone_user.dashboard', compact('user'));
    }

    public function profile()
    {
        $user = Auth::guard('phoneUser')->user();
        return view('phone_user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('phoneUser')->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:phone_users,phone,' . $user->id
        ]);

        $user->update($request->all());
        return back()->with('success', 'Profile updated successfully.');
    }

    public function likedAds()
    {
       $user = auth('phoneUser')->user();

        $likedListings = $user->likedListings;

        return view('phone_user.liked-listing', compact('likedListings'));
    }

    public function postedAds()
    {
        $user = Auth::guard('phoneUser')->user();
        $listings = $user->listings()->latest()->paginate(12);
        return view('phone_user.posted-ads', compact('listings'));
    }
    
    
    public function logout()
    {
        Auth::guard('phoneUser')->logout();
        return redirect('/register-user')->with('success', 'آپ کامیابی کے ساتھ لاگ آؤٹ ہوگئے ہیں۔');
    }
    
    // for api 
    public function apiLoginOrRegister(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^\+?[0-9]{10,15}$/',
            'name' => 'nullable|string|max:255',
        ]);
    
        $user = PhoneUser::firstOrCreate(
            ['phone' => $request->phone],
            ['name' => $request->name ?? '']
        );
    
        return response()->json([
            'message' => 'User registered or logged in successfully',
            'user' => $user
        ], 200);
    }

}
