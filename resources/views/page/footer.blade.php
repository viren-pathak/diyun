<!-- resources/views/footer.blade.php -->

<footer>
      <div class="row">
        <img
          class="blue d-block"
          src="{{ asset('uploads/Blue-logo.png')}}"
          alt="logo"
          style="width: 80px"
        />
      </div>
      <div class="row flex-justify-between flex footer-menu-1">
        <ul class="flex flex-align-center flex-column">
          <li><a href="#">Explore</a></li>
          <li><a href="{{ route('search.page') }}">Search</a></li>
          <li><a href="about.page">About</a></li>
        </ul>
        <ul class="flex flex-align-center flex-column">
          <li><a href="#">What’s New</a></li>
          <li><a href="{{ route('Privacy.page') }}">Privacy Policy</a></li>
          <li><a href="#">Terms of Service</a></li>
        </ul>
        <ul class="flex flex-align-center flex-column">
          <li><a href="{{ route('help.page') }}">Help Center</a></li>
          <li><a href="{{ route('contact.page') }}">Contact Us</a></li>
          <li><a href="#">Status</a></li>
        </ul>
      </div>
      <div class="row footer-menu-2">
        <div class="col flex-justify-between flex">
          <div class="flex flex-align-center flex-column">
            <h2>Debate</h2>
            <p>For private & public use</p>
          </div>
          <div class="flex flex-align-center flex-column">
            <h2>Debate</h2>
            <p>For educators</p>
          </div>
        </div>
      </div>
      <div class="row flex-justify-between flex footer-social">
        <ul class="flex flex-align-center">
          <li>
            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
          </li>
          <li>
            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
          </li>
          <li>
            <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
          </li>
          <p>© Debate 2024</p>
        </ul>
      </div>
      <section class="footer-bg">
        <div class="row flex flex-center">
          <h2>Empowering Reason</h2>
        </div>
      </section>
    </footer> 