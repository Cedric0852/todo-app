@extends('layouts.app')

@section('content')
<h1 class="font-semibold mb-4 text-xl">Register</h1>
@if ($errors->any())
    <div class="border border-red-200 bg-red-50 text-red-800 rounded-md px-3 py-2 mb-3">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('register') }}" class="grid gap-3 max-w-md">
    @csrf
    <label class="grid gap-1">
        <span>Name</span>
        <input name="name" type="text" value="{{ old('name') }}" required class="border border-gray-300 rounded-md px-3 py-2" />
    </label>
    <label class="grid gap-1">
        <span>Email</span>
        <input name="email" type="email" value="{{ old('email') }}" required class="border border-gray-300 rounded-md px-3 py-2" />
    </label>
    <label class="grid gap-1">
        <span>Password</span>
        <input name="password" type="password" required class="border border-gray-300 rounded-md px-3 py-2" />
    </label>
    <label class="grid gap-1">
        <span>Confirm Password</span>
        <input name="password_confirmation" type="password" required class="border border-gray-300 rounded-md px-3 py-2" />
    </label>
    <button type="submit" class="bg-gray-900 text-white rounded-md px-4 py-2">Create account</button>
</form>
<p class="mt-3 text-sm">Already have an account? <a class="underline" href="{{ route('login') }}">Login</a></p>
@endsection
