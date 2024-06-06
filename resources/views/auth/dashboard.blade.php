@extends('page.master')
@section('content')


 <style>
    .navtabs {
  display: flex;
  justify-content: center;
  margin-top: 20px;
  background: white;
  border-radius: 8px;
  padding: 10px 20px;
  position: relative;
}
.navtab {
  margin: 0 10px;
  padding: 10px 20px;
  cursor: pointer;
  color: #007BFF;
  font-weight: 600;
  transition: color 0.3s;
}
.navtab:hover {
  color: #007BFF;
}
.navtab.active {
  color: black;
  font-weight: 600;
}
.underline {
  position: absolute;
  bottom: 0;
  height: 2px;
  background: #000;
  transition: left 0.3s ease, width 0.3s ease;
}
.content {
  display: none;
  padding: 100px 20px 20px;
  max-width: 800px;
  text-align: center;
}
.content.active {
  display: block;
}
.footer {
  position: absolute;
  bottom: 10px;
  right: 10px;
  font-size: 14px;
  color: #000;
  transition: color 0.3s ease;
  font-family: 'Montserrat', sans-serif;
}

.my-diyun-db{
display: flex;
    /* justify-content: center; */
    align-items: center;
    gap: 20px;
    padding: 20px;
}
.toggle-class{
    opacity:0;
}
.toggle-class.active{
    opacity:1;
}
 </style>
<div class="">
        <div class="">
            <div class="">
                <div class="my-diyun-db">
                 <img id="img-click" src="{{asset(auth()->user()->profile_picture)}}" alt="Can't load" width="60px" height="60px" style="border-radius:50%;">
                 <h4 class="my-diyun-h">My DIYUN</h4>
                </div>
               <div class="toggle-class">
                     <span>home</span>
                     <span>test</span>
                     <span>about</span>
                     <span>anout</span>
                 </div>
                <div>
        

            
<!-- tab -->


<div class="navtabs">
      <div class="navtab active" data-target="Overview">Overview</div>
      <div class="navtab" data-target="Respond">Respond</div>
      <div class="navtab" data-target="Following">Following</div>
      <div class="navtab" data-target="All">All</div>
      <div class="navtab" data-target="Own">Own</div>
      <div class="navtab" data-target="Recent">Recent</div>
      <div class="navtab" data-target="Teams">Teams</div>
      <div class="underline"></div>
    </div>

    <div id="Overview" class="content active">
      <h1>Overview</h1>
      <p>This is the home section.</p>
    </div>
    <div id="Respond" class="content">
      <h1>Respond</h1>
      <p>This is the about section.</p>
    </div>
    <div id="Following" class="content">
      <h1>Contact Us</h1>
      <p>This is the contact section.</p>
    </div>
    <div id="All" class="content">
      <h1>All</h1>
      <p>This is the page 4 section.</p>
    </div>
    <div id="Own" class="content">
      <h1>Own</h1>
      <p>This is the page 5 section.</p>
    </div>
    <div id="Recent" class="content">
      <h1>Recent</h1>
      <p>This is the page 6 section.</p>
    </div>
    <div id="Teams" class="content">
      <h1>Teams</h1>
      <p>This is the page 7 section.</p>
    </div>

 


                </div>
        
            </div>
        </div>
</div>
<script>

$(function() {  // Run when the DOM is ready
  $("#img-click").click(function() {  // Use a class, since your ID gets mangled
    $(".toggle-class").addClass("active");  // Add the class to the clicked element
  }).dblclick(function() {  // Add a double-click event handler
    $(".toggle-class").removeClass("active");  // Remove the class on double-click
  });
});




const tabs = document.querySelectorAll('.navtab');
const contents = document.querySelectorAll('.content');
const underline = document.querySelector('.underline');

function updateUnderline() {
  const activeTab = document.querySelector('.navtab.active');
  underline.style.width = `${activeTab.offsetWidth}px`;
  underline.style.left = `${activeTab.offsetLeft}px`;
}

tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    tabs.forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
    const target = tab.getAttribute('data-target');
    contents.forEach(content => {
      if (content.id === target) {
        content.classList.add('active');
      } else {
        content.classList.remove('active');
      }
    });
    updateUnderline();
  });
});

window.addEventListener('resize', updateUnderline);
updateUnderline();
    </script>

@endsection