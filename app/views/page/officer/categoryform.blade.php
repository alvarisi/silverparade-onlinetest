@extends('layouts.home')

@section('content')
	<div class="container">
		@include('include.officer.headnav')
		<div class="row">
			<div class="small-12 large-3 columns">
				@include('include.officer.sidenav')
			</div>
			<div class="small-12 large-9 end columns">
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
									<label> Pilih Kompetisi
										<select name="ms_competitions_id">
											<option selected="" disabled="">Pilih Kompetisi</option>
											@foreach($competition as $row)
											<option 
											@if(!empty($content))
												{{ $content->ms_competitions_id==$row->id?'selected':'' }}
											@endif
											 value="{{ $row->id }}">{{ $row->name }}</option>
											@endforeach
										</select>
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<label> Nama Kategori
										{{ Form::text('name',empty($content)?'':$content->name,array('placeholder' => 'Ketikkan nama kompetisi'))}}
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<label> Deskripsi Kategori
										{{ Form::textarea('description',empty($content)?'':$content->description,array('placeholder' => 'Ketikkan deskripsi kategori'))}}
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
	{{ HTML::style('assets/js/editor/jquery-te-1.4.0.css') }}
	{{ HTML::script('assets/js/validation/jquery.validate.min.js') }}
	{{ HTML::script('assets/js/editor/jquery-te-1.4.0.min.js') }}
	<style>
	.jqte_tool.jqte_tool_1 .jqte_tool_label{
		height: 25px;
	}
	</style>
@endsection

@section('custom-footer')
	<script type="text/javascript">
	$(document).ready(function(){
		$("textarea").jqte();
		$('#myForm').validate({
			rules:{
				name: "required",
				description: "required",
				ms_competitions_id: "required",
			},
			messages:{
				name: {
					required: "Masukkan nama kategori"
				},
				description: {
					required: "Masukkan deskripsi kategori"
				},
				ms_competitions_id: {
					required: "Pilih kategori kompetisi"
				},
			}
		});
		$(document).foundation();
	});
	</script>
@endsection
