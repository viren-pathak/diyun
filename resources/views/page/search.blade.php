@extends('page.master')

@section('content')

<section>
<form action="/submit-contact-form" method="post" enctype="multipart/form-data">
    <div>
      <input type="search" placeholder="Search">
      <button type="submit" >Search</button>
    </div>
</form>
</section>

@endsection

@push('footer-script')
    <!-- Your footer scripts go here -->
@endpush