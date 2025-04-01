<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    // @desc Get all user bookmarks
    // @route GET /bookmarks
    public function index(): View {
        $user = Auth::user();

        /** @disregard P1013 */
        $bookmarks = $user->bookmarkedJobs()->orderBy('job_user_bookmarks.created_at', 'desc')->paginate(9);
        return view('jobs.bookmarks')->with('bookmarks', $bookmarks);
    }

    // @desc create new bookmarked job
    // @route POST /bookmarks{job}
    public function store(Job $job): RedirectResponse
    {
        $user = Auth::user();

        //check if job is already bookmarked
        /** @disregard P1013 */
        if($user->bookmarkedJobs()->where('job_id', $job->id)->exists()) {
            //if job is already booked notify the user
            return back()->with('error', 'This job is already bookmarked.');
        }

        //if job has not been bookmarked add to users bookmarks
        /** @disregard P1013 */
        $user->bookmarkedJobs()->attach($job->id);

        return back()->with('success', 'This job has been added to your bookmarks.');
    }

        // @desc remove  bookmarked job
    // @route DELETE /bookmarks{job}
    public function destroy(Job $job): RedirectResponse
    {
        $user = Auth::user();

        //check if job is not bookmarked
        /** @disregard P1013 */
        if(!$user->bookmarkedJobs()->where('job_id', $job->id)->exists()) {
            //if job is already booked notify the user
            return back()->with('error', 'This job is not bookmarked.');
        }

        //if job is bookmarked remove it from users bookmarks
        /** @disregard P1013 */
        $user->bookmarkedJobs()->detach($job->id);

        return back()->with('status', 'This job has been removed from your bookmarks.');
    }
}