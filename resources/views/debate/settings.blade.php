@extends('debate.master') 

@section('content')
    <div class="debate-settings-container container">
        <div class="debate-settings-header">
            <h1>Settings</h1>
            <button aria-label="Close" class="debate-settings__close" onclick="closeSettings()">
                <span class="icon-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                    </svg>
                </span>
            </button>
        </div>

        <div class="settings-tabs">
            <a href="{{ route('settings', ['slug' => $rootDebate->slug, 'tab' => 'general']) }}" class="tab-link @if(request()->query('tab') != 'sharing') active @endif">General</a>
            <a href="{{ route('settings', ['slug' => $rootDebate->slug, 'tab' => 'sharing']) }}" class="tab-link @if(request()->query('tab') == 'sharing') active @endif">Sharing</a>
        </div>

        <div class="tab-content">
            @if(request()->query('tab') != 'sharing')

                {{-- General Tab Content --}}
                    <div class="general-tab-content">
                        <div class="debate-details">
                            <form id="settings-form" method="post" action="{{ route('editRootDebate', ['slug' => $rootDebate->slug]) }}" enctype="multipart/form-data">
                                @csrf
                                {{-- Debate Image --}}
                                <div class="debate-details__image">
                                    <label for="image">Image</label><br>
                                    <img class="settings-debate-img" src="{{ asset('storage/' . $rootDebate->image) }}" alt="Debate Image"><br>
                                    <input type="file" id="image" name="image"><br>
                                </div>

                                {{-- Debate Title --}}
                                <div class="debate-details__title">
                                    <label for="title">Title</label><br>
                                    <input type="text" id="title" name="title" value="{{ $rootDebate->title }}"><br>
                                </div>

                                {{-- Debate Background Info --}}
                                <div class="debate-details__bg-info">
                                    <label for="backgroundinfo">Background Info</label><br>
                                    <textarea id="backgroundinfo" name="backgroundinfo">{{ $rootDebate->backgroundinfo }}</textarea><br>
                                </div>

                                {{-- Debate Background Tags --}}
                                <div class="debate-details__tags">
                                    <label for="tags">Tags (Separated by commas)</label><br>
                                    <input type="text" id="tags" name="tags" value="{{ implode(',', json_decode($rootDebate->tags)) }}"><br>
                                </div>

                                {{-- Debate Background Submit Button --}}
                                <div class="debate-details__submit-btn">
                                    <button type="submit">Save</button>
                                </div>

                                {{-- Debate Background Close Button --}}
                                <div class="debate-details__close-btn">
                                    <button type="button" aria-label="Close" class="debate-settings__editor-close" onclick="closeSettings()">
                                        Close
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

            @else

                {{-- Sharing Tab Content --}}
                <div class="sharing-tab-content">
                    <div class="debate-creation-label">
                        <p>This debate was published on {{ $rootDebate->created_at->format('M d, Y') }} by {{ $rootDebate->user->name }}</p>
                    </div>
                    <div class="debate-participants-container">
                        <h3 class="debate-participants-container_heading">Participants in Debate</h3>
                        <ul class="debate-participants_list">
                            @foreach($participants as $participant)
                                <li class="participant-details">
                                    <div class="participant-pers-info">
                                        <p class="debate-participant-name">{{ $participant->name }}</p>
                                        <div class="debate-participant-avatar">
                                            <img src="{{ $participant->profile_picture }}" alt="{{ $participant->name }}" >
                                        </div>
                                    </div>
                                    <div class="participant-debate-role">
                                        @foreach($participant->roles_for_debate as $role)
                                            {{ $role->role }}
                                        @endforeach
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            @endif
        </div>
    </div>
    <script>
        function closeSettings() {
            window.location.href = '{{ route("debate.single", ["slug" => $rootDebate->slug, "active" => $rootDebate->id]) }}';
        }

        // Add an event listener to the form to prevent default submission behavior
        document.getElementById('settings-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission behavior
            closeSettings(); // Call the closeSettings function
        });
    </script>
@endsection
