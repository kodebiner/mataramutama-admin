			<section class="uk-section uk-section-primary uk-light uk-flex uk-flex-middle" uk-height-viewport>
				<div class="uk-container uk-container-small">
					<div class="uk-text-center uk-margin">
						Sudah punya akun? <a href="login">Login</a>
					</div>
					<h1 class="uk-text-center uk-text-uppercase">Registrasi Akun</h1>
					<form action="/register" class="uk-form-stacked uk-margin" uk-grid name="registrationform" method="post" accept-charset="utf-8">
						<div class="uk-width-1-2@m">
							<label class="uk-form-label" for="username">Username <sup uk-icon="icon: question; ratio: 0.8" uk-tooltip="title: Isi dengan username anda. Bagian ini wajib diisi.;  pos: top;"></sup></label>
							<div class="uk-form-controls">
								<input class="uk-input" id="username" name="username" type="text" placeholder="Username">
							</div>
						</div>
						<div class="uk-width-1-2@m">
							<label class="uk-form-label" for="email">Email <sup uk-icon="icon: question; ratio: 0.8" uk-tooltip="title: Isi dengan alamat email anda. Bagian ini wajib diisi.;  pos: top;"></sup></label>
							<div class="uk-form-controls">
								<input class="uk-input" id="email" name="email" type="email" placeholder="alamat@email.com">
							</div>
						</div>
						<div class="uk-width-1-1">
							<label class="uk-form-label" for="fullname">Nama Lengkap <sup uk-icon="icon: question; ratio: 0.8" uk-tooltip="title: Isi dengan nama lengkap anda. Bagian ini wajib diisi.;  pos: top;"></sup></label>
							<div class="uk-form-controls">
								<input class="uk-input" id="fullname" name="fullname" type="text" placeholder="Nama Lengkap">
							</div>
						</div>						
						<div class="uk-width-1-2@m">
							<label class="uk-form-label" for="password">Password <sup uk-icon="icon: question; ratio: 0.8" uk-tooltip="title: Password minimal 8 karakter. Bagian ini wajib diisi.; pos: top;"></sup></label>
							<div class="uk-form-controls">
								<input class="uk-input" id="password" name="password" type="password" autocomplete="password" placeholder="Password">
							</div>
						</div>
						<div class="uk-width-1-2@m">
							<label class="uk-form-label" for="password2">Konfirmasi Password <sup uk-icon="icon: question; ratio: 0.8" uk-tooltip="title: Kolom ini harus cocok dengan kolom Password. Bagian ini wajib diisi.; pos: top;"></sup></label>
							<div class="uk-form-controls">
								<input class="uk-input" id="password2" name="password2" type="password" placeholder="Password">
							</div>
						</div>
						<div class="uk-width-1-1">
							<div class="uk-flex uk-flex-right">
								<button class="uk-button uk-button-default" name="register" type="submit" value="Registration Submited!">Register</button>
							</div>
						</div>
					</form>
				</div>
			</section>