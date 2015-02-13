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
						<h5 class="head text-center">{{ $title }}</h5>
						<hr>
						<div class="row">
							<div class="large-12 columns">
								<table>
									<tr>
										<td>Nama</td>
										<td>:</td>
										<td>{{ $content->name }}</td>
									</tr>
									<tr>
										<td>Username</td>
										<td>:</td>
										<td>{{ $content->username }}</td>
									</tr>
									<tr>
										<td>Password</td>
										<td>:</td>
										<td><a href="{{ URL::to('account/changepassword') }}" class="button tiny secondary">Ganti Password</a></td>
									</tr>
									<tr>
										<td>Email</td>
										<td>:</td>
										<td>{{ $content->email }}</td>
									</tr>
								</table>
							</div>
							<div class="columns">
								<a href="{{ URL::to('account/edit') }}" class="button alert radius tiny"><i class='fi-pencil'></i>&nbsp;Edit</a>
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
	{{ HTML::style('assets/icons/foundation-icons.css') }}
@endsection

@section('custom-footer')
<script type="text/javascript">
	$(document).ready(function() {
    	
	});
</script>
@endsection
