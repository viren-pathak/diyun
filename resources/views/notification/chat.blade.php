{{-- #### NOTIFICATION BAR IN SINGLE PAGE #### --}}
<div id="sidebar-chats" class="chats-cont">

    {{-- #### sidebar menu header #### --}}
    <div class="sidebar-chats__header">
        <div class="sidebar-template__title">
            <h2 class="sidebar-chats__text">Chats</h2>
        </div>
        <button aria-label="Close" class="sidebar-chats__close">
            <span class="icon-svg">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                </svg>
            </span>
        </button>
    </div>


    <div class="sidebar-chats__content">
        <div class="sidebar-chats__content-header">
            <ul class="online-users-list">
                <li class="online-user-acatar"><img src="http://127.0.0.1:8000/uploads/user_def.jpeg" alt="User Image"></li>
                <li class="online-user-acatar"><img src="http://127.0.0.1:8000/uploads/user_def.jpeg" alt="User Image"></li>
                <li class="online-user-acatar"><img src="http://127.0.0.1:8000/uploads/user_def.jpeg" alt="User Image"></li>
                <li class="online-user-acatar"><img src="http://127.0.0.1:8000/uploads/user_def.jpeg" alt="User Image"></li>
                <li class="online-user-acatar"><img src="http://127.0.0.1:8000/uploads/user_def.jpeg" alt="User Image"></li>
            </ul>
        </div>
        
        <div class="sidebar-chats__content-body">
            <ul class="sidebar-chats__msg-lists">
                <li class="chat-box-template">
                    <div class="chat-box-template__avatar">
                        <img src="http://127.0.0.1:8000/uploads/user_def.jpeg" alt="User Image">
                    </div>
                    <div class="chat-box-template__content">
                        <div class="chat-box-template__txt">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris in elit blandit lorem tempus efficitur.
                        </div>
                        <div class="chat-box-template__status">
                            <strong>SZweig(1.1k)</strong>
                            <span>  • 3mo</span>
                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </div>
                    </div>
                </li>

                <li class="chat-box-template">
                    <div class="chat-box-template__avatar">
                        <img src="http://127.0.0.1:8000/uploads/user_def.jpeg" alt="User Image">
                    </div>
                    <div class="chat-box-template__content">
                        <div class="chat-box-template__txt">
                            I would think not capitalized
                        </div>
                        <div class="chat-box-template__status">
                            <strong>SZweig(1.1k)</strong>
                            <span>  • 3mo</span>
                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </div>
                    </div>
                </li>


                <li class="chat-box-template">
                    <div class="chat-box-template__avatar">
                        <img src="http://127.0.0.1:8000/uploads/user_def.jpeg" alt="User Image">
                    </div>
                    <div class="chat-box-template__content">
                        <div class="chat-box-template__txt">
                            <span class="mentioned-user">omar_yosef</span> Good point. I don't think I'd have ever thought of that.
                        </div>
                        <div class="chat-box-template__status">
                            <strong>Kupo(2.7k)</strong>
                            <span>  • 23d</span>
                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="sidebar-chats__content-footer">
            <div class="request-participation-cont">
                <span>To chat please </span>
                <button class="request-participation-link blue-text">request Writer rights</button>
                <button class="request-participation-btn"><i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        // TOGGLE SIDEBAR NOTIFICATION ON CLICK OF BUTTON IN HEADER
        $('.single-page-chat').click(function() {
            $('#sidebar-chats').toggleClass('active');
            $('.debate-single-content').toggleClass('notification-active');
            $('#notification-menu').removeClass('active');
        });
                
        $('.sidebar-chats__close').click(function() {
            $('#sidebar-chats').removeClass('active');
            $('.debate-single-content').removeClass('notification-active');
        });
    });
</script>