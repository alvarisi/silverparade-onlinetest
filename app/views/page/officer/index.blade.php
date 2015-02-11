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
						<h5 class="head text-center">Selamat Datang, Officer.</h5>
						<p>
							Pada Halaman ini anda dapat mengelola semua proses Tes <em>Online</em>.
						</p>
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
