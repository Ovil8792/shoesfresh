<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        if ($keyword) {
        $feedbacks = Feedback::where('name', 'like', '%' . $keyword . '%')->get();
        } else {
        $feedbacks = Feedback::all();
        }
        return view('admin.feedback.index', compact('feedbacks', 'keyword'));
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
    // }

    /**
     * Display the specified resource.
     */
    public function show(feedback $feedback, string $id)
    {
        $feedback = Feedback::find($id);
        return view('admin.feedback.detail', compact('feedback'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id){
        $feedback = Feedback::find($id);
        return view('admin.feedback.update', compact('feedback'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Feedback $feedback, Request $request, string $id)
    {
        Feedback::find($id)->update([
           'status' => $request->status,
        ]);
        return redirect()->route('feedback.index')->with('success', 'Cập nhật thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        Feedback::destroy($id);
        return redirect()->route('feedback.index');
    }
}
