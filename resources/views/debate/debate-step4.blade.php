<!-- debate-step4.blade.php -->
<form method="post" action="{{ route('debate.step4') }}" enctype="multipart/form-data">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div>
        <label>Upload Image</label><br>
        <input type="file" name="image">
    </div>
    <div>
        <label>Tags</label><br>
        <input type="text" name="tags">
    </div>
    <div>
        <label>Background Info</label><br>
        <textarea name="backgroundinfo"></textarea>
    </div>
    <button type="submit">Submit</button>
</form>
