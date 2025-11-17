@extends('layouts.app')

@section('content')
<h1 class="font-semibold mb-4 text-xl">New Todo</h1>
@if ($errors->any())
    <div class="border border-red-200 bg-red-50 text-red-800 rounded-md px-3 py-2 mb-3">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('todos.store') }}" class="grid gap-3 max-w-2xl">
    @csrf
    <label class="grid gap-1">
        <span>Title</span>
        <input name="title" type="text" value="{{ old('title') }}" required class="border border-gray-300 rounded-md px-3 py-2" />
    </label>
    <label class="grid gap-1">
        <span>Due date</span>
        <input name="due_date" type="date" value="{{ old('due_date') }}" required class="border border-gray-300 rounded-md px-3 py-2" />
    </label>
    <label class="grid gap-1">
        <span>Description</span>
        <textarea name="description" rows="4" class="border border-gray-300 rounded-md px-3 py-2">{{ old('description') }}</textarea>
    </label>
    <div class="flex gap-2">
        <button type="submit" class="bg-gray-900 text-white rounded-md px-4 py-2">Save</button>
        <a href="{{ route('todos.index') }}" class="border rounded-md px-4 py-2">Cancel</a>
    </div>
</form>
@endsection
