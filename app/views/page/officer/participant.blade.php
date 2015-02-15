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
						<hr>
						<div class="row">
							{{ Form::open(array('url'=>URL::to('/test/participant'), 'method' => 'post','id' => 'myForm'))}}
							<div class="large-4 columns">
								<label>
									<select name="ms_categories_id" id="ms_categories_id">
										<option selected="" disabled="">Pilih Kategori</option>
										@foreach($data['categories'] as $row)
										<option value="{{ $row->id }}">{{ $row->name }}</option>
										@endforeach
									</select>
								</label>
							</div>
							<div class="large-4 columns">
								<label>
									<select name="tr_sesi_id" id="tr_sesi_id">
										<option selected="" disabled="">Pilih Sesi Tes</option>
									</select>
								</label>
							</div>
							<div class="large-4 columns">
								{{ Form::submit('Terapkan Filter',array('class' => 'button alert tiny radius'))}}
							</div>
							{{ Form::close() }}
							<hr>
							
						</div>
						@if(!empty($content))
						<div class="row">
							<div class="large-12 end columns">
							<table>
								<tr>
									<td>Nama Sesi Tes</td>
									<td>:</td>
									<td><b>{{ $content['sesi']->name }}</b></td>
									<td>Kategori Sesi Tes</td>
									<td>:</td>
									<td><b>{{ $content['sesi']->categories->name }}</b></td>
								</tr>
								<tr>
									<td>Waktu Mulai</td>
									<td>:</td>
									<td><b>
										<?php $date = strtotime($content['sesi']->mulai);
										$dt = date('j M y H:i',$date)
										 ?>
										{{ $dt }}
										</b>
									</td>
									<td>Waktu Selesai</td>
									<td>:</td>
									<td><b>
										<?php $date = strtotime($content['sesi']->selesai);
										$dt = date('j M y H:i',$date)
										 ?>
										{{ $dt }}
										</b>
									</td>
								</tr>
							</table>
							</div>

							<div class="large-12 columns">
								
								{{ Form::open(array('url'=> URL::to('test/participant/add'),'method' => 'post','id' => 'FormAdd' ))}}
								<fieldset>
								<div class="large-7 columns">
									<label>
										<select name="ms_users_id">
											<option selected="" disabled="">Pilih Pengguna</option>
											@foreach($content['users'] as $row)
											<option value="{{ $row->id }}">{{ $row->name }}</option>
											@endforeach
										</select>
										{{ Form::hidden('tr_sesi_id',$content['sesi']->id) }}
									</label>
								</div>
								<div class="large-4 end columns">
									<input type="submit" value="Tambahkan" class="button tiny">
								</div>
								</fieldset>
								{{ Form::close() }}
								
							</div>
						</div>

						<table class="dt">
							<thead>
								<tr>
									<th class="large-1">No</th>
									<th class="large-3">Nama</th>
									<th class="large-3">Username</th>
									<th class="large-1">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								date_default_timezone_set('Asia/Jakarta');
								$no=1;
								 ?>
								@foreach($content['sesi']->usersesi as $row)
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ $row->user->name }}</td>
									<td>{{ $row->user->username }}</td>
									<td>
										<a href="{{URL::to('/test/participant/destroy/'.$row->id)}}"><i class="fi-trash"></i></a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						@endif
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
	{{ HTML::style('assets/icons/foundation-icons.css') }}
	{{ HTML::style('assets/js/datatables/css/jquery.dataTables.min.css') }}
	{{ HTML::script('assets/js/datatables/js/jquery.dataTables.min.js') }}
	{{ HTML::script('assets/js/validation/jquery.validate.min.js') }}
@endsection

@section('custom-footer')
<script type="text/javascript">
	$(document).ready(function() {
    	$('table.dt').DataTable({
	        "language": {
	            
	        },
	        "oLanguage": {
		      "oPaginate": {
		        "sPrevious": "Sebelumnya",
		        "sNext": "Selanjutnya",
		      },
		      "sLengthMenu": "Tampilkan per : _MENU_ ",
	          "sInfoEmpty": "Maaf tidak data",
	          "sZeroRecords": "Maaf tidak data",
	          "sInfo": "Menampilkan halaman _PAGE_ dari _PAGES_",
	          "infoFiltered": "(filtered from _MAX_ total records)",
	          "sSearch" : "Pencarian :",
		    }
    	});
    	$('#ms_categories_id').change(function(){
    		$.get("{{ url('api/getSession') }}", { x: $(this).val() },
      			function(data) {
      				var select = $('#tr_sesi_id');
      				select.empty();
      				select.append($("<option></option>")
			        .attr("disabled",'')
			        .attr("selected",'')
			        .text('Pilih Sesi Tes'));
      				if(data.length == 0){
      					select.append($("<option></option>")
				        .attr("disabled",'')
				        .attr("selected",'')
				        .text('Tidak ada data'));
      				}else{
      					$.each(data,function(i, item){
      						select
      						.append($("<option></option>")
					        .attr("value",item.id)
					        .text(item.name))
      					});
      				}
      				
      			}
      		);
    	});
    	$('#myForm').validate({
			rules:{
				ms_categories_id: "required",
				tr_sesi_id: "required",
			},
			messages:{
				ms_categories_id: {
					required: "Pilih kompetisi tidak boleh kosong."
				},
				tr_sesi_id: {
					required: "Pilih sesi tidak boleh kosong."
				}
			}
		});
		$('#FormAdd').validate({
			rules:{
				ms_users_id: "required",
			},
			messages:{
				ms_users_id: {
					required: "Pilih pengguna tidak boleh kosong."
				}
			}
		});
		
	});
</script>
@endsection
