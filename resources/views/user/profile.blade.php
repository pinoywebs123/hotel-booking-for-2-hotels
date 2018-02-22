<!DOCTYPE html>
<html>
    <head>
        <title>Bais City Pension Houses</title>
        <link rel="stylesheet" type="text/css" href="{{URL::to('css/bootstrap.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{URL::to('user/style.css')}}">
        <link rel="stylesheet" type="text/css" href="{{URL::to('user/style2.css')}}">
        <link rel="stylesheet" type="text/css" href="{{URL::to('user/style5.css')}}">
    </head>
    <body>
        <header>
            <h1>Twin Lodge</h1>
        </header>
        
        <aside>
            
            
            <h2>SELECTED</h2>
            
            <div id="tbl">
                <table>
                    <tr >
                        <td><a href="{{route('customer_activity')}}" >ACTIVITY</a></td>
                        <td><a href="{{route('customer_setting')}}">SETTINGS</a></td>
                    </tr>

                    <tr>
                        <td><a class="active" href="{{route('customer_profile')}}">PROFILE</a></td>
                        <td></td>
                    </tr>
                </table>
            </div>
            
            @if(Auth::check())
                @if(Auth::user()->role_id == 2)
                     <div id="main">
                        <a href="{{route('customer_logout')}}">LOG OUT</a>
                    </div>
                @endif

              @endif
        </aside>
        
        <section>
            <nav>
                <a href="{{route('customer_home')}}">HOME</a>
                
                
                <a href="{{route('customer_activity')}}" class="active">MY ACTIVITY</a>
                @endif
            </nav>
            
           <div class="col-md-12">
                <h1 class="text-center">USER PROFILE</h1>
                 @if(Auth::check())
                    @if(Auth::user()->role_id == 2)
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="text-center">Personal Information</h3>
                                <ul class="list-group">
                                  <li class="list-group-item">Name: {{Auth::user()->fname}} {{Auth::user()->lname}}</li>
                                  <li class="list-group-item">Contact: {{Auth::user()->contact}}</li>
                                  <li class="list-group-item">Email: {{Auth::user()->email}}</li>
                                  <li class="list-group-item">Username: {{Auth::user()->username}}</li>
                                  
                                </ul>
                            </div>
                             <div class="col-md-6">
                                <h3 class="text-center">Update Information</h3>
                               @if(Session::has('ok'))
                                <div class="alert alert-info alert-dismissable">
                                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                  {{Session::get('ok')}}
                                </div>
                              @endif
                  


                                <form action="{{route('customer_update_info')}}" method="POST">
                                    <div class="form-group {{$errors->has('fname')? 'has-error': ''}}">
                                        <label>First Name</label>
                                        <input type="text" name="fname" class="form-control" value="{{Auth::user()->fname}} " required="">
                                    </div>
                                    <div class="form-group {{$errors->has('fname')? 'has-error': ''}}">
                                        <label>Last Name</label>
                                        <input type="text" name="lname" class="form-control" value="{{Auth::user()->lname}}" required="">
                                    </div>
                                    <div class="form-group {{$errors->has('contact')? 'has-error': ''}}">
                                        <label>Contact</label>
                                        <input type="text" name="contact" class="form-control" value="{{Auth::user()->contact}}" required="">
                                    </div>
                                    <div class="form-group {{$errors->has('email')? 'has-error': ''}}">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" value="{{Auth::user()->email}}" required="">
                                    </div>
                                    {{csrf_field()}}
                                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                                </form>
                            </div>
                        </div>
                    @endif

                  @endif
            </div>
            
          
           
        </section>
        
        <div class="clearer"></div>
    </body>
    <script src="{{URL::to('js/jquery.js')}}"></script>
    <script src="{{URL::to('js/bootstrap.min.js')}}"></script>
   
</html>