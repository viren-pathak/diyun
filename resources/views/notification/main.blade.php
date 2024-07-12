{{-- #### NOTIFICATION BAR IN SINGLE PAGE #### --}}
<div id="notification-menu" class="notification-menu">

    {{-- #### sidebar menu header #### --}}
    <div class="notification-menu__header">
        <div class="sidebar-template__title">
            <h2 class="notification-header__text">Notifications</h2>
        </div>
        <button aria-label="Close" class="notification-menu__close">
            <span class="icon-svg">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                </svg>
            </span>
        </button>
    </div>

    <div class="notification-menu__content">
        {{-- Tabs --}}
        <ul class="notification-tabs-list">
            <li class="notification-tab-item" data-tab="changes" onclick="loadTabContent('changes')">Changes</li>
            <li class="notification-tab-item" data-tab="activity" onclick="loadTabContent('activity')">Activity</li>
            <li class="notification-tab-item" data-tab="global" onclick="loadTabContent('global')">Global</li>
        </ul>

        {{-- Tab content --}}
        <div id="notification-tab-content-container">
            {{-- Initial content will be loaded here --}}
        </div>
    </div>
</div>


<script>


    // Function to load tab content
    function loadTabContent(tab) {
        // Clear current content
        document.getElementById('notification-tab-content-container').innerHTML = '';

        // Make AJAX request to fetch the tab content
        fetch(`/notification/${tab}`)
            .then(response => response.text())
            .then(data => {
                // Update the tab content with the fetched data
                document.getElementById('notification-tab-content-container').innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching tab content:', error);
            });
    }

    // Load the initial tab content
    document.addEventListener('DOMContentLoaded', function() {
        loadTabContent('changes');
    });



    $(document).ready(function() {
        // TOGGLE SIDEBAR NOTIFICATION ON CLICK OF BUTTON IN HEADER
        $('.single-page-notifications').click(function() {
            $('#notification-menu').toggleClass('active');
            $('.debate-single-content').toggleClass('notification-active');
            $('#sidebar-chats').removeClass('active');
        });
                
        $('.notification-menu__close').click(function() {
            $('#notification-menu').removeClass('active');
            $('.debate-single-content').removeClass('notification-active');
        });
    });
</script>