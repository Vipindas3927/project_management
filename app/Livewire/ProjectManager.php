<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
class ProjectManager extends Component
{
    use WithPagination;
    public $name, $projectId;
    public $isEditing = false;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function addProject()
    {
        $this->validate();
        Project::create(['name' => $this->name, 'user_id' => Auth::id()]);
        $this->resetInput();
    }

    public function editProject($id)
    {
        $project = Project::where('user_id', Auth::id())->findOrFail($id);
        $this->name = $project->name;
        $this->projectId = $id;
        $this->isEditing = true;
    }

    public function updateProject()
    {
        $this->validate();
        Project::where('id', $this->projectId)->where('user_id', Auth::id())->update(['name' => $this->name]);
        $this->resetInput();
    }

    public function deleteProject($id)
    {
        Project::where('id', $id)->where('user_id', Auth::id())->delete();
    }

    private function resetInput()
    {
        $this->name = '';
        $this->projectId = null;
        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.project-manager', [
            'projects' => Project::where('user_id', Auth::id())->paginate(5)
        ]);
    }
}
