				<ul class="side-nav">
					<li><a href="{{ URL::to('/') }}">Beranda</a></li>
					<li><a href="{{ URL::to('/user/test/list') }}">Tes</a></li>
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