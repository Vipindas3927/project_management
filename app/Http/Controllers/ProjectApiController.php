<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\Remark;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProjectApiController extends Controller
{

    private function authorizeProjectAccess($projectId)
    {
        $user = Auth::user();
        $project = Project::where('id', $projectId)->where('user_id', $user->id)->first();
        return $project ? true : false;
    }

    public function listProjects()
    {
        try {
            return response()->json(Project::where('user_id', Auth::id())->get());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createProject(Request $request)
    {
        try {
            $request->validate(['name' => 'required|string|max:255']);
            $project = Project::create(['user_id' => Auth::id(), 'name' => $request->name]);
            return response()->json($project, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateProject(Request $request, $id)
    {
        try {
            if (!$this->authorizeProjectAccess($id)) {
                return response()->json(['error' => 'Unauthorized access to project'], 403);
            }
            $project = Project::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
            $request->validate(['name' => 'required|string|max:255']);
            $project->update(['name' => $request->name]);
            return response()->json($project);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteProject($id)
    {
        try {
            if (!$this->authorizeProjectAccess($id)) {
                return response()->json(['error' => 'Unauthorized access to project'], 403);
            }
            Project::where('id', $id)->where('user_id', Auth::id())->delete();
            return response()->json(['message' => 'Project deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listTasks($projectId)
    {
        try {
            if (!$this->authorizeProjectAccess($projectId)) {
                return response()->json(['error' => 'Unauthorized access to project'], 403);
            }
            $tasks = Task::where('project_id', $projectId)->get();
            return response()->json($tasks);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createTask(Request $request, $projectId)
    {
        try {
            if (!$this->authorizeProjectAccess($projectId)) {
                return response()->json(['error' => 'Unauthorized access to project'], 403);
            }
            $request->validate(['name' => 'required|string|max:255', 'status' => 'in:pending,in_progress,completed']);
            $task = Task::create([
                'project_id' => $projectId,
                'name' => $request->name,
                'status' => $request->status ?? 'pending'
            ]);
            return response()->json($task, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateTask(Request $request, $taskId)
    {
        try {
            $task = Task::find($taskId);
            if (!$task) {
                return response()->json(['error' => 'Task not found'], 404);
            }
            $request->validate(['name' => 'required|string|max:255', 'status' => 'in:pending,in_progress,completed']);
           
            if (!$this->authorizeProjectAccess($task->project_id)) {
                return response()->json(['error' => 'Unauthorized access to project'], 403);
            }
            $task->update([
                'name' => $request->name,
                'status' => $request->status
            ]);
            return response()->json($task);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteTask($taskId)
    {
        try {
            $task = Task::find($taskId);
            if (!$task) {
                return response()->json(['error' => 'Task not found'], 404);
            }
            if (!$this->authorizeProjectAccess($task->project_id)) {
                return response()->json(['error' => 'Unauthorized access to project'], 403);
            }
            $task->delete();
            return response()->json(['message' => 'Task deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listRemarks($taskId)
    {
        try {
            $task = Task::where('id', $taskId)
                ->whereHas('project', fn ($q) => $q->where('user_id', Auth::id()))
                ->firstOrFail();
            return response()->json($task->remarks);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addRemark(Request $request, $taskId)
    {
        try {
            $task = Task::where('id', $taskId)
                ->whereHas('project', fn ($q) => $q->where('user_id', Auth::id()))
                ->firstOrFail();
            $request->validate(['remark' => 'required|string']);
            $remark = Remark::create(['task_id' => $task->id, 'remark' => $request->remark]);
            return response()->json($remark, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
