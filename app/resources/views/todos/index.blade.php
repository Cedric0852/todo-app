@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="font-semibold text-xl">My Todos</h1>
    <a href="{{ route('todos.create') }}" class="bg-gray-900 text-white rounded-md px-3 py-2">New</a>
</div>

@if ($todos->count() === 0)
    <p class="text-gray-600">No todos yet.</p>
@else
    <div class="grid gap-3">
        @foreach ($todos as $todo)
            <div class="border rounded-lg p-3 flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <strong>{{ $todo->title }}</strong>
                        @if($todo->is_completed)
                            <span class="text-xs text-emerald-700 border border-emerald-200 bg-emerald-50 rounded-full px-2 py-0.5">Completed</span>
                        @endif
                    </div>
                    <div class="text-gray-500">Due: {{ $todo->due_date->format('Y-m-d') }}</div>
                    @if($todo->description)
                        <div class="mt-1">{{ $todo->description }}</div>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    @unless($todo->is_completed)
                    <form method="POST" action="{{ route('todos.complete', $todo) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="border border-emerald-300 bg-emerald-50 text-emerald-800 rounded-md px-3 py-1.5">Mark Complete</button>
                    </form>
                    @endunless
                    <a href="{{ route('todos.edit',$todo) }}" class="border rounded-md px-3 py-1.5">Edit</a>
                    <form method="POST" action="{{ route('todos.destroy',$todo) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="border border-red-200 bg-red-50 text-red-800 rounded-md px-3 py-1.5">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-3">
        {{ $todos->links() }}
    </div>
@endif
@endsection
