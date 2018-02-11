@extends('default.template')

@section('styles')
<style type="text/css">
	#loginForm{
		margin-top: 5%;
	}
	 a small {
		color: gray;
	}
	body{
		background: #2ecc71;
	}

	
</style>

@endsection


@section('contents')
	<div class="col-md-4 col-md-offset-4" id="loginForm">
		 <p class="text-center"><a href="{{url('/')}}"><img src="{{URL::to('image/icon.png')}}"  height="120px"></a></p>   
		<div class="panel panel-success">
			<div class="panel-heading">
				<h4 class="text-center">Login Form</h4>
			</div>
			<div class="panel-body">
						@if(Session::has('error'))
                            <div class="alert alert-danger">
                              
                              {{Session::get('error')}}
                            </div>
                          @endif
                          @if(Session::has('reg'))
                            <div class="alert alert-success alert-dismissable">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              {{Session::get('reg')}}
                            </div>
                          @endif


				<form action="{{route('loginCheck')}}" method="POST">
					<div class="form-group {{$errors->has('username') ? 'has-error': ''}}">
						<label for="username">Username</label>
						<input type="text" name="username" id="username" class="form-control" maxlength="12">
						@if($errors->has('username'))
							<span class="help-block">{{$errors->first('username')}}</span>
						@endif
					</div>

					<div class="form-group {{$errors->has('password') ? 'has-error': ''}}">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" class="form-control" maxlength="12">
						@if($errors->has('password'))
							<span class="help-block">{{$errors->first('password')}}</span>
						@endif
					</div>

					<div class="form-group">
						<label>Remember</label>
						<input type="checkbox" name="remember" >
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success btn-block ">Sign-in</button>
						{{csrf_field()}}
					</div>
					<center><a href="{{route('register')}}"><small>Sign-Up</small></a></center>
				</form>
			</div>
		</div>
	</div>
@endsection


@section('scripts')

@endsection