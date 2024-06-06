@extends('page.master')

@section('content')

<div class="form-section  center-align">
    <h2>Update Password</h2>
    <form method="post" action="{{ route('update_password', ['token' => $token]) }}">
        @csrf
        
        <div class="form-group form-floating mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" required >
            <label for="floatingName">Password</label>
            @error('password')
                <span class="text-danger text-left">{{ $message }}</span>
            @enderror
        </div>

        <button class="global-btn btn-primary" type="submit">Update</button>
    </form>
</div>

@endsection