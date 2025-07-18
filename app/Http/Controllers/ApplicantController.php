<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Mail\JobApplied;
use Illuminate\Support\Facades\Mail;


class ApplicantController extends Controller
{
    //@desc store new job application
    //@route POST /jobs/{job}/apply 
    public function store(Request $request, Job $job): RedirectResponse {

        //check if user has already applied
        /** @disregard P1013 */
        $existingApplication = Applicant::where('job_id', $job->id)
        ->where('user_id', auth()->id())
        ->exists();

        if($existingApplication) {
            return redirect()->back()->with('error', 'You have already applied for this job');
        }

        //validate incoming data
        $validatedData = $request->validate([
            'full_name' => 'required|string',
            'phone_number' => 'string',
            'email' => 'required|string|email',
            'message' => 'string',
            'location' => 'string',
            'resume' => 'required|file|mimes:pdf|max:2048',

        ]);

        //handle resume upload
        if($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $validatedData['resume_path'] = $path;
        }

        //store the application
        $application = new Applicant($validatedData);
        $application->job_id = $job->id;
        
        /** @disregard P1013 */
        $application->user_id = auth()->id();
        $application->save();

        //send email to job owner
        //requires an owned email domain
        //Mail::to($job->user->email)->send(new JobApplied($application, $job));
        

        return redirect()->back()->with('success', 'Your application has been submitted.');
    }

    //@desc Delete Job Applicant
    //@route DELETE /applicants/{applicant} 

    public function destroy($id): RedirectResponse {

        $applicant = Applicant::findOrFail($id);
        $applicant->delete();
        
        return redirect()->route('dashboard')->with('success', 'Applicant has been deleted.');
        
    }
}