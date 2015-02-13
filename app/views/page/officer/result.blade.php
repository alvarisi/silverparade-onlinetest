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
							{{ Form::open(array('url'=>URL::to('/test/result'), 'method' => 'post','id' => 'myForm'))}}
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
						</div>

						<table class="dt">
							<thead>
								<tr>
									<th class="large-1">No</th>
									<th class="large-3">Nama</th>
									<th class="large-2">Mulai</th>
									<th class="large-2">Selesai</th>
									<th class="large-2">Lama</th>
									<th class="large-1">Point</th>
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
									<td>{{ $row->logsesi->mulai }}</td>
									<td>{{ $row->logsesi->selesai }}</td>
									<td>
										<?php 
										$mulai = new DateTime($row->logsesi->mulai);
										$selesai = new DateTime($row->logsesi->selesai);
										$interval = $mulai->diff($selesai)

										?>
										{{ $interval->format('%H:%I:%s'); }}
									</td>
									<td>
										<?php 
										$points = 0;
										foreach ($row->logsesi->answers as $v) {
											if($v->answer == $v->question->theAnswer)
											{
												$points++;
											}
										}
										?>
										{{ $points }}
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
	});
</script>
@endsection
