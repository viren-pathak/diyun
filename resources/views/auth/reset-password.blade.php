@extends('page.master')
@section('content')
<h2>Forgot Password</h2>
<form method="POST" action="{{ route('reset-password') }}">
    @csrf
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        @error('email')
            <span>{{ $message }}</span>
        @enderror
    </div>
    <button type="submit">Send Reset Password Email</button>
</form>
@endsection