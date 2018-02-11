<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
  <title>Monina RM Midtown</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
   .navbar{
    background: #2ecc71 !important;
  }
  .navbar-default .navbar-nav>li>a {
    color: #fff !important;
  }
  
  body {
      font: 400 15px/1.8 Lato, sans-serif;
      color: #777;
  }
  h3, h4 {
      margin: 10px 0 30px 0;
      letter-spacing: 10px;      
      font-size: 20px;
      color: #111;
  }
  .container {
      padding: 80px 120px;
  }
  .person {
      border: 10px solid transparent;
      margin-bottom: 25px;
      width: 80%;
      height: 80%;
      opacity: 0.7;
  }
  .person:hover {
      border-color: #f1f1f1;
  }
  .carousel-inner img {
      -webkit-filter: grayscale(90%);
      filter: grayscale(90%); /* make all photos black and white */ 
      width: 100%; /* Set width to 100% */
      margin: auto;
  }
  .carousel-caption h3 {
      color: #fff !important;
  }
  @media (max-width: 600px) {
    .carousel-caption {
      display: none; /* Hide the carousel text when the screen is less than 600 pixels wide */
    }
  }
  .bg-1 {
      background: #2d2d30;
      color: #bdbdbd;
  }
  .bg-1 h3 {color: #fff;}
  .bg-1 p {font-style: italic;}
  .list-group-item:first-child {
      border-top-right-radius: 0;
      border-top-left-radius: 0;
  }
  .list-group-item:last-child {
      border-bottom-right-radius: 0;
      border-bottom-left-radius: 0;
  }
  .thumbnail {
      padding: 0 0 15px 0;
      border: none;
      border-radius: 0;
  }
  .thumbnail p {
      margin-top: 15px;
      color: #555;
  }
  .btn {
      padding: 10px 20px;
      background-color: #333;
      color: #f1f1f1;
      border-radius: 0;
      transition: .2s;
  }
  .btn:hover, .btn:focus {
      border: 1px solid #333;
      background-color: #fff;
      color: #000;
  }
  .modal-header, h4, .close {
      background-color: #333;
      color: #fff !important;
      text-align: center;
      font-size: 30px;
  }
  .modal-header, .modal-body {
      padding: 40px 50px;
  }
  .nav-tabs li a {
      color: #777;
  }
  #googleMap {
      width: 100%;
      height: 400px;
      -webkit-filter: grayscale(100%);
      filter: grayscale(100%);
  }  
  .navbar {
      font-family: Montserrat, sans-serif;
      margin-bottom: 0;
      background-color: #2d2d30;
      border: 0;
      font-size: 11px !important;
      letter-spacing: 4px;
      opacity: 0.9;
  }
  .navbar li a, .navbar .navbar-brand { 
      color: #d5d5d5 !important;
  }
  .navbar-nav li a:hover {
      color: #fff !important;
  }
  .navbar-nav li.active a {
      color: #fff !important;
      background-color: #29292c !important;
  }
  .navbar-default .navbar-toggle {
      border-color: transparent;
  }
  
  footer {
      background-color: #2d2d30;
      color: #f5f5f5;
      padding: 32px;
  }
  footer a {
      color: #f5f5f5;
  }
  footer a:hover {
      color: #777;
      text-decoration: none;
  }  
  .form-control {
      border-radius: 0;
  }
  .navbar-default .navbar-brand{
    color: #fff !important;
  }
  h5 {
    font-size: 25px;
 }
  </style>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#myPage">Bais Hotel Booking</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="{{route('customer_home')}}">Hotels</a></li>
        
        <li><a href="{{route('customer_activity')}}">ACTIVITY</a></li>
        <li><a href="{{route('customer_logout')}}">LOGOUT</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  
  
      <h1 class="text-center" style="margin-bottom: 5%;">Margareta Lodge and Resort</h1>
      <h2 class="text-center">Room Category</h2>

      @if(Session::has('ok'))
        <div class="alert alert-success">
          {{Session::get('ok')}}
        </div>
      @endif
       @if(Session::has('no'))
        <div class="alert alert-danger">
          {{Session::get('no')}}
        </div>
      @endif
      <div class="row">
        
        <div class=" well">
          <div class="row">
            <form action="{{route('customer_book_now', ['id'=> $cat->id])}}" method="POST">
            <div class="col-md-5">
              <p class="text-center">
               
                <button type="submit" class="btn btn-success btn-lg">BOOK NOW</button>
              </p>

              <h5>Package</h5>
              <ul>
                <li>Free Wifi</li>
                <li>Meal</li>
              </ul>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label>Select Room Number</label>
                <select name="room_number" class="form-control" required="">
                  @foreach($cat->rooms as $aw)

                    <option value="{{$aw->room_number}}">{{$aw->room_number}}</option>              
                  @endforeach

                </select>
              </div>

              <div class="form-group">
               <label>Check-in Time</label>
               <input type="time" name="check_in_time" class="form-control" required="">
              </div>

              <div class="form-group">
               <label>Check-in Date</label>
               <input type="date" name="check_in_date" class="form-control" required="">
              </div>

              <div class="form-group">
               <label>Check-out Date</label>
               <input type="date" name="check_out_date" class="form-control" required="">
              </div>
            </div>
            {{csrf_field()}}
           </form>
          </div>

          
        </div>
      </div>


          
</div>











</body>
</html>
