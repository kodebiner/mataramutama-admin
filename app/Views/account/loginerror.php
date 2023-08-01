			<section class="uk-section uk-section-primary uk-light uk-flex uk-flex-middle" uk-height-viewport>
				<div class="uk-container uk-container-small">
					<h1 class="uk-text-center uk-text-uppercase">Login</h1>
					<?= $validation->listErrors('error_list') ?>
					<form action="/login" class="uk-form-stacked" uk-grid name="registrationform" method="post" accept-charset="utf-8">
						<div class="uk-width-1-1">
							<label class="uk-form-label" for="username">Username</label>
							<div class="uk-form-controls">
								<input class="uk-input" id="username" name="username" type="text" placeholder="username">
							</div>
						</div>
						<div class="uk-width-1-1">
							<label class="uk-form-label" for="password">Password</label>
							<div class="uk-form-controls">
								<input class="uk-input" id="password" name="password" type="password" autocomplete="password" placeholder="Password">
							</div>
						</div>
						<div class="uk-width-1-1">
							<div class="uk-flex uk-flex-right">
								<button class="uk-button uk-button-default" name="login" type="submit" value="Login!">Login</button>
							</div>
						</div>
					</form>
					<div class="uk-text-center uk-margin">
						Belum punya akun? <a href="register">Buat Akun</a>
					</div>
				</div>
			</section>