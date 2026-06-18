<?php
namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Feedback::create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Thank you! Your feedback has been submitted successfully.');
    }

    public function indexAdmin()
    {
        $feedbacks = Feedback::with('user')->latest()->get(); 
        return view('admin.feedbacks.index', compact('feedbacks'));
    }
}
