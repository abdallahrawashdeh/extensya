@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Task</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="description">Task Description</label>
                            <input type="text" class="form-control" id="description" name="description">
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <select class="form-control" id="state" name="state">
                                <option value="pending">Pending</option>
                                <option value="done">Done</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Add event listener to the state select input
    document.getElementById('state').addEventListener('change', function() {
        // Get the selected state value
        var state = this.value;

        // Send an AJAX request to update the task state
        var taskId = document.getElementById('taskId').value; // Assuming you have a hidden input field for the task ID
        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Get CSRF token
        fetch(`/tasks/${taskId}/update-state`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({
                state: state
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data.message); // Log success message
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    });
</script>
@endsection
