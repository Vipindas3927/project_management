<div class="container mt-4">
    <div class="card">
        <div class="card-header">Task Management</div>
        <div class="card-body">
            <form wire:submit.prevent="{{ $isEditing ? 'updateTask' : 'addTask' }}">
                <div class="mb-3">
                    <label class="form-label">Task Name</label>
                    <input type="text" class="form-control" wire:model="name">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                @if($isEditing)
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" wire:model="status">
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                @endif
                <button type="submit" class="btn btn-{{ $isEditing ? 'warning' : 'primary' }}">
                    {{ $isEditing ? 'Update' : 'Add' }} Task
                </button>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Task Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>
                            <a href="#" wire:click.prevent="viewRemarks({{ $task->id }})">
                                {{ $task->name }} <i class="bx bx-comment"></i>
                            </a>
                        </td>
                        <td>
                            <span class="badge bg-{{ $task->status == 'pending' ? 'warning' : ($task->status == 'in_progress' ? 'info' : 'success') }}">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-warning" wire:click="editTask({{ $task->id }})"><i class="bx bx-edit"></i></button>
                            <button class="btn btn-sm btn-danger" wire:click="deleteTask({{ $task->id }})"><i class="bx bx-trash"></i></button>
                            <button class="btn btn-sm btn-info" wire:click="addRemark({{ $task->id }})">
                                <i class="bx bx-comment"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tasks->links() }}
    </div>

    @if($showAddRemarkModal)
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Remark</h5>
                        <button type="button" class="btn-close" wire:click="$set('showAddRemarkModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        <textarea class="form-control" wire:model="remarkText" placeholder="Enter remark..."></textarea>
                        @error('remarkText') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" wire:click="$set('showAddRemarkModal', false)">Close</button>
                        <button class="btn btn-primary" wire:click="saveRemark">Save Remark</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($showViewRemarkModal)
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Task Remarks</h5>
                        <button type="button" class="btn-close" wire:click="$set('showViewRemarkModal', false)"></button>
                    </div>
                    <div class="modal-body">
                        @forelse($remarks as $remark)
                            <p><strong>{{ $remark->created_at->format('d M Y h:i A') }}:</strong> {{ $remark->remark }}</p>
                        @empty
                            <p>No remarks added yet.</p>
                        @endforelse
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" wire:click="$set('showViewRemarkModal', false)">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
