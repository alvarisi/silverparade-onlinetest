				<ul class="side-nav">
					<li><a href="{{ URL::to('/') }}">Beranda</a></li>
					<li class="side-headnav">
						<a href="#" class="side-button-headnav">Kompetisi / Modul</a>
						<ul class="side-subnav">
							<li><a href="{{ URL::to('/competition') }}">Kompetisi / Modul</a></li>
							<li><a href="{{ URL::to('/competition/category') }}">Topik / Kategori</a></li>
							<li><a href="{{ URL::to('/competition/question') }}">Pertanyaan</a></li>
						</ul>
					</li>
					<li class="side-headnav">
						<a href="#" class="side-button-headnav">Tes</a>
						<ul class="side-subnav">
							<li><a href="{{ URL::to('/session') }}">Tes / Session</a></li>
							<li><a href="{{ URL::to('/test/participant') }}">Partisipan</a></li>
							<li><a href="{{ URL::to('/test/result') }}">Hasil</a></li>
						</ul>
					</li>
					<li class="side-headnav">
						<a href="#" class="side-button-headnav">Manajemen User</a>
						<ul  class="side-subnav">
							<li><a href="{{ URL::to('/user/add') }}">Tambah User</a></li>
							<li><a href="{{ URL::to('/user/list') }}">Daftar User</a></li>
							<li><a href="{{ URL::to('/user/excel') }}">Upload User</a></li>
						</ul>
					</li>
					<li><a href="{{ URL::to('/account') }}">Akun</a></li>
					<li><a href="{{ URL::to('/logout') }}">Logout</a></li>
				</ul>
				<script type="text/javascript">
				$("ul.side-subnav").toggle();
				$('.side-button-headnav').click(function(){
					var parent = $(this).closest('.side-headnav');
					var th= parent.find("ul.side-subnav")
					$("ul.side-subnav").not(th).hide();
					th.toggle();
				});
				</script>