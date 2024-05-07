<form id="multistep-form" method="post" action="{{ route('debate.finalSubmit') }}" enctype="multipart/form-data">
    @csrf

    <!-- Step 1 -->
    <div class="step" id="step1">
        <h2>Private or public</h2><br>
        <input type="radio" name="isDebatePublic" value="0"> Private<br>
        <input type="radio" name="isDebatePublic" value="1"> Public<br>
        <button type="button" onclick="nextStep()">Next</button>
    </div>

    <!-- Step 2 -->
    <div class="step" id="step2" style="display: none;">
      <h2>Name / Thesis</h2>
        <label>Title</label><br>
        <input type="text" name="title"><br>
        <label>Thesis</label><br>
        <input type="text" name="thesis"><br>
        <button type="button" onclick="prevStep()">Previous</button>
        <button type="button" onclick="nextStep()">Next</button>
    </div>

    <!-- Step 3 -->
    <div class="step" id="step3" style="display: none;">
        <h2>Type</h2><br>
        <input type="radio" name="isSingleThesis" value="1"> Single Thesis<br>
        <input type="radio" name="isSingleThesis" value="0"> Multiple Theses<br>
        <button type="button" onclick="prevStep()">Previous</button>
        <button type="button" onclick="nextStep()">Next</button>
    </div>

    <!-- Step 4 -->
    <div class="step" id="step4" style="display: none;">
    @if ($errors->any())
                            <div class="alert alert-danger mt-3">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
        <h2>Image / Tags / Background Info</h2><br>
        <label>Image</label><br>
        <input type="file" name="image"><br>
        <label>Tags</label><br>
        <input type="text" name="tags"><br>
        <label>Background Info (Optional)</label><br>
        <textarea name="backgroundinfo"></textarea><br>
        <button type="button" onclick="prevStep()">Previous</button>
        <button type="submit">Submit</button>
    </div>
</form>



<script>
function nextStep() {
    var currentStep = document.querySelector('.step:not([style*="none"])');
    var nextStep = currentStep.nextElementSibling;
    currentStep.style.display = 'none';
    nextStep.style.display = 'block';
}

function prevStep() {
    var currentStep = document.querySelector('.step:not([style*="none"])');
    var prevStep = currentStep.previousElementSibling;
    currentStep.style.display = 'none';
    prevStep.style.display = 'block';
}


</script>