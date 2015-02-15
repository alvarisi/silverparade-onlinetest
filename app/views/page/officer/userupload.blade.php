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

						{{ Form::open(array('url'=>Request::url(), 'method' => 'post','id' => 'myForm','files' => true))}}
							<div class="row">
								<div class="large-12 columns">
									<label> File <em>(download <a href="{{ URL::to('template/user') }}" target="_blank">template</a>)</em>
										{{ Form::file('file')}}
									</label>
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
		$('#myForm').validate({
			rules:{
				file: {
					required:true,
					extension: "xls"
				}
			},
			messages:{
				file:{
					required: "File tidak boleh kosong",
					extension: "Pilih file hanya file spreadsheet(.xls)"
				}
			}
		});
	});
	$(document).foundation();
	</script>
@endsection
