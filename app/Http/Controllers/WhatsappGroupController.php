<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhatsappGroup;
use App\Http\Requests\WhatsappGroupRequest;
use Illuminate\Support\Facades\Auth;

class WhatsappGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = WhatsappGroup::all();
        return view('whatsapp.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', WhatsappGroup::class);
        return view('whatsapp.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WhatsappGroupRequest $request)
    {
        $this->authorize('create', WhatsappGroup::class);
        $data = $request->validated();
        $data['created_by'] = Auth::id();
        $group = WhatsappGroup::create($data);
        return redirect()->route('whatsapp_groups.show', $group->id)->with('success', 'Grup eklendi.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $group = WhatsappGroup::findOrFail($id);
        return view('whatsapp.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $group = WhatsappGroup::findOrFail($id);
        $this->authorize('update', $group);
        return view('whatsapp.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WhatsappGroupRequest $request, $id)
    {
        $group = WhatsappGroup::findOrFail($id);
        $this->authorize('update', $group);
        $group->update($request->validated());
        return redirect()->route('whatsapp_groups.show', $group->id)->with('success', 'Grup güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $group = WhatsappGroup::findOrFail($id);
        $this->authorize('delete', $group);
        $group->delete();
        return redirect()->route('whatsapp_groups.index')->with('success', 'Grup silindi.');
    }
}
