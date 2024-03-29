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
						<hr>
						<div class="row">
							<div class="columns">
								<a href="{{ URL::to('competition/category/add') }}" class="button tiny">+&nbsp; Tambahkan</a>
							</div>
						</div>
						<table>
							<thead>
								<tr>
									<th class="large-1">No</th>
									<th class="large-3">Nama</th>
									<th class="large-3">Deskripsi</th>
									<th class="large-3">Kompetisi</th>
									<th class="large-2">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=1; ?>
								@foreach($content as $row)
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ $row->name }}</td>
									<td><a href="#" data-reveal-id="myModal" onclick="getDescription({{ $row->id }})" class="tiny button">Selengkapnya</a></td>
									<td>{{ $row->competitions->name }}</td>
									<td>
										<a href="{{URL::to('/competition/category/edit/'.$row->id)}}"><i class="fi-pencil"></i></a>&nbsp;&nbsp;&nbsp;
										<a href="{{URL::to('/competition/category/destroy/'.$row->id)}}"><i class="fi-trash"></i></a>
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
	  <h4 id="desc-name">Awesome. I have it.</h4>
	  <p id="desc-description">I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>
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
		function getDescription(val){
    		$.get("{{ url('api/getDescription') }}", { x: val },
      			function(data) {
      				$('#desc-name').html(data.name);
      				$('#desc-description').html(data.description);
      				
      			}
      		);
    	}

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
    	$(document).foundation();
    	
	});
</script>
@endsection
