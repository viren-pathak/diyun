@extends('page.master')
@section('content')

<!-- @if(session('message'))
    <script>
        window.onload = function() {
            alert("{{ session('message') }}");
        };
    </script>
@endif -->

<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <!-- <span class="close">&times;</span> -->
        <p id="modalMessage">{{ session('message') }}</p>
    </div>
</div>


<div class="form-section  center-align ">
<h1>Reset </h1>
    <form method="post" action="{{ route('user_forget_2') }}">
        @csrf
        
        <div class="form-group form-floating mb-3">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
            <label for="floatingName">Email</label>
            @error('email')
                <span class="text-danger text-left">{{ $message }}</span>
            @enderror
        </div>
        <input type="hidden" name="g-recaptcha-response" id="response" />
        <button class="global-btn btn-primary " type="submit">Reset</button>

    </form>
    </div>

<script>
var message = "{{ session('message') }}";
if (message) {
    var modal = document.getElementById("myModal");
    var modalMessage = document.getElementById("modalMessage");
    modal.style.display = "block"; // Show the modal
    modalMessage.innerHTML = message; // Set the message content

    // Close the modal when the close button is clicked
    var closeButton = document.getElementsByClassName("close")[0];
    closeButton.onclick = function() {
        modal.style.display = "none"; // Hide the modal
    }

    // Close the modal when anywhere outside the modal content is clicked
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none"; // Hide the modal
        }
    }
}
</script>


@endsection