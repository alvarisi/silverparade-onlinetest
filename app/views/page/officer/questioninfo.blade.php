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
						<h5>{{ $title }}</h5>
						<hr>
						<b>Kategori</b>
						<p>
							{{ $content->categories->name }}
						</p>
						<b>Pertanyaan</b>
						<p>
							{{ $content->name }}
						</p>
						@if(!empty($content->file))
						<img src="{{ URL::to('upload/question/'.$content->file) }}">
						@endif
						<hr>
						<b>Jawaban </b>
						<ul class="list-choices-info">
							@foreach($content->choices as $row)
							<li>
							@if($content->theAnswer == $row->flag)
							<strong>{{ $row->flag }}. {{ $row->name }}</strong> &nbsp;<i class="fi-check"></i>
							@else
							{{ $row->flag }}. {{ $row->name }}
							@endif
							</li>
							@endforeach
						</ul>
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
	});
</script>
@endsection
