@extends('layouts.app')

@section('content')
<div class="container">
    @if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tasks</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($tasks as $task)
                        <li class="list-group-item">

                            <div><span class="form-group">To:</span> {{ $task->email }}</div>

                            <div>Description: {{ $task->description }}</div>

                            <div class="form-group">
                                <label for="state">State</label>
                                <select class="form-control" id="state" name="state">
                                    <option value="pending">Pending</option>
                                    <option value="done">Done</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </div> <!-- Display the state -->

                            <span class="float-right">


                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">View Task</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                                </form>
                            </span>
                        </li>
                        @endforeach
                    </ul>
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
