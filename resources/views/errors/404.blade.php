<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>404</title>

  <style id="" media="all">
@import url("https://fonts.googleapis.com/css?family=Montserrat:400,400i,700");


main {
  align-items: center;
  display: flex;
  flex-direction: column;
  height: 100vh;
  justify-content: center;
  text-align: center;
  font-family: 'Montserrat', sans-serif;
}

h1 {
  color: #133153;
  font-size: 12.5rem;
  letter-spacing: .10em;
  margin: .025em 0;
  text-shadow: .05em .05em 0 rgba(0,0,0,.25);
  white-space: nowrap;
  
  @media(max-width: 30rem) {
    font-size: 8.5rem;
  }
  
  & > span {
    animation: spooky 2s alternate infinite linear;
    color: #133153;
    display: inline-block;
  }
}

h2.error-h2 {
  color: #133153;
  margin-bottom: .40em;
}

p.error-txt {
  color: #133153;
  margin-top: 0;
}

a.error-btn{
    background: #133153;
    font-size:14px;
    font-weight:600;
    font-family:sans-serif;
    color: #fff;
    text-decoration: none;
    padding: 10px 15px;
    border: 1px solid #133153;
    border-radius: 6px;
    cursor:pointer;
}

a.error-btn:hover{
    background: #fff;
    color: #133153;
}

@keyframes spooky {
  from {
    transform: translatey(.15em) scaley(.95);
  }
  
  to {
    transform: translatey(-.15em);
  }
}
  </style>
</head>

<body>
    <main>
        <h1 class="404-heading">4<span><i class="fa fa-search" aria-hidden="true"></i></span>4</h1>
        <h2 class="error-h2">Error: 404 page not found</h2>
        <p class="error-txt">Sorry, the page you're looking for cannot be accessed</p>
        <a href="/" class="error-btn">Go to Home</a>
    </main>
</body>

</html>