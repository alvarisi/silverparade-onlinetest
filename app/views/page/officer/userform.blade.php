@extends('layouts.home')

@section('content')
	<div class="container">
		@include('include.officer.headnav')
		<div class="row">
			<div class="small-12 large-3 columns">
				@include('include.officer.sidenav')
			</div>
			<div class="small-12 large-8 end columns">
				<div class="row">
					<div class="panel side-content">
						<h5 class="head text-center">{{ $title }}</h5>
						@if(Session::has('success'))
						<div class="row">
							<div data-alert class="alert-box success">
								<p>
									{{ Session::get('success') }}
								</p>
								<a href="#" class="close">&times;</a>
							</div>
						</div>
						@endif
						{{ Form::open(array('url'=>Request::url(), 'method' => 'post','id' => 'myForm'))}}
							<div class="row">
								<div class="large-12 columns">
									<label> Nama Pengguna
										{{ Form::text('name',empty($content)?'':$content->name,array('placeholder' => 'Ketikkan nama pengguna'))}}
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<label> Username Pengguna
										{{ Form::text('username',empty($content)?'':$content->username,array('placeholder' => 'Ketikkan nama username',!empty($content)?('disabled'):''))}}
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<label> Password Pengguna
										@if(empty($content))
										{{ Form::password('password',array('placeholder' => 'Ketikkan password pengguna','id' => 'password','minlength' => '6'))}}

										@else
										<a href="{{ URL::to('/user/reset/'.$content->id) }}" class="button tiny alert">Reset Password</a>
										@endif
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<label> Email Pengguna
										{{ Form::text('email',empty($content)?'':$content->email,array('placeholder' => 'Ketikkan email pengguna'))}}
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									 <input id="enabled" name="enabled" type="checkbox" 
									 @if(!empty($content))
									 	{{ $content->enabled=='1'?'checked':'' }}
									 @else
									 checked
									 @endif
									  value="1"><label for="enabled">Enabled</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									{{ Form::submit('Simpan',array('class' => 'button tiny'))}}
								</div>
							</div>
						{{ Form::close() }}
					</div>
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
		function getWordCount(wordString) {
			var words = wordString.split(" ");
		  	words = words.filter(function(words) { 
		    	return words.length > 0
		  	}).length;
		  	return words;
		}

		$.validator.addMethod('oneWord',function(value, element,params){
				var count = getWordCount(value);
				if(count == 1)
				{
					return true;
				}
			},
			$.validator.format("Username hanya 1 kata.")
		);

		$('#myForm').validate({
			rules:{
				name: "required",
				username: {
					required:true,
					oneWord:true
				},
				password: "required",
				email: {
					required:true,
					email:true
				}
			},
			messages:{
				name: {
					required: "Masukkan nama pengguna"
				},
				username:{
					required: "Masukkan username pengguna"
				},
				email:{
					required: "Masukkan email pengguna"
				},
				password:{
					required: "Masukkan password pengguna",
					minlength: "Minimal {0} karakter"
				}
			}
		});
		$(document).foundation();
	});
	</script>
@endsection
