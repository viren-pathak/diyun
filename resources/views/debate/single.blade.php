@extends('page.master')

@section('content')
<section class="debate-single-content">
    <div class="container">

        <div class="content__sunburst-mini-map">
        </div>

        <div class="content__body-container">
            <div class="content__body">
                <div class="ancestor-stack">
                    @php
                        $ancestors = [];
                        $currentDebate = $debate;
                        while ($currentDebate->parent_id !== null) {
                            $ancestors[] = $currentDebate;
                            $currentDebate = App\Models\Debate::find($currentDebate->parent_id);
                        }
                        $ancestors[] = $currentDebate;
                    @endphp
                    <div class="ancestor-claim-container">
                        @foreach(array_reverse($ancestors) as $ancestor)
                            @if($ancestor->id !== $debate->id) {{-- Exclude selected debate from ancestor stack --}}
                                <div class="ancestor-claim">
                                    <div class="claim-card" data-debate-id="{{ $ancestor->id }}" data-debate-slug="{{ $ancestor->slug }}"> {{-- Add data-debate-slug attribute --}}
                                        <div class="claim-header"></div>
                                        <div class="claim-text">
                                            <p class="claim-text__content">{{ $ancestor->title }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                
                <main class="content__selected-and-columns">
                    <div class="selected-claim-container">
                        <div class="selected-claim">
                            <div class="claim-card" data-debate-id="{{ $debate->id }}" data-debate-slug="{{ $debate->slug }}">
                                <div class="claim-header">
                                </div>

                                <div class="claim-text">
                                    <p class="claim-text__content">{{ $debate->title }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns-container">
                        <div class="columns-container__column-headers">
                            <div class="column-box column-box--header--pro">
                                <div class="column-box--header--pro--contents">
                                    <p class="column-box--pro--info">Pros</p>
                                    <button type="button" class="btn-danger btn add-pro-btn" data-authenticated="{{ auth()->check() }}">+</button>
                                </div>
                                <div class="add-pro-form-container add-child-form-container" style="display:none;">
                                    <form action="{{ route('debate.addPro', ':id') }}" method="POST" class="add-pro-form">
                                        @csrf
                                        <input class="child-form-input" type="text" name="title" placeholder="Enter pro argument" maxlength="500">
                                        <p class="char-count">500 characters remaining</p>
                                        <button class="child-form-submit" type="submit">Submit</button>
                                        <button type="button" class="close-form-btn">Close</button>
                                    </form>
                                </div>
                            </div>

                            <div class="column-box column-box--header--con">
                                <div class="column-box--header--con--contents">
                                    <p class="column-box--con--info">Cons</p>
                                    <button type="button" class="btn-danger btn add-cons-btn" data-authenticated="{{ auth()->check() }}">+</button>
                                </div>
                                <div class="add-con-form-container add-child-form-container" style="display:none;">
                                    <form action="{{ route('debate.addCon', ':id') }}" method="POST" class="add-con-form">
                                        @csrf
                                        <input class="child-form-input" type="text" name="title" placeholder="Enter con argument" maxlength="500">
                                        <p class="char-count">500 characters remaining</p>
                                        <button class="child-form-submit" type="submit">Submit</button>
                                        <button type="button" class="close-form-btn">Close</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="columns-container__column-contents">
                            <div class="column-box column-box--claims column-box--claims-pro">
                                <ul class="column__content--pros">
                                    @foreach($pros as $pro)
                                        <li class="pro-argument">
                                            <div class="actionable-claim-container">
                                                <div class="actionable-claim">
                                                    <div class="claim-card child-claim-card" data-debate-id="{{ $pro->id }}" data-debate-slug="{{ $pro->slug }}"> {{-- Add data-debate-slug attribute --}}
                                                        <div class="claim-header">
                                                        </div>

                                                        <div class="claim-text">
                                                            <p class="claim-text__content">{{ $pro->title }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="column-box column-box--claims column-box--claims-con">
                                <ul class="column__content--cons">
                                    @foreach($cons as $con)
                                        <li class="con-argument">
                                            <div class="actionable-claim-container">
                                                <div class="actionable-claim">
                                                    <div class="claim-card child-claim-card" data-debate-id="{{ $con->id }}" data-debate-slug="{{ $con->slug }}"> {{-- Add data-debate-slug attribute --}}
                                                        <div class="claim-header">
                                                        </div>

                                                        <div class="claim-text">
                                                            <p class="claim-text__content">{{ $con->title }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                </main>
            </div>
        </div>
    </div>
</section>

@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        // Function to handle the click event on child claim cards
        // Function to handle the click event on child claim cards
        // Function to handle the click event on child claim cards
        function handleChildClaimClick() {
            var selectedClaim = $('.selected-claim');
            var ancestorStack = $('.ancestor-stack');
            var actionableClaim = $(this).closest('.actionable-claim');
            var debateId = $(this).data('debate-id');

            // Remove any existing instances of the clicked debate from the ancestor stack
            ancestorStack.find('.claim-card[data-debate-id="' + debateId + '"]').remove();

            // Get the selected claim's slug
            var debateSlug = $(this).data('debate-slug');

            // Check if the clicked debate is already in the ancestor stack
            var existingDebate = ancestorStack.find('.claim-card[data-debate-id="' + debateId + '"]').length;

            // If the clicked debate is not in the ancestor stack, append it
            if (existingDebate === 0) {
                // Clone the selected claim
                var clonedSelectedClaim = selectedClaim.clone();

                // Remove any existing instances of the clicked debate from the cloned selected claim
                clonedSelectedClaim.find('.claim-card[data-debate-id="' + debateId + '"]').remove();

                // Append the cloned selected claim to ancestor stack
                ancestorStack.append(clonedSelectedClaim.html());

                // Replace the selected claim with the clicked child debate
                selectedClaim.html(actionableClaim.html());
            }

            // Update the URL without page refresh
            var newUrl = window.location.protocol + '//' + window.location.host + '/debate/' + debateSlug;
            window.history.pushState({ path: newUrl }, '', newUrl);

            // Load child arguments based on the selected claim's slug
            loadChildArguments(debateSlug);
        }


        // Function to handle the click event on ancestor claim cards
        function handleAncestorClaimClick() {
            // Get the selected claim's slug
            var debateSlug = $(this).data('debate-slug');

            // Redirect to the selected ancestor debate URL
            var newUrl = window.location.protocol + '//' + window.location.host + '/debate/' + debateSlug;
            window.location.href = newUrl;
        }

        // Function to bind click event handlers
        function bindClickEvents() {
            // Bind click event to child claim cards
            $('.child-claim-card').click(handleChildClaimClick);
            
            // Bind click event to ancestor claim cards
            $('.ancestor-stack .claim-card').click(handleAncestorClaimClick);
        }

        // Bind click events when the document is ready
        bindClickEvents();

        // Function to load child arguments
        function loadChildArguments(debateSlug) {
            $.ajax({
                url: '/debate/' + debateSlug + '/children',
                type: 'GET',
                success: function (response) {
                    // Clear previous pros and cons
                    $('.column__content--pros').empty();
                    $('.column__content--cons').empty();

                    // Append new pros
                    response.pros.forEach(function(pro) {
                        var proElement = $('<li class="pro-argument"><div class="actionable-claim-container"><div class="actionable-claim"><div class="claim-card child-claim-card" data-debate-id="' + pro.id + '" data-debate-slug="' + pro.slug + '"><div class="claim-header"></div><div class="claim-text"><p class="claim-text__content">' + pro.title + '</p></div></div></div></div></li>');
                        $('.column__content--pros').append(proElement);
                        proElement.find('.child-claim-card').click(handleChildClaimClick); // Re-bind click event
                    });

                    // Append new cons
                    response.cons.forEach(function(con) {
                        var conElement = $('<li class="con-argument"><div class="actionable-claim-container"><div class="actionable-claim"><div class="claim-card child-claim-card" data-debate-id="' + con.id + '" data-debate-slug="' + con.slug + '"><div class="claim-header"></div><div class="claim-text"><p class="claim-text__content">' + con.title + '</p></div></div></div></div></li>');
                        $('.column__content--cons').append(conElement);
                        conElement.find('.child-claim-card').click(handleChildClaimClick); // Re-bind click event
                    });

                    // Bind click events after loading child arguments
                    bindClickEvents();
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Submit pro form
        $('.add-pro-form').submit(function (event) {
            event.preventDefault(); // Prevent the default form submission
            
            // Get the parent debate ID from the currently selected claim
            var parentDebateId = $('.selected-claim .claim-card').data('debate-id');
            
            // Update the form action with the correct parent debate ID
            var formAction = $(this).attr('action').replace(':id', parentDebateId);
            $(this).attr('action', formAction);
            
            // Submit the form
            this.submit();
        });
        
        // Submit con form
        $('.add-con-form').submit(function (event) {
            event.preventDefault(); // Prevent the default form submission
            
            // Get the parent debate ID from the currently selected claim
            var parentDebateId = $('.selected-claim .claim-card').data('debate-id');
            
            // Update the form action with the correct parent debate ID
            var formAction = $(this).attr('action').replace(':id', parentDebateId);
            $(this).attr('action', formAction);
            
            // Submit the form
            this.submit();
        });
    });
</script>

