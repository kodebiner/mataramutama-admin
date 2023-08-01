			<div class="tm-header-mobile uk-hidden@l">
				<div uk-sticky cls-active="uk-navbar-sticky" sel-target=".uk-navbar-container">
					<div class="uk-navbar-container uk-light" style="background-color:#0a0a9e;">
						<nav uk-navbar="container: .tm-header-mobile">
							<div class="uk-navbar-left">
								<a class="uk-navbar-toggle" href="#offcanvas" uk-toggle="animation: true">
									<div uk-navbar-toggle-icon></div>
								</a>
							</div>
							<div class="uk-navbar-center">
								<a href="<?php echo base_url(); ?>" class="uk-navbar-item uk-logo">
									<img data-src="images/logo.png" alt="Mataram Utama FC" width="75" height="75" uk-img/>
								</a>
							</div>
						</nav>
					</div>
					<div class="uk-position-relative tm-header-mobile-slide">
						<div id="offcanvas" class="uk-position-top uk-light" hidden>
							<div class="uk-background-primary uk-padding">
								<div class="uk-child-width-1-1" uk-grid>
									<div>
										<div class="uk-panel">
											<ul class="uk-nav-default uk-nav-parent-icon" uk-nav style="font-size:20px;">
												<li class="uk-parent <?=($uri->getSegment(1)==='berita')?'uk-active':''?>">
													<a>Berita</a>
													<ul class="uk-nav-sub" hidden>
														<li class="<?=($uri->getSegment(1)==='berita')&&($uri->getSegment(2)==='new')?'uk-active':''?>"><a href="berita/new"><span uk-icon="icon: plus; ratio: 0.5"></span> Buat Baru</a></li>
														<li class="<?=($uri->getSegment(1)==='berita')&&($uri->getSegment(2)==='')?'uk-active':''?>"><a href="berita"><span uk-icon="icon: list; ratio: 0.5"></span> List Berita</a></li>
													</ul>
												</li>
												<li class="<?=($uri->getSegment(1)==='pertandingan')?'uk-active':''?>"><a href="pertandingan">Pertandingan</a></li>
												<li class="uk-parent <?=($uri->getSegment(1)==='galeri')?'uk-active':''?>">
													<a>Galeri</a>
													<ul class="uk-nav-sub" hidden>
														<li class="<?=($uri->getSegment(1)==='galeri')&&($uri->getSegment(2)==='foto')?'uk-active':''?>"><a href="galeri/foto">Galeri Foto</a></li>
														<li class="<?=($uri->getSegment(1)==='galeri')&&($uri->getSegment(2)==='video')?'uk-active':''?>"><a href="galeri/video">Galeri Video</a></li>
													</ul>
												</li>
												<li class="uk-parent <?=($uri->getSegment(1)==='tim')?'uk-active':''?>">
													<a>Tim</a>
													<ul class="uk-nav-sub" hidden>
														<li class="<?=($uri->getSegment(1)==='tim')&&($uri->getSegment(2)==='')?'uk-active':''?>"><a href="tim">Daftar Pemain</a></li>
														<li class="<?=($uri->getSegment(1)==='tim')&&($uri->getSegment(2)==='pelatih')?'uk-active':''?>"><a href="tim/pelatih">Daftar Pelatih</a></li>
													</ul>
												</li>
												<li class="<?=($uri->getSegment(1)==='akademi')?'uk-active':''?>"><a href="akademi">Akademi</a></li>
											</ul>
										</div>
									</div>
									<div class="uk-text-center">
										<a href="https://www.facebook.com/mataramutamaofficial/" class="uk-margin-small-right" uk-icon="facebook" title="facebook"></a>
										<a href="https://www.instagram.com/mataramutama/" class="uk-margin-small-right" uk-icon="instagram" title="instagram"></a>
										<a href="https://twitter.com/FcUtama" class="uk-margin-small-right" uk-icon="twitter" title="twitter"></a>
										<a href="https://youtube.com/channel/UC45PXc19ZqdDAdwmwKZRdGg" class="uk-margin-small-right" uk-icon="youtube" title="youtube"></a>
										<a href="https://vt.tiktok.com/ZSJ4msqfy/" class="uk-margin-small-right" uk-icon="tiktok" title="tiktok"></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>