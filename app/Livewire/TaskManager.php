<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Task;
use App\Models\Project;
use App\Models\Remark;
use Illuminate\Support\Facades\Auth;

class TaskManager extends Component
{
    use WithPagination;

    public $projectId, $name, $status, $taskId;
    public $isEditing = false;

    public $remarkText, $selectedTaskId, $remarks = [];
    public $showAddRemarkModal = false;
    public $showViewRemarkModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function mount($projectId)
    {
        $this->projectId = $projectId;

        $project = Project::where('id', $projectId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$project) {
            abort(403, 'Unauthorized access to this project');
        }
    }

    public function addTask()
    {
        $this->validate();
        Task::create(['name' => $this->name, 'status' => 'pending', 'project_id' => $this->projectId]);
        $this->resetInput();
    }

    public function editTask($id)
    {
        $task = Task::where('project_id', $this->projectId)->findOrFail($id);
        $this->name = $task->name;
        $this->status = $task->status;
        $this->taskId = $id;
        $this->isEditing = true;
    }

    public function updateTask()
    {
        $this->validate();
        Task::where('id', $this->taskId)->where('project_id', $this->projectId)
            ->update(['name' => $this->name, 'status' => $this->status]);
        $this->resetInput();
    }

    public function deleteTask($id)
    {
        Task::where('id', $id)->where('project_id', $this->projectId)->delete();
    }

    private function resetInput()
    {
        $this->name = '';
        $this->status = 'pending';
        $this->taskId = null;
        $this->isEditing = false;
    }

    public function addRemark($taskId)
    {
        $this->selectedTaskId = $taskId;
        $this->remarkText = '';
        $this->showAddRemarkModal = true;
    }

    public function saveRemark()
    {
        $this->validate(['remarkText' => 'required|string|max:500']);
        Remark::create([
            'task_id' => $this->selectedTaskId,
            'remark' => $this->remarkText,
        ]);

        $this->showAddRemarkModal = false;
    }

    public function viewRemarks($taskId)
    {
        $this->selectedTaskId = $taskId;
        $this->remarks = Remark::where('task_id', $taskId)->orderBy('created_at', 'desc')->get();
        $this->showViewRemarkModal = true;
    }

    public function render()
    {
        
        return view('livewire.task-manager', [
            'tasks' => Task::where('project_id', $this->projectId)->paginate(5),
        ]);
    }
}
