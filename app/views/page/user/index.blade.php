@extends('layouts.home')

@section('content')
	<div class="container">
		@include('include.officer.headnav')
		<div class="row">
			<div class="small-12 large-3 columns">
				@include('include.user.sidenav')
			</div>
			<div class="small-12 large-8 end columns">
				<div class="row">
					<div class="panel side-content">
						<h5 class="head text-center">Selamat Datang, {{ $content->name }}.</h5>
						<p>
							Pada halaman dashboard ini anda dapat mengikuti tes, pada menu <b>Tes</b> disamping. Jika anda pertama kali masuk, ganti password anda pada menu <b>Akun</b>.
						</p>
						<hr>
						<p>
							Kontak Kami:<BR>
							<i class="fi-telephone"></i>&nbsp;&nbsp;<b>Rahel</b>&nbsp;&nbsp;087781399477<br>
							<i class="fi-telephone"></i>&nbsp;&nbsp;<b>Sita</b>&nbsp;&nbsp;087788676717<br>
							<i class="fi-social-twitter"></i>&nbsp;&nbsp;<b>@silverparade5</b><br>
							<i class="fi-social-facebook"></i>&nbsp;&nbsp;<b>Silver Parade</b><br>
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
	{{ HTML::style('assets/icons/foundation-icons.css') }}
@endsection
