@extends('default.template')

@section('styles')
<style type="text/css">
	#loginForm{
		margin-top: 2%;
	}
	 a small {
		color: gray;
	}
	body{
		background: #2ecc71;
	}
	body {
	
</style>

@endsection


@section('contents')
	<div class="col-md-10 col-md-offset-1" id="loginForm">
		<p class="text-center"><a href="{{url('/')}}"><img src="{{URL::to('image/icon.png')}}" height="120px"></a></p>   
		<div class="panel panel-success">
			<div class="panel-heading">
				<h4 class="text-center">Registration Form</h4>
			</div>
			<div class="panel-body">
				<form action="{{route('registerCheck')}}" method="POST">
					<div class="row">
						@if(Session::has('reg'))
                            <div class="alert alert-success alert-dismissable">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              {{Session::get('reg')}}
                            </div>
                          @endif
						<div class="col-md-6">
						<div class="form-group {{$errors->has('fname') ? 'has-error' : ''}}">
							<label>First Name</label>
							<input type="text" name="fname" class="form-control" maxlength="20"  id="fname">
							@if($errors->has('fname'))
								<i class="help-block">{{$errors->first('fname')}}</i>
							@endif
						</div>
						<div class="form-group {{$errors->has('lname') ? 'has-error' : ''}}">
							<label>Last Name</label>
							<input type="text" name="lname" class="form-control" maxlength="20"  id="lname">
							@if($errors->has('lname'))
								<i class="help-block">{{$errors->first('lname')}}</i>
							@endif
						</div>
						<div class="form-group {{$errors->has('contact') ? 'has-error' : ''}}">
							<label>Contact</label>
							<input type="text" name="contact" class="form-control" maxlength="15" id="contact">
							@if($errors->has('contact'))
								<i class="help-block">{{$errors->first('contact')}}</i>
							@endif
						</div>
						<div class="form-group {{$errors->has('email') ? 'has-error' : ''}}">
							<label>Email</label>
							<input type="email" name="email" class="form-control" maxlength="30" id="email">
							@if($errors->has('email'))
								<i class="help-block">{{$errors->first('email')}}</i>
							@endif
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group {{$errors->has('username') ? 'has-error' : ''}}">
							<label>Username</label>
							<input type="text" name="username" class="form-control" maxlength="12" id="username">
							@if($errors->has('username'))
								<i class="help-block">{{$errors->first('username')}}</i>
							@endif
						</div>
						<div class="form-group {{$errors->has('password') ? 'has-error' : ''}}">
							<label>Password</label>
							<input type="password" name="password" class="form-control" maxlength="12" id="password">
							@if($errors->has('password'))
								<i class="help-block">{{$errors->first('password')}}</i>
							@endif
						</div>
						<div class="form-group {{$errors->has('retype_password') ? 'has-error' : ''}}">
							<label>Re-type Password</label>
							<input type="password" name="retype_password" class="form-control" maxlength="12" id="retype_password" >
							@if($errors->has('retype_password'))
								<i class="help-block">{{$errors->first('retype_password')}}</i>
							@endif
						</div>
					</div>
					</div>

					<center>
						<button type="submit" class="btn btn-success">SUBMIT</button>
						<button type="button" class="btn btn-default" id="clearBtn">CLEAR</button>
						{{csrf_field()}}
					</center>
				</form>
			</div>
		</div>
	</div>
@endsection


@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$("#clearBtn").click(function(){
			$("#fname").val("");
			$("#lname").val("");
			$("#contact").val("");
			$("#email").val("");
			$("#username").val("");
			$("#password").val("");
			$("#retype_password").val("");
		});
	});
</script>
@endsection