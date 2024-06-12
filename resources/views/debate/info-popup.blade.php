<div id="debate-info-popup" class="debate-info-popup-container">
    <div class="debate-info-popup-content">
        <div class="debate-popup-content__header" style="background-image: url('{{ asset('storage/' . $debate->image) }}');">
            <span class="info-popup-close-btn">&times;</span>
            <h1 class="debate-popup-content__header__title">{{ $debate->title }}</h1>
        </div>
        
        <div class="debate-popup-content__body">
            <div class="color-text-icon debate-card-stats">
                <div class="debate-card-stats__claims debate-card__stat">
                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"  height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M8 9h8"></path><path d="M8 13h6"></path>
                        <path d="M9 18h-3a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-3l-3 3l-3 -3z"></path>
                    </svg>
                    <p class="m-0 card-text">{{ $debateStats['total_claims'] }}</p>
                </div>
                <div class="debate-card-stats__contributions debate-card__stat">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M290.74 93.24l128.02 128.02-277.99 277.99-114.14 12.6C11.35 513.54-1.56 500.62.14 485.34l12.7-114.22 277.9-277.88zm207.2-19.06l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.76 18.75-49.16 0-67.91z"></path>
                    </svg>
                    <p class="m-0 card-text">{{ $debateStats['total_contributions'] }}</p>
                </div>
                <div class="debate-card-stats__votes debate-card__stat">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 640 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M608 320h-64v64h22.4c5.3 0 9.6 3.6 9.6 8v16c0 4.4-4.3 8-9.6 8H73.6c-5.3 0-9.6-3.6-9.6-8v-16c0-4.4 4.3-8 9.6-8H96v-64H32c-17.7 0-32 14.3-32 32v96c0 17.7 14.3 32 32 32h576c17.7 0 32-14.3 32-32v-96c0-17.7-14.3-32-32-32zm-96 64V64.3c0-17.9-14.5-32.3-32.3-32.3H160.4C142.5 32 128 46.5 128 64.3V384h384zM211.2 202l25.5-25.3c4.2-4.2 11-4.2 15.2.1l41.3 41.6 95.2-94.4c4.2-4.2 11-4.2 15.2.1l25.3 25.5c4.2 4.2 4.2 11-.1 15.2L300.5 292c-4.2 4.2-11 4.2-15.2-.1l-74.1-74.7c-4.3-4.2-4.2-11 0-15.2z"></path>
                    </svg>
                    <p class="m-0 card-text">{{ $debateStats['total_votes'] }}</p>
                </div>
                <div class="debate-card-stats__participants debate-card__stat">
                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                        <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                        <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                        <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                        <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                        <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                    </svg>
                    <p class="m-0 card-text">{{ $debateStats['total_participants'] }}</p>
                </div>
                <div class="debate-card-stats__views debate-card__stat">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 576 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                        <path d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"></path>
                    </svg>
                    <p class="m-0 card-text">{{ $debateStats['total_views'] }}</p>
                </div>
            </div>

            <div class="debate-popup-content__background-info">
                <h2 class="info-bg-info__title">Background Info</h2>
                @php
                    $backgroundInfo = $debate->backgroundinfo;
                    $isLongText = strlen($backgroundInfo) > 300;
                    $shortText = substr($backgroundInfo, 0, 300);
                @endphp
                <p class="info-bg-info__content">
                    @if ($isLongText)
                        <span class="short-bg-info-text">{{ $shortText }}...</span>
                        <span class="full-bg-info-text" style="display: none;">{{ $backgroundInfo }}</span>
                        <button id="show-more-bg-info">Show more</button>
                    @else
                        {{ $backgroundInfo }}
                    @endif
                </p>
            </div>

            <div class="debate-popup-content__tags">
                <h2 class="info-tags__title">Tags</h2>
                <ul class="info-tags__items-list">
                    @foreach($debatePopupData['tags'] as $tag)
                        <li class="info-tags__item">
                            <a href="{{ route('tags.single', ['tag' => $tag]) }}" target="_blank">
                                {{ $tag }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="debate-popup-content__participants">
                <h2 class="info-stats__title">Statistics</h2>
                <table class="debate-participants-table">
                    <thead class="debate-participants-table__header">
                        <tr class="participants-table__header-row">
                            <th>Participants</th>
                            <th>Claims</th>
                            <th>Contributions</th>
                            <th>Votes</th>
                        </tr>                        
                    </thead>
                    <tbody class="debate-participants-table__body">
                        @foreach($debatePopupData['participants'] as $index => $participantData)
                            <tr class="participants-table__list" @if($index >= 2) style="display: none;" @endif>
                                <td class="participants-table-item participants-table__name">{{ $participantData['user']->name }}</td>
                                <td class="participants-table-item participants-table__claims-count">{{ $participantData['claims_count'] }}</td>
                                <td class="participants-table-item participants-table__contri-count">{{ $participantData['total_contributions'] }}</td>
                                <td class="participants-table-item participants-table__votes-count">{{ $participantData['votes_count'] }}</td>
                            </tr>
                        @endforeach                        
                    </tbody>
                </table>
                @if(count($debatePopupData['participants']) > 2)
                    <button id="show-more-participants">Show more</button>
                @endif
            </div>

        </div>

        <button id="close-info-popup-btn" class="single-page__enter-btn">
            Enter
        </button>
    </div>
</div>

<style>
    .debate-info-popup-container {
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto; 
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4); 
    }

    .debate-info-popup-content {
        background-color: #fefefe;
        margin: 15% auto; 
        padding: 20px;
        border: 1px solid #888;
        width: 80%; 
    }

    .info-popup-close-btn {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .info-popup-close-btn:hover,
    .info-popup-close-btn:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<script>
    
    // Show more/less functionality
    document.addEventListener('DOMContentLoaded', function () {

        // Get the popup
        var popup = document.getElementById("debate-info-popup");

        // Get the <span> element that closes the popup
        var closeInfoPop = document.getElementsByClassName("info-popup-close-btn")[0];

        // When the user clicks on <span> (x), close the popup
        closeInfoPop.onclick = function() {
            popup.style.display = "none";
        }

        // Get the enter button that closes the popup
        var enterSinglePage = document.getElementById("close-info-popup-btn");

        // When the user clicks on enter close the popup
        enterSinglePage.onclick = function() {
            popup.style.display = "none";
        }

        // When the user clicks anywhere outside of the popup, close it
        window.onclick = function(event) {
            if (event.target == popup) {
                popup.style.display = "none";
            }
        }

        // Show the popup when the page loads
        window.onload = function() {
            popup.style.display = "block";
        }

        var showMoreBgInfoBtn = document.getElementById('show-more-bg-info');
        if (showMoreBgInfoBtn) {
            showMoreBgInfoBtn.addEventListener('click', function () {
                var shortText = document.querySelector('.short-bg-info-text');
                var fullText = document.querySelector('.full-bg-info-text');
                
                if (shortText.style.display === 'none') {
                    shortText.style.display = 'inline';
                    fullText.style.display = 'none';
                    showMoreBgInfoBtn.textContent = 'Show more';
                } else {
                    shortText.style.display = 'none';
                    fullText.style.display = 'inline';
                    showMoreBgInfoBtn.textContent = 'Show less';
                }
            });
        }

        // Show more participants functionality
        var showMoreParticipantsBtn = document.getElementById('show-more-participants');
        if (showMoreParticipantsBtn) {
            showMoreParticipantsBtn.addEventListener('click', function () {
                var hiddenRows = document.querySelectorAll('.participants-table__list[style*="display: none"]');
                hiddenRows.forEach(function(row) {
                    row.style.display = 'table-row';
                });
                showMoreParticipantsBtn.style.display = 'none';
            });
        }
    });

    // open infor popup when clicked on i btn in debate single page
    function openInfoPopup() {
        // Show the info popup
        var popup = document.getElementById("debate-info-popup");
        popup.style.display = "block";

        // Hide the "Enter" button
        var enterButton = document.getElementById("close-info-popup-btn");
        enterButton.style.display = "none";
    }
</script>
