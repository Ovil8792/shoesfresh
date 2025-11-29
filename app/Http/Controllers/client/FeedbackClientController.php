<?php

namespace App\Http\Controllers\client;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\ThankYouForContacting;

use Illuminate\Http\Request;

class FeedbackClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // cái này
        $feedbacks = Feedback::where('status', 1)->latest()->get();
        return view('client.feedback.index', compact('feedbacks'));
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
    public function submit(Request $request)
    {
        $user = session('user');

        if (!$user) {
            return redirect()->route('user.login')->with('error', 'Vui lòng đăng nhập để gửi phản hồi.');
        }

        $request->validate([
            'mess' => 'required|string|max:1000',
            'img'  => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,webm,ogg|max:100240',
        ]);

        $forbiddenWords = ['dm', 'đm', 'vcl', 'cc'];
        $messageText = strtolower($request->mess);
        $isViolated = false;

        foreach ($forbiddenWords as $word) {
        if (str_contains($messageText, $word)) {
            $isViolated = true;
            break;
            }
        }

        $mediaPath = null;
        if ($request->hasFile('img')) {
        $media = $request->file('img');
        $mediaPath = 'feedback_media/' . $media->hashName();
        $media->storeAs('public/feedback_media', $media->hashName());
    }

        Feedback::create([
            'user_id' => $user['id'],
            'name'    => $user['name'],
            'mess'    => $request->mess,
            'img'     => $mediaPath,
            'status'  => !$isViolated,
        ]);

        return redirect()->back()->with([
        'message' => $isViolated
        ? 'Phản hồi của bạn chứa từ ngữ không phù hợp và đang chờ kiểm duyệt.'
        : 'Phản hồi đã được gửi thành công!',
        'alert-type' => $isViolated ? 'danger' : 'success',
        ]);
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
