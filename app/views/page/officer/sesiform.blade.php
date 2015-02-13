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
									<label> Pilih Kategori
										<select name="ms_categories_id">
											<option selected="" disabled="">Pilih Kategori</option>
											@foreach($category as $row)
											<option 
											@if(!empty($content))
												{{ $content->ms_categories_id==$row->id?'selected':'' }}
											@endif
											 value="{{ $row->id }}">{{ $row->name }}</option>
											@endforeach
										</select>
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<label> Nama Sesi Tes
										{{ Form::text('name',empty($content)?'':$content->name,array('placeholder' => 'Ketikkan nama sesi tes'))}}
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<label> Mulai Sesi Tes
										<?php
										$mulai = '';
										$selesai = '';
										if(!empty($content))
										{
											$date = strtotime($content->mulai);
											$mulai = date('Y-m-d H:i',$date);
											$date = strtotime($content->selesai);
											$selesai = date('Y-m-d H:i',$date);
										}
										 ?>
										{{ Form::text('mulai',$mulai,array('placeholder' => 'yyyy-mm-dd H:M','id' => 'mulai'))}}
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<label> Selesai Sesi Tes
										{{ Form::text('selesai',$selesai,array('placeholder' => 'yyyy-mm-dd H:M',
										'id' => 'selesai'))}}
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
	{{ HTML::style('assets/js/datetimepicker/jquery.simple-dtpicker.css') }}
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
				name: "required",
				mulai: "required",
				selesai: "required",
				ms_categories_id: "required",
			},
			messages:{
				name: {
					required: "Masukkan nama sesi tes"
				},
				selesai: {
					required: "Masukkan waktu selesai sesi tes"
				},
				mulai: {
					required: "Masukkan mulai selesai sesi tes"
				},
				ms_categories_id: {
					required: "Pilih kategori"
				},
			}
		});
		$(document).foundation();
	});
	</script>

	{{ HTML::script('assets/js/datetimepicker/jquery.simple-dtpicker.js') }}
	<script type="text/javascript">
	$('#mulai').appendDtpicker({
			"locale": "id"
	});
	$('#selesai').appendDtpicker({
			"locale": "id"
	});
	</script>
@endsection
