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
						<h5>{{ $content->sesi->categories->name }}</h5>
						<p>
							{{ $content->sesi->categories->description }}
						</p>
						<table>
							<tr>
								<td>Waktu Server</td>
								<td>:</td>
								<td><div id="currenttime">&nbsp;</div></td>
							</tr>
							<tr>
								<td>Waktu Mulai</td>
								<td>:</td>
								<td>{{ $content->sesi->mulai }}</td>
							</tr>
							<tr>
								<td>Waktu Selesai</td>
								<td>:</td>
								<td>{{ $content->sesi->selesai }}</td>
							</tr>
						</table>
						<div class="text-center">
						@if($content->logsesi()->count() > 0 && $content->logsesi->selesai == '0000-00-00 00:00:00')
							<a href="{{ URL::to('user/test/execute/'.$content->id) }}" class="button alert tiny">Lanjutkan</a>
						@else
							<a href="{{ URL::to('user/test/execute/'.$content->id) }}" class="button tiny">Execute</a>
						@endif
							<a href="{{ URL::to('user/test/list') }}" class="button secondary tiny">Batal</a>
						</div>
						<hr>
						<p>
							<small>Untuk informasi lebih lanjut. Klik <a href="https://www.facebook.com/outeez2" target="_blank">disini.</a></small>
						</p>
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
			$('#currenttime').text(timestring);
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
	</script>
@endsection
