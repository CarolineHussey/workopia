<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Job;

class JobController extends Controller
{
    use AuthorizesRequests;
    //@desc show all job listings
    //@route GET /jobs
    public function index() : View
    {
        $jobs = Job::latest()->paginate(9);

        return view('jobs.index')->with('jobs', $jobs);
    }
    
    //@desc show create job form
    //@route GET /jobs/create
    public function create() : View
    {
        
        return view('jobs.create');
    }

    //@desc save job to database
    //@route POST /jobs
    public function store(Request $request): RedirectResponse

    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'nullable|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'nullable|boolean',
            'requirements' =>'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'county' => 'required|string',
            'postal_code' => 'required|string',
            'email' => 'required|string',
            'phone_number' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'company_website' => 'required|url',
        ]);

        /** @disregard P1013 */
        $validatedData['user_id'] = auth()->user()->id;
        
        //dd($request->file('company_logo'));
        if ($request->hasFile('company_logo')) {
            // Store the file and get path
            $path = $request->file('company_logo')->store('logos', 'public');
 
            // Add path to validated data
            $validatedData['company_logo'] = $path;
        }
        
        //submit to database
        Job::create($validatedData);

        return redirect('/jobs')->with('success', 'Job Listing successfully created!');
    }

    //@desc show a single job listing
    //@route GET /jobs/jobID
    public function show(Job $job): View
    {
        //
        return view('jobs.show')->with('job', $job);
    }

    //@desc show edit job form
    //@route GET /jobs/jobID/edit
    public function edit(Job $job): View
    {
        //check if user is authorised (prevents edit form from displaying if user is not authorised)
        $this->authorize('update', $job);

        return View('jobs.edit')->with('job', $job);
        
    }

    //@desc update job listing form
    //@route PUT /register
    public function update(Request $request, Job $job): string
    {
        //check if user is authorised (prevents delete if user is not authorised)
        $this->authorize('update', $job);
        
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'nullable|integer',
            'tags' => 'nullable|string',
            'job_type' => 'required|string',
            'remote' => 'nullable|boolean',
            'requirements' =>'nullable|string',
            'benefits' => 'nullable|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'county' => 'required|string',
            'postal_code' => 'required|string',
            'email' => 'required|string',
            'phone_number' => 'nullable|string',
            'company_name' => 'required|string',
            'company_description' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'company_website' => 'required|url',
        ]);
        
        if ($request->hasFile('company_logo')) {
 
            if (!empty($job->company_logo)) {
            //delete old logo
            Storage::delete('public/logos/' . basename($job->company_logo));
            }
 
            // Store the file and get path
            $path = $request->file('company_logo')->store('logos', 'public');
 
            // Add path to validated data
            $validatedData['company_logo'] = $path;
        }

            //submit to database
        $job->update($validatedData);

        return redirect('/jobs')->with('success', 'Job Listing successfully updated!');
    }

    //@desc delete a job listing
    //@route DELETE /jobs/jobID
    public function destroy(Job $job): RedirectResponse
    {
        //check if user is authorised (prevents delete if user is not authorised) (test via curl)
        $this->authorize('delete', $job);

        //if there is a logo, delete it
        if($job->company_logo) {
            Storage::delete('public/logos/' . $job->company_logo);
        }

        $job->delete();

        //check if request came from dashboard
        if(request()->query('from') == 'dashboard') {
            return redirect()->route('dashboard')->with('success', 'Job listing successfully deleted!');
        }

        return redirect('/jobs')->with('success', 'Job listing successfully deleted!');
    }
}