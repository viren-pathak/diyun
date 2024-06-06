<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="{{ asset('css/diyun.css') }}" rel="stylesheet">
        <script src="{{ asset('js/diyun.js') }}"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <title>Diyun</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link rel="icon" href="{{ asset('/uploads/Favicon.png') }}" type="image/x-icon"/>
       
    </head>
    <style>
        /* Loader Styles */
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 1000;
            position: absolute;
            top:50%;
            right:50%;

        }

        .spinner {
            border: 16px solid #f3f3f3; /* Light grey */
            border-top: 16px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
    <body class="antialiased">
        @include('page.header')
        <div id="loader" style="display: none;">
            <div class="spinner"></div>
        </div>
        <main>
              @yield('content')
        </main>
        @include('page.footer')
  
        <script>
            document.addEventListener("ajaxStart", function() {
                document.getElementById("loader").style.display = "block";
            });

            document.addEventListener("ajaxStop", function() {
                document.getElementById("loader").style.display = "none";
            });

            // Function to simulate ajaxStart and ajaxStop events
            function simulateAjaxEvents() {
                var event = new Event("ajaxStart");
                document.dispatchEvent(event);
                setTimeout(function() {
                    event = new Event("ajaxStop");
                    document.dispatchEvent(event);
                }, 2000); // Simulate a 2-second AJAX request
            }

            // Simulate an AJAX request
            simulateAjaxEvents();

            $(document).ajaxStart(function() {
                $("#loader").show();
            });

            $(document).ajaxStop(function() {
                $("#loader").hide();
            });

        </script>
    </body>
</html>