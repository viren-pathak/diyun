@extends('page.master')
@section('content')
<form method="POST" action="{{ route('complete-google-registration') }}">
    @csrf
    <label for="username">Choose a Username:</label>
    <input type="text" id="username" name="username" required>
    <button type="submit">Complete Registration</button>
</form>
@endsection