@extends('layouts.home')

@section('content')
	<div class="container">
		@include('include.officer.headnav')
		<div class="row">
			<div class="small-12 large-3 columns">
				@include('include.user.sidenav')
			</div>
			<div class="small-12 large-9 end columns">
				<div class="row">
					<div class="panel side-content">
						<h5 class="head text-center">{{ $title }}</h5>
						<fieldset>
							<div class="row">
								<div class="large-3">Waktu Server :</div> <div class="large-8 end"><label id="currenttime">&nbsp;</label></div>
							</div>
						</fieldset>
						<hr>
						<table>
							<thead>
								<tr>
									<th class="large-1">No</th>
									<th class="large-3">Nama Tes</th>
									<th class="large-3">Kategori</th>
									<th class="large-2">Mulai</th>
									<th class="large-2">Selesai</th>
									<th class="large-1">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=1;
								date_default_timezone_set('Asia/Jakarta'); ?>
								@foreach($content->usersesi as $row)
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ $row->sesi->name }}</td>
									<td><a href="#" data-reveal-id="myModal" onclick="getSesi({{ $row->sesi->id }})" class="tiny button">Selengkapnya</a></td>
									<td>{{ $row->sesi->mulai }}</td>									
									<td>{{ $row->sesi->selesai }}</td>
									<td>
										@if($row->logsesi()->count() == 0)
											@if(new DateTime($row->sesi->selesai) > new DateTime("now"))
											
											<?php
												$date = strtotime($row->sesi->mulai);
												$mulai = date('F j, Y  H:i:s',$date);
												// $mulai = date('Y,n,j,H,i,s',$date);
												$date = strtotime($row->sesi->selesai);
												$selesai = date('F j, Y  H:i:s',$date);
											 ?>
											<a href="{{ URL::to('user/test/info/'.$row->id) }}" class="button tiny radius success execute" data-mulai='{{ $mulai }}' data-selesai='{{ $selesai }}'>Execute</a>
											@else
											<em>Expired</em>
											@endif
										@else
											@if($row->logsesi->selesai == '0000-00-00 00:00:00')
											<?php
												$date = strtotime($row->sesi->mulai);
												$mulai = date('F j, Y  H:i:s',$date);
												// $mulai = date('Y,n,j,H,i,s',$date);
												$date = strtotime($row->sesi->selesai);
												$selesai = date('F j, Y  H:i:s',$date);
											 ?>
											<a href="{{ URL::to('user/test/info/'.$row->id) }}" class="button tiny radius alert execute" data-mulai='{{ $mulai }}' data-selesai='{{ $selesai }}'>Lanjutkan</a>

											@else
											<em>Selesai</em>
											@endif
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="myModal" class="reveal-modal" data-reveal>
	  <h4 id="desc-name">-</h4>
	  <p>
	  	Topik : <div id="desc-category">
	  		
	  	</div>
	  </p>
	  <p>Deksripsi: <div id="desc-description">-</div></p>
	  <a class="close-reveal-modal">&#215;</a>
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

	function getSesi(val){
    	$.get("{{ url('api/getSesi') }}", { x: val },
      		function(data) {
      			$('#desc-name').html(data.name);
      			$('#desc-category').html(data.categories.name);
      			$('#desc-description').html(data.categories.description);
      			console.log(data);
      		}
      	);
    }

	$('.execute').each(function(){
			// var x = this.getAttribute('data-mulai');
			// console.log(x);
			// console.log(this.getAttribute('data-selesai'));
			$(this).css('display','none');
		});
	$(document).ready(function() {
    	$('table').DataTable({
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
    	setInterval("clock()", 1000);
		
	});
	

		
		var currenttime = '<?php date_default_timezone_set('Asia/Jakarta'); print date("F d, Y H:i:s", time())?>'; 
		var serverdate=new Date(currenttime);
		console.log(serverdate.getMonth());
		function padlength(what){
			var output=(what.toString().length==1)? "0"+what : what;
			return output;
		}
		var timestring='';
		function clock(){
			serverdate.setSeconds(serverdate.getSeconds()+1);
			timestring=padlength(""+serverdate.getFullYear()+"-" + (serverdate.getMonth()+1) +"-" +serverdate.getDate()+" "+ serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds()+"");
			$('#currenttime').html(timestring);
			$('.execute').each(function(){
				var x = this.getAttribute('data-mulai');
				var y = this.getAttribute('data-selesai');
				var m = new Date(x);
				var s = new Date(y);

				if(new Date(x) < new Date(serverdate) && new Date(y) > new Date(serverdate))
				{
					$(this).removeAttr('style');
				}

			});

		}
    	$(document).foundation();

</script>
@endsection
