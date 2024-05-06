<!-- debate-step2.blade.php -->
<form method="post" action="{{ route('debate.step2') }}">
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
        <label>Title</label><br>
        <input type="text" name="title">
    </div>
    <div>
        <label>Thesis</label><br>
        <input type="text" name="thesis">
    </div>
    <button type="submit">Next</button>
</form>
