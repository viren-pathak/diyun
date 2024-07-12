{{-- #### SIDEBAR MENU IN SINGLE PAGE #### --}}
<div id="sidebar-menu" class="sidebar-menu">
    <aside class="single-sidebar-menu">

        {{-- #### sidebar menu header #### --}}
        <div class="single-sidebar-menu__header">
            <div class="sidebar-template__title">
                <h2 class="sidebar-menu-header__text">Menu</h2>
            </div>
            <button aria-label="Close" class="single-sidebar-menu__close">
                <span class="icon-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                    </svg>
                </span>
            </button>
        </div>


        {{-- #### sidebar menu content #### --}}
        <div class="single-sidebar-menu__content">
            <div class="sidebar-menu-link-container">
                <ul class="sidebar-menu-link-list">

                    <li class="sidebar-menu-link sidebar-menu-link-myDiyun">
                        <a class="menu-link" href="#">
                            <span class="icon-svg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
                                    <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
                                </svg>
                            </span>
                            My Diyun
                        </a>
                    </li>

                    <li class="sidebar-menu-link sidebar-menu-link-sharing">
                        <a class="menu-link" href="{{ route('settings', ['slug' => $rootDebate->slug, 'tab' => 'sharing']) }}">
                            <span class="icon-svg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-gear" viewBox="0 0 16 16">
                                    <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
                                </svg>
                            </span>
                            Share
                        </a>
                    </li>

                    <li class="sidebar-menu-link sidebar-menu-link-settings">
                        <a class="menu-link" href="{{ route('settings', ['slug' => $rootDebate->slug, 'tab' => 'general']) }}">
                            <span class="icon-svg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                    <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                </svg>
                            </span>
                            Settings
                        </a>
                    </li>

                    <li class="sidebar-menu-link sidebar-menu-link-search">
                        <a class="menu-link" href="#">
                            <span class="icon-svg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </span>
                            Search
                        </a>
                    </li>

                    <li class="sidebar-menu-link sidebar-menu-link-infoStats">
                        <a class="menu-link" href="#">
                            <span class="icon-svg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2"/>
                                </svg>
                            </span>
                            Info/Stats
                        </a>
                    </li>

                    <li class="sidebar-menu-link sidebar-menu-link-sources">
                        <a class="menu-link" href="#">
                            <span class="icon-svg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-link-45deg" viewBox="0 0 16 16">
                                    <path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1 1 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4 4 0 0 1-.128-1.287z"/>
                                    <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243z"/>
                                </svg>
                            </span>
                            Sources
                        </a>
                    </li>

                    <li class="sidebar-menu-link menu-item-without-svg sidebar-menu-link-perspectives">
                        <a class="menu-link" href="#">
                            <span class="icon-svg">
                            </span>
                            Perspectives
                        </a>
                    </li>

                    <li class="sidebar-menu-link menu-item-without-svg sidebar-menu-link-guidedVoting">
                        <a class="menu-link" href="#">
                            <span class="icon-svg">
                            </span>
                            Guided Voting
                        </a>
                    </li>

                    <li class="menu-divider">
                        <div class="sidebar-menu-divider"></div>
                    </li>

                    @auth
                    <li class="sidebar-menu-link menu-item-without-svg sidebar-menu-link-requestWriter">
                        <a class="menu-link" href="#">
                            <span class="icon-svg">
                            </span>
                            Request Writer Rights
                        </a>
                    </li>
                    @else
                    <li class="sidebar-menu-link menu-item-without-svg sidebar-menu-link-request"  onclick="openLoginForm()">
                        <a class="menu-link" href="#">
                            <span class="icon-svg">
                            </span>
                            Request Writer Rights
                        </a>
                    </li>
                    @endauth

                    <li class="menu-divider">
                        <div class="sidebar-menu-divider"></div>
                    </li>

                    @auth
                    <li class="sidebar-menu-link menu-item-without-svg sidebar-menu-link-myClaims">
                        <a class="menu-link" href="#">
                            <span class="icon-svg">
                            </span>
                            My Claims
                        </a>
                    </li>

                    <li class="sidebar-menu-link menu-item-without-svg sidebar-menu-link-myContri">
                        <a class="menu-link" href="#">
                            <span class="icon-svg">
                            </span>
                            My Contributions
                        </a>
                    </li>

                    <li class="sidebar-menu-link menu-item-without-svg sidebar-menu-link-myBookmark">
                        <a class="menu-link" href="#">
                            <span class="icon-svg">
                            </span>
                            My Bookmarks
                        </a>
                    </li>

                    <li class="sidebar-menu-link menu-item-without-svg sidebar-menu-link-mySugClaims">
                        <a class="menu-link" href="#">
                            <span class="icon-svg">
                            </span>
                            My Suggested Claims
                        </a>
                    </li>

                    <li class="sidebar-menu-link menu-item-without-svg sidebar-menu-link-mySugComments">
                        <a class="menu-link" href="#">
                            <span class="icon-svg">
                            </span>
                            My Suggested Comments
                        </a>
                    </li>

                    <li class="menu-divider">
                        <div class="sidebar-menu-divider"></div>
                    </li>
                    @endauth

                    <li class="sidebar-menu-link sidebar-menu-link-help">
                        <a class="menu-link" href="#">
                            <span class="icon-svg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-lg" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4.475 5.458c-.284 0-.514-.237-.47-.517C4.28 3.24 5.576 2 7.825 2c2.25 0 3.767 1.36 3.767 3.215 0 1.344-.665 2.288-1.79 2.973-1.1.659-1.414 1.118-1.414 2.01v.03a.5.5 0 0 1-.5.5h-.77a.5.5 0 0 1-.5-.495l-.003-.2c-.043-1.221.477-2.001 1.645-2.712 1.03-.632 1.397-1.135 1.397-2.028 0-.979-.758-1.698-1.926-1.698-1.009 0-1.71.529-1.938 1.402-.066.254-.278.461-.54.461h-.777ZM7.496 14c.622 0 1.095-.474 1.095-1.09 0-.618-.473-1.092-1.095-1.092-.606 0-1.087.474-1.087 1.091S6.89 14 7.496 14"/>
                                </svg>
                            </span>
                            Help
                        </a>
                    </li>

                </ul>
            </div>
        </div>

        {{-- #### sidebar menu content #### --}}
        <div class="single-sidebar-menu__items">
                <div class="single-sidebar-menu__item-search sidebar-menu__item">
                        @include('sidebar.search')
                </div>

                <div class="single-sidebar-menu__item-sources sidebar-menu__item">
                        @include('sidebar.sources')
                </div>

                <div class="single-sidebar-menu__item-perspectives sidebar-menu__item">
                        @include('sidebar.perspectives')
                </div>
            @auth
                <div class="single-sidebar-menu__item-myClaims sidebar-menu__item">
                    @isset($myClaims)
                        @include('sidebar.myClaims')
                    @endisset
                </div>

                <div class="single-sidebar-menu__item-myContri sidebar-menu__item">
                    @isset($myContributions)
                        @include('sidebar.myContributions')
                    @endisset
                </div>

                <div class="single-sidebar-menu__item-myBookmarks sidebar-menu__item">
                    @isset($bookmarkedDebates)
                        @include('sidebar.myBookmarks')
                    @endisset
                </div>

                <div class="single-sidebar-menu__item-mySugClaims sidebar-menu__item">
                    @include('sidebar.mySugClaims')
                </div>

                <div class="single-sidebar-menu__item-mySugComments sidebar-menu__item">
                    @include('sidebar.mySugComments')
                </div>
            @endauth
        </div>
    </aside>    
</div>

<script>
    $(document).ready(function() {

        // TOGGLE SIDEBAR MENU ON CLICK OF BUTTON IN HEADER
        $('.single-page-menu').click(function() {
            $('#sidebar-menu').toggleClass('active');
            $('.debate-single-content').toggleClass('sidebar-active');
        });
                
        // CLOSE SIDEBAR WHEN CLICKED ON CLOSE BUTTON
        $('.single-sidebar-menu__close').click(function() {
            $('#sidebar-menu').removeClass('active');
            $('.debate-single-content').removeClass('sidebar-active');
            $('.sidebar-menu__item').removeClass('active');
        });

        // GET BACK TO MAIN MENU WHEN CLICKED BACK BUTTON
        $('.single-sidebar-menu__item-back').click(function() {
            $('.sidebar-menu__item').removeClass('active');
        });


        // MY CLAIMS DIV OPEN CLOSE
        $('.sidebar-menu-link-myClaims').click(function() {
            $('.single-sidebar-menu__item-myClaims').toggleClass('active');
        });

        // MY CONTRIBUTIONS DIV OPEN CLOSE

        $('.sidebar-menu-link-myContri').click(function() {
            $('.single-sidebar-menu__item-myContri').toggleClass('active');
        });

        // MY BOOKMARKS DIV OPEN CLOSE

        $('.sidebar-menu-link-myBookmark').click(function() {
            $('.single-sidebar-menu__item-myBookmarks').toggleClass('active');
        });

        // SEARCH DIV OPEN CLOSE
        $('.sidebar-menu-link-search').click(function() {
            $('.single-sidebar-menu__item-search').toggleClass('active');
        });

        // SOURCES DIV OPEN CLOSE
        $('.sidebar-menu-link-sources').click(function() {
            $('.single-sidebar-menu__item-sources').toggleClass('active');
        });

        // PERSPECTIVES DIV OPEN CLOSE
        $('.sidebar-menu-link-perspectives').click(function() {
            $('.single-sidebar-menu__item-perspectives').toggleClass('active');
        });

        // MY SUGGESTED CLAIMS DIV OPEN CLOSE
        $('.sidebar-menu-link-mySugClaims').click(function() {
            $('.single-sidebar-menu__item-mySugClaims').toggleClass('active');
        });

        // MY SUGGESTED CLAIMS DIV OPEN CLOSE
        $('.sidebar-menu-link-mySugComments').click(function() {
            $('.single-sidebar-menu__item-mySugComments').toggleClass('active');
        });
    });

        
    document.addEventListener('DOMContentLoaded', function() {

        document.querySelectorAll('.sidebar-menu-link-requestWriter').forEach(container => {
            container.addEventListener('click', function(event) {
                event.stopPropagation();
                openRightsForm(); 
            });
        });

        // Function to open the FORM fot requesting writer rights
        function openRightsForm(container) {
            // Create the control modal HTML
            const openRightsFormHtml = `
                <div class="rights-form-modal">
                    <div class="modal-content">
                        <span class="close close-rights-modal">&times;</span>
                        <h2 class="right-form-heading">Request Writer rights</h2>
                        <p>Tip: Admins are much more likely to grant Writer rights to users who have already suggested a few claims.</p>
                        <div class="modal-form-cont">
                            <b>Message:</b>
                            <input class="right-form-input" type="text" placeholder="Please explain why you want to join the discussion.">
                            <p class="rights-form-limit">1024</p>
                            <div class="modal-btn-cont">
                                <button class="close-rights-modal">Cancel</button>
                                <button class="close-rights-modal submit-rights-modal">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                .rights-form-modal {
                    position: fixed;
                    z-index: 999999;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    overflow: auto;
                    background-color: rgba(0,0,0,0.4);
                }
                </style>
            `;

            // Append modal HTML to body
            document.body.insertAdjacentHTML('beforeend', openRightsFormHtml);

            // Add event listener for clicking outside the modal content
            document.querySelector('.rights-form-modal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeRightsForm();
                }
            });

                    // Add event listeners to the modal buttons
            document.querySelectorAll('.close-rights-modal').forEach(button => {
                button.addEventListener('click', function(event) {
                    closeRightsForm();
                });
            });

        }

        // Function to close the FORM fot requesting writer rights
        function closeRightsForm() {
            const modal = document.querySelector('.rights-form-modal');
            if (modal) {
                modal.remove();
            }
        }
    });
</script>