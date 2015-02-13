@extends('layouts.home')

@section('content')
	<div class="container">
		@include('include.officer.headnav')
		<div class="row">
			<div class="small-12 large-12 end columns">
				<div class="row">
					<div class="panel side-content">
						<h5 class="head text-center"><b>Tes :</b> {{ $content->sesi->categories->name }}</h5>
						<p>
							{{ $content->sesi->categories->description }}
						</p>
						<table>
							<tr>
								<td class="large-3">Waktu Mulai</td>
								<td class="large-1">:</td>
								<td>{{ $content->sesi->mulai }}</td>
								<td class="large-3">Waktu Selesai</td>
								<td class="large-1">:</td>
								<td>{{ $content->sesi->selesai }}</td>
							</tr>

							<tr>
								<td class="large-3">Waktu Server</td>
								<td class="large-1">:</td>
								<td><div id="currenttime">&nbsp;</div></td>
								<td>Sisa Waktu</td>
								<td>:</td>
								<td><div id="timeelapsed">&nbsp;</div></td>
							</tr>
						</table>
						<div class="row">
							<div class="large-12 columns">
							{{ Form::open(array('url' => Request::url(), 'method' => 'post','id' => 'myForm')) }}
								<?php $no=1; ?>
									@foreach($content->sesi->categories->questions as $row)
								<div class="row">
									
									<div class="large-12 columns">
									<fieldset>
									<label>{{ $no++; }}.&nbsp;{{ $row->name }}</label>
									@if(!empty($row->file))
									<div class="row">
									<a class="th large-5 large-offset-3 columns" target="_blank" href="{{ asset('upload/question/'.$row->file) }}">
										<img src="{{ asset('upload/question/'.$row->file) }}" class="" ></a>
									</div>
									@endif
									@foreach($row->choices as $v)
									<div class="large-12">
										<input name="{{ $row->id }}" value="{{ $v->flag }}" type="radio" id="{{ $v->id }}" /><label for={{ $v->id }}>{{ $v->name }}</label>
									</div>
									@endforeach
									</fieldset>
									</div>
									</div>
									@endforeach
								<div class="row">
									<div class="large-12 columns">
									{{ Form::submit('Selesai',array('class' => 'button tiny'))}}
									</div>
								</div>
							{{ Form::close() }}
							</div>
						</div>
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
@endsection
@section('custom-footer')
	<script type="text/javascript">
		$(document).ready(function() {
	    	setInterval("clock()", 1000);
		});
		function submitkuis()
		{
			$('#myForm').submit();
		}

		var currenttime = '<?php date_default_timezone_set('Asia/Jakarta'); print date("F d, Y H:i:s", time())?>'; 
		var serverdate=new Date(currenttime);
		function padlength(what){
			var output=(what.toString().length==1)? "0"+what : what;
			return output;
		}

		var timestring='';
		function clock(){
			serverdate.setSeconds(serverdate.getSeconds()+1);
			timestring=padlength(""+serverdate.getFullYear()+"-" + (serverdate.getMonth()+1) +"-" +serverdate.getDate()+" "+ serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds()+"");
			$('#currenttime').text(timestring);
			<?php 
			$date = strtotime($content->sesi->selesai);
			$selesai = date('F j, Y  H:i:s',$date);
			?>
			var y = '{{ $selesai }}';
			var s = (new Date(y)- new Date(serverdate))/1000;
			if(s=='0' || s < '0')
			{
				submitkuis();
			}
			var m = parseInt(s/60);
			var c = parseInt(s%60);
			var timeelapsed = m + ' menit ' + c + ' detik';
			$('#timeelapsed').text(timeelapsed);
			
			// $('.execute').each(function(){
			// 	// var x = this.getAttribute('data-mulai');
			// 	var y = this.getAttribute('{{ $selesai }}');
			// 	// var m = new Date(x);
			// 	var s = (new Date(y)- new Date(serverdate))/1000;
			// 	console.log(s);

			// 	// if(new Date(x) < new Date(serverdate) && new Date(y) > new Date(serverdate))
			// 	// {
			// 	// 	$(this).removeAttr('style');
			// 	// }
			// });
		}
	</script>
@endsection
