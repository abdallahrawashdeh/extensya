<!-- resources/views/tasks/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Task Description</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="description">Task Description</label>
                            <input type="text" class="form-control" id="description" name="description" value="{{ $task->description }}">
                        </div>
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
