<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        
        //hasrole
        if ($user->hasRole('administrator')) {
            return view('admin.dashboard');
        } elseif ($user->hasRole('lecturer')) {
            return view('lecturer.dashboard');
        } elseif ($user->hasRole('student')) {
            return view('student.dashboard');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function home()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
