<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chirp;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalChirps = Chirp::count();
        $recentUsers = User::latest()->take(5)->get();
        $recentChirps = Chirp::with('user')->latest()->take(5)->get();

        return view('admin.index', compact('totalUsers', 'totalChirps', 'recentUsers', 'recentChirps'));
    }

    public function users()
    {
        $users = User::withCount('chirps')->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function destroyUser(User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.users')->with('error', 'Cannot delete admin users.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User and their chirps deleted successfully.');
    }

    public function chirps()
    {
        $chirps = Chirp::with('user')->latest()->paginate(15);
        return view('admin.chirps', compact('chirps'));
    }

    public function editChirp(Chirp $chirp)
    {
        return view('admin.edit-chirp', compact('chirp'));
    }

    public function updateChirp(Request $request, Chirp $chirp)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp->update($validated);

        return redirect()->route('admin.chirps')->with('success', 'Chirp updated successfully.');
    }

    public function destroyChirp(Chirp $chirp)
    {
        $chirp->delete();
        return redirect()->route('admin.chirps')->with('success', 'Chirp deleted successfully.');
    }
}