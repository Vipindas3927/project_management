<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $totalProjects;
    public $taskCounts;

    public function mount()
    {
        $this->totalProjects = Project::where('user_id', Auth::id())->count();
        $this->taskCounts = Task::whereHas('project', function ($query) {
            $query->where('user_id', Auth::id());
        })->selectRaw('status, COUNT(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
