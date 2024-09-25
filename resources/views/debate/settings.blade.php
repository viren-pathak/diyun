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

                                {{-- Voting Allowed Checkbox --}}
                                <div class="debate-details__voting">
                                    <label for="voting_allowed">Allow Voting</label><br>
                                    <input type="checkbox" id="voting_allowed" name="voting_allowed" {{ $rootDebate->voting_allowed ? 'checked' : '' }}>
                                </div>


                                {{-- Debate Actions --}}
                                <div class="debate-actions-container">
                                    <h4 class="debate-actions__title">Debate Actions</h4>
                                    <ul class="debate-actions__item-lists">
                                        <li class="debate-actions__item debate-action__change-type">
                                            <button type="button" id="change-debate-type">Change Debate Type</button>
                                        </li>
                                        <li class="debate-actions__item debate-action__archive-debate">
                                            <button type="button" id="archive-debate">Archive Debate</button>
                                        </li>
                                        <li class="debate-actions__item debate-action__export-debate">
                                            <button type="button" id="export-debate">Export Debate Data</button>
                                        </li>
                                    </ul>
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
                    <div class="debate-share-container">
                        @if($isOwner)
                            <p>Share this debate:</p>
                            <input type="text" id="debate-share-url" value="{{ route('debate.single', ['slug' => $rootDebate->slug]) }}" readonly>
                            <button id="copy-debate-url">
                                <i class="fa fa-clone" aria-hidden="true"></i>
                            </button>
                            
                            <button id="generate-qr-code">
                                <i class="fa fa-qrcode" aria-hidden="true"></i>
                            </button>
                        @endif
                    </div>
                    <div class="debate-creation-label">
                        <p>This debate was published on {{ $rootDebate->created_at->format('M d, Y') }} by {{ $rootDebate->user->name }}</p>
                    </div>
                    @if($isOwner)
                    <div class="debate-invite-container">
                        <p>Users</p>
                        <button id="debate-invite-user-btn" class="debate-invite-container__button">Invite Users</button>
                    </div>
                    @endif
                    <div class="debate-participants-container">
                        <h3 class="debate-participants-container_heading">Participants in Debate</h3>
                        <ul class="debate-participants_list">
                            @foreach($participants as $participant)
                                <li class="participant-details">
                                    <div class="participant-pers-info">
                                        <p class="debate-participant-name">{{ $participant->name }}</p>
                                        <div class="debate-participant-avatar">
                                            <img src="{{ $participant->profile_picture_url }}" alt="{{ $participant->name }}">
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

    <style>
        .qr-code-modal,
        .invite-user-modal {
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
        }
        .qr-code-buttons {
            margin-top: 10px;
        }
        .qr-code-buttons button, .qr-code-buttons a {
            margin: 0 5px;
            padding: 8px 12px;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
        }
        .qr-code-buttons a:hover {
            background-color: #0056b3;
        }


        /* Spinner styles */
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 0.8s linear infinite;
            display: none; /* Initially hidden */
            position: absolute;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>

    <script>
        function closeSettings() {
            window.location.href = '{{ route("debate.single", ["slug" => $rootDebate->slug, "active" => $rootDebate->id]) }}';
        }

        document.addEventListener('DOMContentLoaded', function() {
            var isOwner = @json($isOwner);

            if (!isOwner) {
                // Disable form fields
                document.querySelectorAll('#settings-form input, #settings-form textarea').forEach(function(element) {
                    element.readOnly = true;
                    if (element.type === 'file') {
                        element.disabled = true;
                    }
                });

                // Hide submit button
                document.querySelector('.debate-details__submit-btn').style.display = 'none';

                // Disable action buttons
                document.querySelectorAll('.debate-action__change-type button,.debate-action__archive-debate button').forEach(function(button) {
                    button.disabled = true;
                });

                // Disable voting allowed checkbox
                document.getElementById('voting_allowed').disabled = true;
            }
        });

        
        // ###### DEBATE LINK WITH QR CODE
        document.addEventListener('DOMContentLoaded', function() {
            var copyButton = document.getElementById('copy-debate-url');
            var shareUrlInput = document.getElementById('debate-share-url');
            var qrCodeButton = document.getElementById('generate-qr-code');
            var debateTitle = "{{ $rootDebate->title }}";

            copyButton.addEventListener('click', function() {
                shareUrlInput.select();
                shareUrlInput.setSelectionRange(0, 99999); // For mobile devices

                navigator.clipboard.writeText(shareUrlInput.value).then(function() {
                    showFlashModal('Invite link copied!');
                }).catch(function(err) {
                    console.error('Failed to copy text: ', err);
                });
            });

            qrCodeButton.addEventListener('click', function() {
                var qrCodeModalHtml = `
                    <div class="qr-code-modal">
                        <div class="modal-content">
                            <span class="close close-qr-code-modal">&times;</span>
                            <h3>Scan the QR Code to Share</h3>
                            <p>This is the QR code for the discussion <b>${debateTitle}</b>.</p>
                            <canvas id="qr-code-canvas"></canvas>
                            <div class="qr-code-buttons">
                                <button id="copy-qr-code">Copy QR Code</button>
                                <button id="download-qr-code">Download QR Code</button>
                            </div>
                        </div>
                    </div>
                `;

                document.body.insertAdjacentHTML('beforeend', qrCodeModalHtml);

                var qr = new QRious({
                    element: document.getElementById('qr-code-canvas'),
                    value: shareUrlInput.value,
                    size: 200
                });

                document.querySelector('.close-qr-code-modal').addEventListener('click', function() {
                    document.querySelector('.qr-code-modal').remove();
                });

                // Event listener for copying QR code to clipboard
                document.getElementById('copy-qr-code').addEventListener('click', function() {
                    var canvas = document.getElementById('qr-code-canvas');
                    canvas.toBlob(function(blob) {
                        navigator.clipboard.write([
                            new ClipboardItem({
                                [blob.type]: blob
                            })
                        ]).then(function() {
                            showFlashModal('QR code copied to clipboard!');
                        }).catch(function(err) {
                            console.error('Failed to copy QR code: ', err);
                        });
                    }, 'image/png');
                });

                // Event listener for downloading QR code
                document.getElementById('download-qr-code').addEventListener('click', function() {
                    var canvas = document.getElementById('qr-code-canvas');
                    canvas.toBlob(function(blob) {
                        var url = URL.createObjectURL(blob);
                        var a = document.createElement('a');
                        a.href = url;
                        a.download = 'discussion-qr-code_' + debateTitle.replace(/\s+/g, '-').toLowerCase() + '.png';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                    }, 'image/png');
                });
            });

            function showFlashModal(message) {
                const flashModalHtml = `<div class="flash-modal">${message}</div>`;
                document.body.insertAdjacentHTML('beforeend', flashModalHtml);

                const flashModal = document.querySelector('.flash-modal');
                flashModal.style.display = 'block';

                setTimeout(() => {
                    flashModal.remove();
                }, 2000);
            }
        });

        
        ///// #### DEBATE INVITE USER VIA MAIL

        document.addEventListener('DOMContentLoaded', function() {
            var inviteUserButton = document.getElementById('debate-invite-user-btn');

            inviteUserButton.addEventListener('click', function() {
                var inviteUserModalHtml = `
                    <div class="invite-user-modal">
                        <div class="modal-content">
                            <span class="close close-invite-user-modal">&times;</span>
                            <h3>Invite User to Debate</h3>
                            <form id="debate-invite-user-form">
                                <div class="debate-invite-user-form__email">
                                    <input type="email" id="email" name="email" required placeholder="Enter User Email Address">
                                </div>

                                <div class="debate-invite-user-form__role">
                                    <label for="role">Role</label>
                                    <select id="role" name="role" required>
                                        <option value="owner">Owner</option>
                                        <option value="admin">Admin</option>
                                        <option value="editor">Editor</option>
                                        <option value="writer">Writer</option>
                                        <option value="suggester">Suggester</option>
                                        <option value="viewer">Viewer</option>
                                    </select>
                                </div>

                                <div class="debate-invite-user-form__invite-msg">
                                    <label for="message">Invite Message (Optional)</label>
                                    <textarea id="message" name="message" placeholder="Write a personal message to include with your invite."></textarea>
                                </div>
                                <div class="invite-send-btn-container">
                                    <button type="button" id="send-debate-invite">Send Invite</button>
                                    <div class="spinner" style="display: none;"></div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', inviteUserModalHtml);

                document.querySelector('.close-invite-user-modal').addEventListener('click', function() {
                    document.querySelector('.invite-user-modal').remove();
                });

                document.getElementById('send-debate-invite').addEventListener('click', function() {
                    var form = document.getElementById('debate-invite-user-form');
                    var formData = new FormData(form);
                    var debateId = '{{$rootDebate->id}}'; // Pass the current debate ID
                    formData.append('debate_id', debateId);

                    // Show spinner while processing
                    var spinner = document.querySelector('.spinner');
                    spinner.style.display = 'inline-block';

                    fetch('{{ route("debate.sendInvite") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        spinner.style.display = 'none'; // Hide spinner after response

                        if (data.success) {
                            showFlashModal('Invite sent successfully!');
                            document.querySelector('.invite-user-modal').remove();
                        } else {
                            showFlashModal(data.error || 'Error sending invite.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        spinner.style.display = 'none'; // Hide spinner on error
                        showFlashModal('Error sending invite.');
                    });
                });
            });
            
            function showFlashModal(message) {
                const flashModalHtml = `<div class="flash-modal">${message}</div>`;
                document.body.insertAdjacentHTML('beforeend', flashModalHtml);

                const flashModal = document.querySelector('.flash-modal');
                flashModal.style.display = 'block';

                setTimeout(() => {
                    flashModal.remove();
                }, 2000);
            }
        });


        // ###### DEBATE EXPORT FUNCTIONALITY
        
        document.getElementById('export-debate').addEventListener('click', function() {
            // Check if the user is authenticated
            if ({{ json_encode($isAuthenticated) }}) {
                // Create the popup HTML
                const popupHTML = `
                    <div id="debate-export-popup" class="ajax-export-popup">
                        <div class="export-popup-content">
                            <span class="close debate-export-popup__close">&times;</span>
                            <h2>Export Discussion</h2>
                            <p>You may export discussions for private use. If you would like to request consent for other uses, please contact us.</p>
                            <button id="export-download-button">Download</button>
                            <button id="close-export-popup">Close</button>
                        </div>
                    </div>
                `;

                // Append the popup to the body
                document.body.insertAdjacentHTML('beforeend', popupHTML);

                // Event listener for the download button
                document.getElementById('export-download-button').addEventListener('click', function() {
                    // Redirect to the export route to download the file
                    window.location.href = '{{ route("exportDebate", ["slug" => $rootDebate->slug]) }}';
                    closeExportPopup();
                });

                // Event listener for the close button
                document.getElementById('close-export-popup').addEventListener('click', function() {
                    closeExportPopup();
                });

                // Event listener for the close icon
                document.querySelector('.debate-export-popup__close').addEventListener('click', function() {
                    closeExportPopup();
                });
            }
        });

        // Function to close the popup
        function closeExportPopup() {
            const popup = document.getElementById('debate-export-popup');
            if (popup) {
                popup.remove(); // Remove the popup from the DOM
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var isAuthenticated = @json($isAuthenticated);

            if (!isAuthenticated) {
                // Disable action buttons
                document.querySelectorAll('.debate-actions__item-lists button').forEach(function(button) {
                    button.disabled = true; // Disable the button
                    button.classList.add('disabled-link'); // Add a class to style it
                });
            }
        });

        
    </script>
@endsection
