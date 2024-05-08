@extends('page.master')

@section('content')
<section>
    <div class="row">
    <h2>Contact</h2>

    <p>We’d love to hear from you! If you have any questions or feedback to give, feel free to use the form below.</p>

    <form action="/submit-contact-form" method="post" enctype="multipart/form-data">
        <div>
            <label for="name">Your Name:</label><br>
            <input type="text" id="name" name="name" required>
        </div>

        <div>
            <label for="email">Your Email:</label><br>
            <input type="email" id="email" name="email" required>
        </div>

        <div>
            <label for="subject">Subject:</label><br>
            <input type="text" id="subject" name="subject" required>
        </div>

        <div>
            <label for="message">Message:</label><br>
            <textarea id="message" name="message" rows="4" required></textarea>
        </div>

        <div>
            <label for="attachment">Attachment file:</label><br>
            <input type="file" id="attachment" name="attachment">
        </div>

        <div>
            <button type="submit">Send</button>
        </div>
    </form>
@endsection

@push('footer-script')
    <!-- Your footer scripts go here -->
@endpush
</div>
</section>