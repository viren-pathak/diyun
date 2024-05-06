<!-- debate-step3.blade.php -->
<form method="post" action="{{ route('debate.step3') }}">
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
        <label>Is the Thesis Single?</label><br>
        <input type="radio" name="isSingleThesis" value="1" checked> Yes<br>
        <input type="radio" name="isSingleThesis" value="0"> No<br>
    </div>
    <button type="submit">Next</button>
</form>
