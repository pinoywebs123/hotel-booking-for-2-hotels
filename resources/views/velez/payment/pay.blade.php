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
                            <a href="{{route('velez_logout')}}"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
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
                      <a href="{{route('velez_main')}}" ><i class="glyphicon glyphicon-home"></i> Home</a>
                    </li>
                    
                    <li >
                      <a href="{{route('velez_rooms')}}" ><i class="glyphicon glyphicon-home"></i> Rooms</a>
                    </li>
                    <li >
                      <a href="{{route('velez_reports')}}" ><i class="glyphicon glyphicon-th-list"></i> Report</a>
                    </li>
                   
                    

                    <li class="active">
                      <a href="{{route('velez_payment_personnel')}}" ><i class="glyphicon glyphicon-usd"></i> Payment Personnel</a>
                    </li>
                    
                </ul>
            </div>
           
        </nav>

        <div id="page-wrapper">
          <div class="panel panel-primary row">
            <div class="panel-heading">
              <h3 class="text-center">Payment Personnel</h3>
            </div>
            <div class="panel-body">
              @if(Session::has('no'))
                    <div class="alert alert-danger alert-dismissable">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>OOpps!</strong>{{Session::get('no')}}
                    </div>
                  @endif

               @if(Session::has('ok'))
                    <div class="alert alert-success alert-dismissable">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Congratulations! </strong>{{Session::get('ok')}}
                    </div>
                  @endif   
               <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#paymentPersonnel">New Personnel</a>   
              <table class="table">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Contact</th>
                      <th>Position</th>
                      <th>Action</th>
                    </tr>
                  </thead>

                  <tbody>
                   @foreach($persons as $morl)
                    <tr>
                      <td>{{$morl->fname}} {{$morl->mname}} {{$morl->lname}}</td>
                      <TD>{{$morl->contact}}</TD>
                      <TD>{{$morl->position}}</TD>
                      <td>
                        <a href="{{route('velez_payment_personnel_delete', ['id'=> $morl->id])}}" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>
                      </td>
                    </tr>
                   @endforeach
                    
                  </tbody>
              </table>
            </div>
          </div>

        </div>
           

        </div>
       
       

       <div class="modal fade" id="paymentPersonnel">
         <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h3 class="text-center">Enter Personnel Information</h3>
             </div>
             <div class="modal-body">
               <form action="{{route('velez_payment_personnel_check')}}" method="POST">
                 <div class="form-group">
                   <label>First Name</label>
                   <input type="text" name="fname" id="fname" class="form-control" maxlength="20" required="">
                 </div>
                 <div class="form-group">
                   <label>Middle Name</label>
                   <input type="text" name="mname" id="mname" class="form-control" maxlength="20" required="">
                 </div>
                 <div class="form-group">
                   <label>Last Name</label>
                   <input type="text" name="lname" id="lname" class="form-control" maxlength="20" required="">
                 </div>
                 <div class="form-group">
                   <label>Contact#</label>
                   <input type="number" name="contact" id="contact" min="0" maxlength="15" required="" class="form-control">
                 </div>
                 <div class="form-group">
                   <label>Position</label>
                   <input type="text" name="position" id="position" class="form-control" maxlength="20" required="">
                 </div>
                 {{csrf_field()}}
                 <button type="submit" class="btn btn-success btn-block">SUBMIT</button>
               </form>
             </div>
           </div>
         </div>
       </div> 
    </div>
   

   
    <script src="{{URL::to('js/jquery.js')}}"></script>

    
    <script src="{{URL::to('js/bootstrap.min.js')}}"></script>

    
 

</body>

</html>
