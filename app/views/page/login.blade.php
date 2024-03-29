@extends('layouts.home')

@section('content')
	<div class="container">
		<div class="row">
			<div class="small-12 large-4 large-offset-4 end columns">
				<div class="panel login-head">
					<div class="">
						<a href="{{ URL::to('/') }}"><img src="{{ asset('assets/img/logo.png') }}" width="170" ></a>
					</div>
				</div>
				<div class="panel login-form">
					{{ Form::open(array('url' => URL::to('login'), 'method' => 'post'))}}
						<div class="row">
							<div class="large-12 columns">
								<label>
									Username
									<input type="text" placeholder="Username" name="username" />
								</label>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<label>
									Password
									<input type="password" name="password" placeholder="Password" />
								</label>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<input id="checkbox1" type="checkbox" name="remember_me" value="1"><label for="checkbox1">Ingat Saya</label>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<input type="submit" class="button tiny" value="Masuk" />
							</div>
						</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@endsection

@section('custom-head')
	<style>
	body{
		background-color: #d9d9d9;
	}
	</style>
	{{ HTML::script('assets/js/validation/jquery.validate.min.js') }}
@endsection


@section('custom-footer')
	<script type="text/javascript">
	$(document).ready(function(){
		$('form').validate({
			rules:{
				username: "required",
				password: "required",
			},
			messages:{
				username: {
					required: "Username harus diisi."
				},
				password: {
					required: "Password harus diisi."
				},
			}
		});
		$(document).foundation();
	});
	</script>
@endsection