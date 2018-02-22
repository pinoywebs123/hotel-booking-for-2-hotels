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
                        <td><a a class="active" href="{{route('customer_setting')}}">SETTINGS</a></td>
                    </tr>

                    <tr>
                        <td><a href="{{route('customer_profile')}}">PROFILE</a></td>
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
                 @if(Auth::check())
                <a href="{{route('customer_activity')}}" class="active">MY ACTIVITY</a>
                @endif
            </nav>
            
           <div class="col-md-12">
                <h1 class="text-center">USER SETTINGS</h1>

                @if(Auth::check())
                @if(Auth::user()->role_id == 2)
                    <div class="col-md-6 col-md-offset-3">
                         @if(Session::has('ok'))
                            <div class="alert alert-info alert-dismissable">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              {{Session::get('ok')}}
                            </div>
                          @endif
                  

                  
                        <form action="{{route('customer_password_change')}}" method="POST">
                            <div class="form-group {{$errors->has('new_password') ? 'has-error': ''}}">
                                <label>New Password</label>
                                <input type="password" name="new_password" class="form-control" maxlength="12">
                            </div>
                            <div class="form-group {{$errors->has('retype_password') ? 'has-error': ''}}">
                                <label>Re-type Password</label>
                                <input type="password" name="retype_password" class="form-control" maxlength="12">
                            </div>
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-primary">SUBMIT</button>
                        </form>
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