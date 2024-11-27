<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::latest()->with(['employer', 'tags'])->get()->groupBy('featured');

        return view('jobs.index', [
            'jobs' => $jobs[0],
            'featuredJobs' => $jobs[1],
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'salary' => ['required'],
            'location' => ['required'],
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'url' => ['required', 'url'],
            'tags' => ['nullable'],
        ]);

        $validated['featured'] = $request->has('featured');

        try {
            DB::transaction(function () use ($validated) {
                $job = Auth::user()->employer->jobs()->create(Arr::except($validated, 'tags'));

                if ($validated['tags'] ?? false) {
                    foreach (explode(',', $validated['tags']) as $tag) {
                        if (! empty(trim($tag))) {
                            $tag = Tag::firstOrCreate(['name' => strtolower(trim($tag))]);

                            $job->tags()->attach($tag);
                        }
                    }
                }
            });
        } catch (\Throwable $throwable) {
            return back()
                ->withInput()
                ->with('status', $throwable->getMessage());
        }

        return redirect('/');
    }

    public function edit(Job $job)
    {
        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required'],
            'salary' => ['required'],
            'location' => ['required'],
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'url' => ['required', 'url'],
            'tags' => ['nullable'],
        ]);

        $validated['featured'] = $request->has('featured');

        try {
            DB::transaction(function () use ($validated) {
                $job = Auth::user()->employer->jobs()->create(Arr::except($validated, 'tags'));

                if ($validated['tags'] ?? false) {
                    foreach (explode(',', $validated['tags']) as $tag) {
                        if (! empty(trim($tag))) {
                            $tag = Tag::firstOrCreate(['name' => strtolower(trim($tag))]);
                            $job->tags()->detach();
                            $job->tags()->attach($tag);
                        }
                    }
                }
            });
        } catch (\Throwable $throwable) {
            return back()
                ->withInput()
                ->with('status', $throwable->getMessage());
        }

        return to_route('jobs.index');
    }
}
