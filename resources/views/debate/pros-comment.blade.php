<div class="comment-form-container" style="display:none;">
    <div class="comment-container__header">
        <button type="button" class="close-form-btn close-comment-container">&#10005;</button>
    </div>

    <div class="comment-container__content">
        <ul class="comments-list">
            @foreach($pro->comments as $comment)
                <li class="comment-box" data-comment-id="{{ $comment->id }}">
                    <div class="comment-identity-avatar">
                        <img src="{{ $comment->user->profile_picture }}" alt="Profile Picture" class="comment-profile-picture">
                    </div>
                    <div class="comment-box-body">
                        <div class="comment-box-content">
                            <p class="comment-content__text">{{ $comment->comment }}</p>
                        </div>
                        <div class="comment-meta-details">
                            <span class="comment-username">{{ $comment->user->username }}</span>
                            @if ($comment->created_at != $comment->updated_at)
                                <span class="comment-edited">Edited</span>
                            @endif
                            <span class="comment-time">{{ $comment->updated_at->diffForHumans() }}</span>
                            @if(auth()->check())
                                <div class="thanks-btn-container">
                                    <button class="thanks-btn">
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </button>
                                </div>
                            @endif
                            @if(auth()->check() && auth()->user()->id === $comment->user_id)
                                <button class="comment-menu">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    
    <div class="new-comment-editor">
        @if (auth()->check())
        <form action="{{ route('debate.comment', $pro->id) }}" method="POST" class="comment-form">
            @csrf
            <input type="text" class="new-comment-editor__input-field" name="comment" placeholder="Enter your comment" required>
            <button type="submit" class="new-comment-editor__submit-button">&#8594;</button>
        </form>
        @else
            <button class="comment-login-btn" onclick="openLoginForm()">Please log in to write comments</button>
        @endif
    </div>
</div>