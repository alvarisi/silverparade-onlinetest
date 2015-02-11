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
						{{ Form::open(array('url'=>Request::url(), 'method' => 'post','id' => 'myForm','files' => 'true'))}}
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
									<label> Pertanyaan
										{{ Form::textarea('name',empty($content)?'':$content->name,array('placeholder' => 'Ketikkan pertanyaan','rows' => '2'))}}
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-6 columns">
									<label> File
										{{ Form::file('file',array())}}
										<em>*Jika terdapat file (gambar)</em>
									</label>
								</div>
								<div class="large-6 columns">
									@if(!empty($content))
										@if($content->file!='')
										<a href="{{ URL::to('upload/question/'.$content->file) }}" class="th" target="_blank">
											<img src="{{ URL::to('upload/question/'.$content->file) }}">
										</a>
										@endif
									@endif
								</div>
								<hr>
							</div>
							<div class="row">
								<div class="large-12 columns">
								<fieldset>
									<legend> Jawaban Benar</legend>

									<input type="radio" name="answer" value="1" id="1" 
									@if(!empty($content))
										{{ $content->theAnswer=='1'?'checked':'' }}
									@endif
									>
										<label for="1">Jawaban 1</label>
									<input type="radio" name="answer" value="2" id="2" 
									@if(!empty($content))
									 {{ $content->theAnswer=='2'?'checked':'' }}>
									@endif
										<label for="2">Jawaban 2</label>
									<input type="radio" name="answer" value="3" id="3"
									@if(!empty($content))
									{{ $content->theAnswer=='3'?'checked':'' }}
									@endif
									>
										<label for="3">Jawaban 3</label>
									<input type="radio" name="answer" value="4" id="4"
									@if(!empty($content))
									 {{ $content->theAnswer=='4'?'checked':'' }}
									@endif >
										<label for="4">Jawaban 4</label>
									<input type="radio" name="answer" value="5" id="5"
									@if(!empty($content))
										{{ $content->theAnswer=='5'?'checked':'' }}
									@endif >
										<label for="5">Jawaban 5</label>
									<label class="error" for="answer"></label>
								</fieldset>
								</div>
							</div>
							@if(empty($content))
							<div class="row">
								<div class="large-12 columns">
									<label> Jawaban 1
										{{ Form::text('answer1','',array('placeholder' => 'Ketikkan Jawaban 1'))}}
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<label> Jawaban 2
										{{ Form::text('answer2','',array('placeholder' => 'Ketikkan Jawaban 2'))}}
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<label> Jawaban 3
										{{ Form::text('answer3','',array('placeholder' => 'Ketikkan Jawaban 3'))}}
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<label> Jawaban 4
										{{ Form::text('answer4','',array('placeholder' => 'Ketikkan Jawaban 4'))}}
									</label>
								</div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<label> Jawaban 5
										{{ Form::text('answer5','',array('placeholder' => 'Ketikkan Jawaban 5'))}}
									</label>
								</div>
							</div>
							@else
							@foreach($content->choices as $row)
							<div class="row">
								<div class="large-12 columns">
									<label> Jawaban {{ $row->flag }}
										{{ Form::text('answer'.$row->flag,$row->name,array('placeholder' => 'Ketikkan Jawaban '.$row->flag))}}
									</label>
								</div>
							</div>
							@endforeach
							@endif
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
				name: "required",
				answer: "required",
				answer1: "required",
				answer2: "required",
				answer3: "required",
				answer4: "required",
				answer5: "required",
				ms_categories_id: "required",
			},
			messages:{
				ms_categories_id: {
					required: "Pilih kategori pertanyaan"
				},
				name: {
					required: "Masukkan pertanyaan"
				},
				answer: {
					required: "Pilih jawaban benar"
				},
				answer1: {
					required: "Masukkan jawaban 1"
				},
				answer2: {
					required: "Masukkan jawaban 2"
				},
				answer3: {
					required: "Masukkan jawaban 3"
				},
				answer4: {
					required: "Masukkan jawaban 4"
				},

				answer5: {
					required: "Masukkan jawaban 5"
				},


			},

		});
		$(document).foundation();
	});
	</script>
@endsection
