<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        $jobs = Job::query()
            ->paginate();

        return JobResource::collection($jobs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:2', 'max:255'],
            'salary' => ['required'], 'string', 'min:2', 'max:255',
            'location' => ['required', 'string', 'min:2', 'max:255'],
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'url' => ['required', 'url'],
            'tags' => ['nullable', 'string', 'min:2', 'max:255'],
        ]);

        $validated['featured'] = $request->has('featured');

        try {
            DB::transaction(function () use ($validated, $request) {
                $job = Auth::user()->employer->jobs()->create(Arr::except($validated, 'tags'));

                if ($validated['tags'] ?? false) {
                    foreach (explode(',', $validated['tags']) as $tag) {
                        if (! empty(trim($tag))) {
                            $tag = Tag::firstOrCreate(['name' => strtolower(trim($tag))]);

                            $job->tags()->attach($tag);
                        }
                    }
                }

                return (new JobResource($job))
                    ->response($request)
                    ->setStatusCode(Response::HTTP_CREATED);
            });
        } catch (\Throwable $throwable) {
            return response()->json(['message' => $throwable->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        return JobResource::make($job);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:2', 'max:255'],
            'salary' => ['required', 'string', 'min:2', 'max:255'],
            'location' => ['required', 'string', 'min:2', 'max:255'],
            'schedule' => ['required', Rule::in(['Part Time', 'Full Time'])],
            'url' => ['required', 'url'],
            'tags' => ['nullable', 'string', 'min:2', 'max:255'],
        ]);

        $validated['featured'] = $request->has('featured');

        try {
            DB::transaction(function () use ($validated, $job) {
                $job->update(Arr::except($validated, 'tags'));

                if ($validated['tags'] ?? false) {
                    foreach (explode(',', $validated['tags']) as $tag) {
                        if (! empty(trim($tag))) {
                            $tag = Tag::firstOrCreate(['name' => strtolower(trim($tag))]);
                            $job->tags()->detach();
                            $job->tags()->attach($tag);
                        }
                    }
                }

                return JobResource::make($job);
            });
        } catch (\Throwable $throwable) {
            return response()->json(['message' => $throwable->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();

        return response()->json();
    }
}
