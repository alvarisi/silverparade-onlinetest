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
						@if(Session::has('success') || Session::has('failed'))
						<div class="row">
							<div data-alert class="alert-box columns {{ Session::has('success')?'success':'alert' }}">
								<p>
									{{ Session::has('success')?Session::get('success'):Session::get('failed') }}
								</p>
								<a href="#" class="close">&times;</a>
							</div>
						</div>
						@endif
						{{ Form::open(array('url'=>Request::url(), 'method' => 'post','id' => 'myForm'))}}							
							<div class="row">
								<div class="large-12 columns">
									<label> Password Lama
										{{ Form::password('password',array('placeholder' => 'Ketikkan password lama anda','id' => 'password'))}}
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<label> Password Baru
										{{ Form::password('npassword',array('placeholder' => 'Ketikkan password baru anda','id' => 'npassword','minlength' => '6'))}}
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<label> Konfirmasi Password Baru
										{{ Form::password('cpassword',array('placeholder' => 'Ketikkan password baru anda','id' => 'cpassword'))}}
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									{{ Form::submit('Simpan',array('class' => 'button tiny'))}}
									<a class="button tiny secondary" href="{{ URL::to('officer/account') }}">Kembali</a>
									
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
				password: "required",
				npassword: "required",
				cpassword: {
					required:true,
					equalTo:'#npassword'
				}
				
			},
			messages:{
				
				password:{
					required: "Masukkan password pengguna",
					minlength: "Minimal {0} karakter"
				},
				cpassword:{
					required: "Masukkan konfirmasi password anda",
					equalTo:'Isian konfirmasi harus sama dengan password baru'
				},
				npassword:{
					required: "Masukkan password baru anda",
					minlength: "Minimal {0} karakter"
				}
			}
		});
		$(document).foundation();
	});
	</script>
@endsection
