			<div class="tm-header uk-visible@l" uk-header>
				<div uk-sticky media="@l" cls-active="uk-navbar-sticky" sel-target=".uk-navbar-container">
					<div class="uk-navbar-container" style="background-color:#0a0a9e;">
						<div class="uk-container uk-container-expand">
							<nav uk-navbar="align:left;boundary:.tm-header .uk-navbar-container;container:.tm-header;">
								<div class="uk-navbar-left">
									<a class="uk-navbar-item uk-logo" href="<?php echo base_url(); ?>">
										<img data-src="images/logo.png" alt="Mataram Utama FC" width="75" height="75" uk-img/>
									</a>
								</div>
								<div style="flex-wrap: wrap; display: flex; align-items: center; margin-left:30px;">
									<ul class="uk-navbar-nav">
										<li class="<?=($uri->getSegment(1)==='berita')?'uk-active':''?>">
											<a href="berita">Berita</a>
											<div class="uk-navbar-dropdown">
												<ul class="uk-nav uk-navbar-dropdown-nav">
													<li class="<?=($uri->getSegment(1)==='berita')&&($uri->getSegment(2)==='new')?'uk-active':''?>"><a href="berita/new"><span uk-icon="icon: plus; ratio: 0.5"></span> Buat Baru</a></li>
													<li class="<?=($uri->getSegment(1)==='berita')&&($uri->getSegment(2)==='')?'uk-active':''?>"><a href="berita"><span uk-icon="icon: list; ratio: 0.5"></span> List Berita</a></li>
												</ul>
											</div>
										</li>
                                        <li class="<?=($uri->getSegment(1)==='pertandingan')?'uk-active':''?>"><a href="pertandingan">Pertandingan</a></li>
										<li class="<?=($uri->getSegment(1)==='galeri')?'uk-active':''?>">
											<a>Galeri</a>
											<div class="uk-navbar-dropdown">
												<ul class="uk-nav uk-navbar-dropdown-nav">
													<li class="<?=($uri->getSegment(1)==='galeri')&&($uri->getSegment(2)==='foto')?'uk-active':''?>"><a href="galeri/foto">Galeri Foto</a></li>
													<li class="<?=($uri->getSegment(1)==='galeri')&&($uri->getSegment(2)==='video')?'uk-active':''?>"><a href="galeri/video">Galeri Video</a></li>
												</ul>
											</div>
										</li>
                                        <li class="<?=($uri->getSegment(1)==='tim')?'uk-active':''?>">
                                            <a>Tim</a>
                                            <div class="uk-navbar-dropdown">
                                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                                    <li class="<?=($uri->getSegment(1)==='tim')&&($uri->getSegment(2)==='')?'uk-active':''?>"><a href="tim">Daftar Pemain</a></li>
                                                    <li class="<?=($uri->getSegment(1)==='tim')&&($uri->getSegment(2)==='pelatih')?'uk-active':''?>"><a href="tim/pelatih">Daftar Pelatih</a></li>
                                                </ul>
                                            </div>
                                        </li>
										<li class="<?=($uri->getSegment(1)==='akademi')?'uk-active':''?>"><a href="akademi">Akademi</a></li>
									</ul>
								</div>
								<div class="uk-navbar-right uk-light">
									<div class="uk-inline">
										<a type="button">Hi, <?php echo $fullname; ?> <span uk-icon="icon: triangle-down"></span></a>
										<div uk-dropdown="mode: click">
											<button class="uk-button" onclick="window.location='/logout'">Logout</button>
										</div>
									</div>
								</div>
							</nav>
						</div>
					</div>
				</div>
			</div>