<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('view', $user);
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $data = $request->validated();
        $user->update($data);
        return redirect()->route('profile.show', $user->id)->with('success', 'Profil güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
