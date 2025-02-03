@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto mt-10 p-5 bg-white shadow rounded">
         <h2>Task Manager</h2>
         <div class="flex gap-2">
              <a href="{{ route("login") }}" class="bg-blue-400 p-4 text-white">Login </a>
              <a href="{{ route("register") }}" class="bg-blue-400 p-4 text-white">Register </a>
            </div>

    </div>
@endsection
