<div class="single-sidebar-menu__item-myBookmarks-header">
    <button aria-label="Back" class="single-sidebar-menu__item-back">
        <span class="icon-svg">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
        </svg>
        </span>
    </button>
    <div class="sidebar-template__title">
        <h2 class="sidebar-menu-header__text">My Bookmarks</h2>
    </div>
    <button aria-label="Close" class="single-sidebar-menu__close">
        <span class="icon-svg">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg>
        </span>
    </button>
</div>

<div class="single-sidebar-menu__item-myBookmarks-content">

    @if ($bookmarkedDebates->isEmpty())
        <p>You have no bookmarks in this debate hierarchy.</p>
    @else
        <ul class="my-bookmarks-list-group">
            @foreach ($bookmarkedDebates as $bookmark)
                <li class="my-bookmarks-item">
                    <div class="mybookmarks-claim-card">
                         <div class="claim-text">
                            <a class="my-bookmarks-text" href="{{ url('debate/' . $bookmark->debate->slug . '?active=' . $bookmark->debate->id) }}">{{ $bookmark->debate->title }}</a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
