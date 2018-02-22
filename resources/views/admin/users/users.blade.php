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
                    <li >
                      <a href="{{route('admin_reports')}}" ><i class="glyphicon glyphicon-th-list"></i> Report</a>
                    </li>
                   
                    <li class="active">
                      <a href="{{route('admin_users')}}" ><i class="glyphicon glyphicon-th-list"></i> Users</a>
                    </li>
                    
                     <!-- <li >
                      <a href="{{route('admin_payment_personnel')}}" ><i class="glyphicon glyphicon-usd"></i> Payment Personnel</a>
                    </li> -->
                </ul>
            </div>
           
        </nav>

        <div id="page-wrapper">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="text-center">Users List</h3>
            </div>
            <div class="panel-body">
              @if(Session::has('yes'))
                    <div class="alert alert-info alert-dismissable">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Information!</strong>{{Session::get('yes')}}
                    </div>
                  @endif

                
              
              <ul class="nav nav-tabs">
              <li role="presentation" class="active"><a href="{{route('admin_users')}}">Admin</a></li>
              <li role="presentation"><a href="{{route('admin_customers')}}">Customer</a></li>
              
            </ul>   
           <a href="{{route('admin_new_me')}}" class="btn btn-default">New Admin</a>
              <table class="table">
                  <thead>
                    <tr>
                      <th>Hotel</th>
                      <th>Username</th>
                      <th>Name</th>
                      <th>Contact</th>
                      <th>Email</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  @foreach($users as $user)
                    <tr class="{{$user->status_id == 0 ? 'alert alert-danger': ''}}">
                      <td>
                        @if($user->role_id == 3)
                          Margerate 
                        @else
                          Velez
                        @endif
                      </td>
                       <td>{{$user->username}}</td> 
                      <td>{{$user->fname}} {{$user->lname}}</td>
                      <td>{{$user->contact}}</td>
                      <td>{{$user->email}}</td>
                      <td>
                        <form action="{{route('admin_lock_me', ['id'=> $user->id])}}" method="get" id="formDel{{$user->id}}">
                          <button type="button" value="{{$user->id}}" class="btn btn-danger btn-xs delMe"><i class="glyphicon glyphicon-lock"></i></button>
                        </form>
                      
                      </td>
                    </tr>
                  @endforeach
              </table>
            </div>
          </div>

        </div>
           

        </div>
       
       
    
      

    </div>
   

   
    <script src="{{URL::to('js/jquery.js')}}"></script>

    
    <script src="{{URL::to('js/bootstrap.min.js')}}"></script>
    <script src="{{URL::to('js/sweet.js')}}"></script> 
    
 <script type="text/javascript">
    $(document).ready(function(){
        $(".delMe").click(function(){
            var id_to_del = $(this).attr("value");

            swal({
              title: "Are You Sure??",
              text: "Once Account Lock, Customer can no longer access his/her account" ,
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
             
              if (willDelete) {
                swal("Yehey! Room has been successfully deleted!", {
                  icon: "success", 
                });
                 $("#formDel" + id_to_del).submit();
                
              } 
            });
        });
       
    });
</script>
    
 

</body>

</html>
