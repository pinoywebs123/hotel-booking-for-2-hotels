<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bais City Hotel</title>

    
    <link href="{{URL::to('css/bootstrap.min.css')}}" rel="stylesheet">

   
    <link href="{{URL::to('css/sb-admin.css')}}" rel="stylesheet">

   
    <link href="{{URL::to('css/plugins/morris.css')}}" rel="stylesheet">

 

<style type="text/css">
    #txt{
        font-size: 48px;
    }
    .navbar {
     background: #10ac84 !important;
   }
   #sides ul {
    background: #009432 !important;
   }

   #sides ul li a{
    color: #fff !important;
   }

   body {
    background: #2c3e50;
   }
   span{
    font-size: 40px;
   }

   li.dropdown a {
    color: #fff;
   }

   li.open a {
    color: #273c75;
   }
  

   body {
    background-color: #fff !important;
   }
</style>

</head>

<body>

    <div id="wrapper">

       
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
           
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#" data-toggle="modal" data-target="#test"></a>
            </div>
            
            <ul class="nav navbar-right top-nav">
               
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{Auth::user()->email}} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                       
                        
                        <li>
                            <a href="{{route('admin_profile')}}"><i class="fa fa-fw fa-gear"></i> Profile</a>
                        </li>
                         <li>
                            <a href="{{route('admin_settings')}}"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{route('logout')}}"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
           
            <div class="collapse navbar-collapse navbar-ex1-collapse" id="sides">
                <ul class="nav navbar-nav side-nav">
                	<li>
                       <a href="#">
                          <p class="text-center" style="color: #fff">{{Auth::user()->fname}} {{Auth::user()->lname}}</p>
                          
                       
                       </a>
                    </li>
                    <li >
                      <a href="{{route('admin_main')}}" ><i class="glyphicon glyphicon-home"></i> Home</a>
                    </li>
                    
                    <li >
                      <a href="{{route('admin_rooms')}}" ><i class="glyphicon glyphicon-home"></i> Room Maps</a>
                    </li>
                    <li class="active">
                      <a href="{{route('admin_reports')}}" ><i class="glyphicon glyphicon-th-list"></i> Report</a>
                    </li>
                      
                    <li >
                      <a href="{{route('admin_users')}}" ><i class="glyphicon glyphicon-th-list"></i> Users</a>
                    </li>
                    
                     <li >
                      <a href="{{route('admin_payment_personnel')}}" ><i class="glyphicon glyphicon-usd"></i> Payment Personnel</a>
                    </li>
                </ul>
            </div>
           
        </nav>

        <div id="page-wrapper">
          <ul class="nav nav-tabs">
          <li role="presentation" ><a href="{{route('admin_reports')}}">Reservation</a></li>
          <li role="presentation" ><a href="{{route('admin_checkin')}}">Check-in</a></li>
          <li role="presentation" class="active"><a href="{{route('admin_checkout')}}">Check-out</a></li>
           <li role="presentation" ><a href="{{route('admin_cancel')}}">Cancelattion</a></li>
          
           
         
        </ul>
         <button type="button" class="btn btn-primary btn-xs pull-right"><i class="glyphicon glyphicon-print" id="printHotel"></i></button>

         <table class="table">
            <thead>
              <tr>
                <td>Hotel</td>
                <td>Name</td>
                <td>Room Type</td>
                <td>Room #</td>
                <td>Check-In Time</td>
                <td>Check-In Date</td>
                <td>Check-Out Date</td>
                <td>Check-Out-Time</td>
              </tr>
            </thead>

            <tbody>
              @foreach($cat as $ca)
                <tr>
                  <td>
                    @if($ca->room->category->hotel_id == 1)
                      Margareta
                    @else
                      Velez
                    @endif
                  </td>
                  <td>{{$ca->user->fname}} {{$ca->user->lname}}</td>
                  <td>{{$ca->room->category->category_name}}</td>
                  <td>{{$ca->room_id}}</td>
                  <td>{{$ca->check_in_time}}</td>
                  <td>{{$ca->check_in}}</td>
                  <td>{{$ca->check_out}}</td>
                  <td>{{$ca->updated_at}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>

          
        </div>
           

        </div>
       
       

    </div>
   

   
    <script src="{{URL::to('js/jquery.js')}}"></script>

    
    <script src="{{URL::to('js/bootstrap.min.js')}}"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        $("#printHotel").click(function(){
          window.print();
        });

      });
    </script>
 

</body>

</html>
