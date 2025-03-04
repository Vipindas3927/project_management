<div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Projects</h5>
                        <p class="card-text h3">{{ $totalProjects }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Task Status Overview</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Pending</span> <span class="badge bg-warning">{{ $taskCounts['pending'] ?? 0 }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>In Progress</span> <span class="badge bg-info">{{ $taskCounts['in_progress'] ?? 0 }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Completed</span> <span class="badge bg-success">{{ $taskCounts['completed'] ?? 0 }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
