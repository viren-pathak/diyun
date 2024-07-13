<div id="votesContainerCon{{ $con->id }}" class="votes-drafts-container" style="display:none;">
    @if($con->userVoted())
        <form action="{{ route('debate.deleteVote', $con->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">&#8634;</button>
        </form>
    @endif

    <canvas id="votesChartCon{{ $con->id }}" width="200" height="40"></canvas>
                                                        
    @if ($con->voting_allowed)
        <form action="{{ route('debate.vote', $con->id) }}" method="POST">
            @csrf
            <div class="vote-buttons">
                @for ($i = 0; $i <= 4; $i++)
                    <button type="submit" name="rating" value="{{ $i }}">{{ $i }}</button>
                @endfor
            </div>
        </form>
    @else
        <p>Enable voting for this debate to allow voting.</p>
    @endif
</div>