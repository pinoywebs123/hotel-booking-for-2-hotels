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
     background: #192a56 !important;
   }
   #sides ul {
    background: #273c75 !important;
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

  

   body {
    background-color: #fff !important;
   }

   li.dropdown a {
    color: #fff;
   }

   li.open a {
    color: #273c75;
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
                    <li class="active">
                      <a href="{{route('velez_main')}}" ><i class="glyphicon glyphicon-home"></i> Home</a>
                    </li>
                    
                    <li >
                      <a href="{{route('velez_rooms')}}" ><i class="glyphicon glyphicon-home"></i> Rooms</a>
                    </li>
                    <li >
                      <a href="{{route('velez_reports')}}" ><i class="glyphicon glyphicon-th-list"></i> Report</a>
                    </li>
                   
                    

                    <li >
                      <a href="{{route('velez_payment_personnel')}}" ><i class="glyphicon glyphicon-usd"></i> Payment Personnel</a>
                    </li>
                    
                </ul>
            </div>
           
        </nav>

        <div id="page-wrapper">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="text-center">View Reservation Details</h3>
            </div>
            <div class="panel-body">
              
             @if(Session::has('yes'))
                    <div class="alert alert-info alert-dismissable">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Information!</strong>{{Session::get('yes')}}
                    </div>
                  @endif
              
              <div class="row">
                <div class="col-md-6">
                  <ul class="list-group">
                      <li class="list-group-item">Name: {{$find->user->fname}} {{$find->user->lname}}</li>
                      <li class="list-group-item">Room Type:{{$find->room->category->category_name}} </li>
                      <li class="list-group-item">Room No#: {{$find->room_id}}</li>
                      <li class="list-group-item">Price: {{$find->room->category->price}}</li>
                      <li class="list-group-item">Number of Days: {{$days}}</li>
                      <li class="list-group-item">Additional Occupants : {{$find->occupants - $find->room->category->person}} </li>
                    </ul>

                    

                    

                 
               </div>

                 <div class="col-md-6">
                    <ul class="list-group">
                      <li class="list-group-item">Bill: {{$find->bill}}</li>
                      <li class="list-group-item">Check-in-time: {{$find->check_in_time}}</li>
                      <li class="list-group-item">Check-in-date: {{$find->check_in}}</li>
                      <li class="list-group-item">Check-out-date: {{$find->check_out}}</li>
                    </ul>
                 </div>

              </div>

              
               
            </div>
          </div>

        </div>
           

        </div>
       
       

    </div>
   

   
    <script src="{{URL::to('js/jquery.js')}}"></script>

    
    <script src="{{URL::to('js/bootstrap.min.js')}}"></script>

    
 

</body>

</html>
