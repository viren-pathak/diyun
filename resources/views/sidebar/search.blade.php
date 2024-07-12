<div class="single-sidebar-menu__item-search-header">
    <button aria-label="Back" class="single-sidebar-menu__item-back">
        <span class="icon-svg">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
        </svg>
        </span>
    </button>
    <div class="sidebar-template__title">
        <h2 class="sidebar-menu-header__text">Search</h2>
    </div>
    <button aria-label="Close" class="single-sidebar-menu__close">
        <span class="icon-svg">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg>
        </span>
    </button>
</div>

<div class="single-sidebar-menu__item-search-content">
    <div class="sidebar-search-form__input-field">
        <input type="search" name="query" placeholder="Enter search text">
        <i class="fa fa-search" aria-hidden="true"></i>
    </div>

    <div class="sidebar-search-form__controls">
        <select name="search" id="sidebar-search-type_dropdown">
            <option value="claims" selected>Search claims</option>
            <option value="comments">Search comments</option>
            <option value="suggested-claims">Search suggested claims</option>
        </select>

        <select name="search" id="sidebar-search-scope_dropdown">
            <option value="this-discussion" selected>In this discussion</option>
            <option value="public-discussion">In public discussions</option>
            <option value="private-discussion">In private discussions</option>
            <option value="all-discussion">In all discussions</option>
        </select>

        <div id="sidebar-search-checkbox">
            <label for="search-checkbox">
                <input type="checkbox" id="search-checkbox" name="search-checkbox">
                <span> Include archived claims</span>
            </label>
            <button class="more-search-options__button">Advanced</button>
        </div>
    </div>

    <div class="sidebar-search-results-container">
        <div class="search-results-container__placeholder">No search results.</div>
        <div class="search-results-container__search-links">
            <a href="/search" class="search-results__search-link" target="_blank">Search Discussion Names</a>
            <a class="search-results__search-link">Search Sources</a>
        </div>
    </div>
</div>