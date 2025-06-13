<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Display a listing of the inquiries.
     */
    public function index()
    {
        // Per ora ritorniamo una vista vuota
        return view('admin.inquiries.index');
    }

    /**
     * Show the form for creating a new inquiry.
     */
    public function create()
    {
        return view('admin.inquiries.create');
    }

    /**
     * Store a newly created inquiry in storage.
     */
    public function store(Request $request)
    {
        // Validazione e salvataggio da implementare
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry created successfully.');
    }

    /**
     * Display the specified inquiry.
     */
    public function show($id)
    {
        return view('admin.inquiries.show', ['inquiry_id' => $id]);
    }

    /**
     * Show the form for editing the specified inquiry.
     */
    public function edit($id)
    {
        return view('admin.inquiries.edit', ['inquiry_id' => $id]);
    }

    /**
     * Update the specified inquiry in storage.
     */
    public function update(Request $request, $id)
    {
        // Validazione e aggiornamento da implementare
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry updated successfully.');
    }

    /**
     * Remove the specified inquiry from storage.
     */
    public function destroy($id)
    {
        // Logica di eliminazione da implementare
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
}