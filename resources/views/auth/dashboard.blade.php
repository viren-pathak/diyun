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
      <div class="home-debate-tabs debate-tabs">  
            <div class="row2">
                <div class="debate-col">
                    <ul class="card-grid">
                        @foreach($debateStats as $debate)
                                <div class="debate-card">
                                    <a href="{{ route('debate.single', ['slug' => $debate->slug, 'active' => $debate->id, 'from' => 'debate-card']) }}">
                                        <div class="card-img-div">
                                            <img src="{{$debate->image}}" alt="{{ $debate->title }}">
                                        </div>
                                        <div class="card-content-body">
                                            <h5 class="debate-card-title">
                                                {{$debate->title}}
                                            </h5>
                                        </div>
                                    </a>
                                    <div class="color-text-icon debate-card-stats">
                                        <div class="debate-card-stats__claims debate-card__stat">
                                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24"  height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M8 9h8"></path><path d="M8 13h6"></path>
                                                <path d="M9 18h-3a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-3l-3 3l-3 -3z"></path>
                                            </svg>
                                            <p class="m-0 card-text">{{ $debate->total_claims }}</p>
                                        </div>
                                        <div class="debate-card-stats__contributions debate-card__stat">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M290.74 93.24l128.02 128.02-277.99 277.99-114.14 12.6C11.35 513.54-1.56 500.62.14 485.34l12.7-114.22 277.9-277.88zm207.2-19.06l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.76 18.75-49.16 0-67.91z"></path>
                                            </svg>
                                            <p class="m-0 card-text">{{ $debate->total_contributions }}</p>
                                        </div>
                                        <div class="debate-card-stats__votes debate-card__stat">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 640 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M608 320h-64v64h22.4c5.3 0 9.6 3.6 9.6 8v16c0 4.4-4.3 8-9.6 8H73.6c-5.3 0-9.6-3.6-9.6-8v-16c0-4.4 4.3-8 9.6-8H96v-64H32c-17.7 0-32 14.3-32 32v96c0 17.7 14.3 32 32 32h576c17.7 0 32-14.3 32-32v-96c0-17.7-14.3-32-32-32zm-96 64V64.3c0-17.9-14.5-32.3-32.3-32.3H160.4C142.5 32 128 46.5 128 64.3V384h384zM211.2 202l25.5-25.3c4.2-4.2 11-4.2 15.2.1l41.3 41.6 95.2-94.4c4.2-4.2 11-4.2 15.2.1l25.3 25.5c4.2 4.2 4.2 11-.1 15.2L300.5 292c-4.2 4.2-11 4.2-15.2-.1l-74.1-74.7c-4.3-4.2-4.2-11 0-15.2z"></path>
                                            </svg>
                                            <p class="m-0 card-text">{{ $debate->total_votes }}</p>
                                        </div>
                                        <div class="debate-card-stats__participants debate-card__stat">
                                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                                <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                                <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                                            </svg>
                                            <p class="m-0 card-text">{{ $debate->total_participants }}</p>
                                        </div>
                                        <div class="debate-card-stats__views debate-card__stat">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 576 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"></path>
                                            </svg>
                                            <p class="m-0 card-text">{{ $debate->total_views }}</p>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
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