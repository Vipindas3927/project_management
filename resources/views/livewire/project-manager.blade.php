<div class="container mt-4">
    <div class="card">
        <div class="card-header">Project Management</div>
        <div class="card-body">
            <form wire:submit.prevent="{{ $isEditing ? 'updateProject' : 'addProject' }}">
                <div class="mb-3">
                    <label for="projectName" class="form-label">Project Name</label>
                    <input type="text" class="form-control" id="projectName" wire:model="name">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-{{ $isEditing ? 'warning' : 'primary' }}">
                    {{ $isEditing ? 'Update' : 'Add' }} Project
                </button>
                @if($isEditing)
                    <button type="button" class="btn btn-secondary" wire:click="resetInput">Cancel</button>
                @endif
            </form>
        </div>
    </div>

    <div class="mt-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>
                            <a href="{{ route('tasks', $project->id) }}" class="text-decoration-none">
                                {{ $project->name }} <i class="bx bx-link"></i>
                            </a>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" wire:click="editProject({{ $project->id }})"><i class="bx bx-edit"></i></button>
                            <button class="btn btn-sm btn-danger" wire:click="deleteProject({{ $project->id }})"
                                onclick="return confirm('Are you sure?')"><i class="bx bx-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $projects->links() }}
    </div>
</div>
