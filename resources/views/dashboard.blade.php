@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto gap-2 mt-10 md:flex justify-between p-5 bg-white shadow rounded">
        <div class="shadow w-full p-6" >
            <h2 class="text-xl font-bold mb-4">Total Teams</h2>

            @foreach ($teams as $team)
                  <p>{{ $team->name }}</p>
            @endforeach
            <h3><a href="{{ route('teams.show',['id'=>$team->id]) }}" target="_blank" class="bg-blue-300 p-4 mt-5 block rounded">Assign Users to Team</a></h3>
            <h3><a href="{{ route('teams.create') }}" class="bg-blue-300 p-4 mt-5 block rounded" target="_blank">Create New Team</a>  </h3>
            <h3 ><a href="{{ route('tasks.updateTasks') }}" class="bg-blue-300 p-4 mt-5 block rounded" target="_blank"> Update Tasks</a></h3>
        </div>

        <users-teams></users-teams>
        <task-form></task-form>
        <task-list></task-list>
    </div>
@endsection
