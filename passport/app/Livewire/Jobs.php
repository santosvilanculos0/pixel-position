<?php

namespace App\Livewire;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Jobs extends Component
{
    use WithPagination;

    public function delete(Job $job)
    {
        $job->delete();
    }

    public function render()
    {
        $jobs = Auth::user()->jobs()
            ->with('employer')
            ->paginate(5);

        return view('livewire.jobs', ['jobs' => $jobs]);
    }
}
