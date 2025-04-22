@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Workouts</h1>
    <a href="{{ route('workouts.create') }}" class="btn btn-primary mb-3">Add New Workout</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Workout Name</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($workouts as $workout)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $workout->name }}</td>
                <td>{{ $workout->date }}</td>
                <td>
                    <a href="{{ route('workouts.show', $workout->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('workouts.edit', $workout->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('workouts.destroy', $workout->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection