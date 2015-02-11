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
									<label> Nama Kompetisi
										{{ Form::text('name',empty($content)?'':$content->name,array('placeholder' => 'Ketikkan nama kompetisi'))}}
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
				name: "required"
			},
			messages:{
				name: {
					required: "Masukkan nama kompetisi"
				}
			}
		});
		$(document).foundation();
	});
	</script>
@endsection
