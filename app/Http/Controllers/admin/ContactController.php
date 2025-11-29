<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        if ($keyword) {
        $contacts = Contact::where('name', 'like', '%' . $keyword . '%')->get();
        } else {
        $contacts = Contact::all();
        }
        return view('admin.contact.index', compact('contacts', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function store(Request $request)
    // {

    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function search(Request $request)
    // {
    //     $keyword = $request->input('keyword');

    //     $contact = Contact::where('name', 'like', '%' . $keyword . '%')->get();

    //     return view('admin.contact.search', compact('contacts', 'keyword'));
    // }

    /**
     * Display the specified resource.
     */
    public function show(contact $contact, string $id)
    {
        $contact = Contact::find($id);
        return view('admin.contact.detail', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contact = Contact::find($id);
        return view('admin.contact.update', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Contact $contact, Request $request, string $id)
    {
        Contact::find($id)->update([
           'status' => $request->status,
        ]);
        return redirect()->route('contact.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        Contact::destroy($id);
        return redirect()->route('contact.index');
    }
}
