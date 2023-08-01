<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Register extends Controller
{
	protected $helpers = ['url', 'text', 'form'];
	
	public function index()
	{
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			return redirect()->to('/');
		}
		else {
			$data['lang'] = 'id';
			$data['title'] = "Register - Admin Mataram Utama FC";
			$data['desc'] = '';
			
			echo view('templates/header', $data);			
			echo view('templates/body-open', $data);
			
			$request = \Config\Services::request();
			if ($request->getPost())
			{
				$validation =  \Config\Services::validation();
				
				if (! $this->validate([
					'username' => ['label' => 'Username', 'rules' => 'required|is_unique[user.username]'],
					'fullname' => ['label' => 'Nama Lengkap', 'rules' => 'required'],
					'email' => ['label' => 'Email', 'rules' => 'required|valid_email|is_unique[user.email]'],
					'password' => ['label' => 'Password', 'rules' => 'required|min_length[8]'],
					'password2' => ['label' => 'Konfirmasi Password', 'rules' => 'required|matches[password]']
				],
				[
					'username' => [
						'required' => '{field} wajib diisi.',
						'is_unique' => 'Username {value} sudah digunakan oleh akun lain. Gunakan username yang lain atau login dengan username tersebut.'
					],
					'fullname' => [
						'required' => '{field} wajib diisi.'
					],
					'email' => [
						'required' => '{field} wajib diisi.',
						'valid_email' => '{field} harus menggunakan format alamat email yang tepat.',
						'is_unique' => 'Email {value} sudah digunakan oleh akun lain. Gunakan alamat email yang lain atau login dengan email tersebut.'
					],
					'password' => [
						'required' => '{field} wajib diisi.',
						'min_length' => '{field} berisi minimal 8 karakter.'
					],
					'password2' => [
						'required' => '{field} wajib diisi.',
						'matches' => '{field} harus sama persis dengan Password.'
					]
				]))
				{
					echo view('account/registererror', [
						'validation' => $this->validator
					]);
				}
				else
				{
					$userModel = new \App\Models\UserModel();
					$dataform = $this->request->getPost();
					$user = new \App\Entities\User($dataform);
					$verifid = md5(uniqid(rand (),true));
					function generateRandomString($length = 10) {
						$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
						$charactersLength = strlen($characters);
						$randomString = '';
						for ($i = 0; $i < $length; $i++) {
							$randomString .= $characters[rand(0, $charactersLength - 1)];
						}
						return $randomString;
					}
					$user->verification = generateRandomString();
					$user->created = date('Y-m-d H:i:s');
					$userModel->save($user);
					$emailreg = $dataform['email'];
					$regdata = $userModel->asArray()->where('email', $emailreg)->findAll();
					$sesdata = [
						'id' => $regdata[0]['id'],
						'verification' => $regdata[0]['verification'],
						'logedin' => true,
						'status' => $regdata[0]['status']
					];
					$verstring = $regdata[0]['verification'];
					$email = \Config\Services::email();
					$filename = '/images/logo.png';
					$email->attach($filename);
					$email->setTo($emailreg);
					$cid = $email->setAttachmentCID($filename);
					$email->setSubject('Selamat Datang Di MataramUtama.com');
					$message = '
						<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
								<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
								<title>Selamat Datang Di MataramUtama.com</title>
								<style type="text/css">
									@import url("https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,900");
									html {
										font-family: "Montserrat", sans-serif;
										font-size: 16px;
										font-weight: 400;
										line-height: 1.6;
										background: #0062ad;
										color: #fff;
									}
									h1,
									uk-h1 {
										font-size: 20px;
										line-height: 1.1;
										font-weight: 600;
									}
									h2,
									uk-h2 {
										font-size: 20px;
										line-height: 1.3;
										font-weight: 600;
									}
									h3,
									uk-h3 {
										font-size: 20px;
										line-height: 1.2;
										font-weight: 600;
									}
								</style>
							</head>
							<body>
								<div style="width:100%; text-align: center; display: block;">
									<a href="https://mataramutama.com"><img src="https://mataramutama.com/images/logo.png" alt="Indonesian Custom Show" style="width:10%" /></a>
								</div>
								<div style="width: 50%; margin:auto;">
									<h1 style="text-align: center;">Selamat Datang di<br/>MataramUtama.com - Situs resmi Mataram Utama FC</h1>
									<p>Terimakasih telah bergabung dengan kami di <a href="https://mataramutama.com"><strong>MataramUtama.com</strong></a>.</p>
									<p>Sebelum anda melanjutkan petualangan bersama kami, anda perlu melakukan verifikasi alamat email anda.</p>
									<p>Kami perlu memastikan bahwa ini adalah alamat email yang tepat yang anda daftarkan di <a href="https://mataramutama.com"><strong>MataramUtama.com</strong></a>. Kami menggunakan alamat email yang telah anda masukkan sebelumnya untuk memberikan informasi labih lanjut terkait petualangan anda bersama kami.</p>
									<h3 style="text-align: center; margin-top: 40px; margin-bottom: 40px;">Klik link di bawah ini untuk verifikasi email anda:<br/><a href="'. base_url() .'/register/verify/'. $verstring .'">'. base_url() .'/register/verify/'. $verstring .'</a></h3>
									<p>Bila anda mengalami kendala, silahkan copy/paste URL tersebut ke dalam web browser anda.</p>
									<p>Bila anda tidak merasa melakukan registrasi di <a href="https://mataramutama.com"><strong>MataramUtama.com</strong></a>, tinggalkan atau hapus email ini sebelum digunakan oleh orang yang tidak bertanggungjawab dan merugikan anda.</p>
								</div>
							</body>
						</html>
					';
					$email->setMessage($message);
					$email->send();
					$session->set($sesdata);
					echo view('account/confirm', $data);					
				}
			}
			else {
				echo view('account/register', $data);
			}
			
			echo view('templates/body-close', $data);
		}
	}
	
	public function resend()
	{
		$session = \Config\Services::session();
		$userModel = new \App\Models\UserModel();
		
		if (isset($_SESSION['id']))
		{
			$id = $session->get('id');
			$status = $session->get('status');
			
			if ($status == 1)
			{
				return redirect()->to('/');
			}
			else {
				$user = $userModel->asArray()->find($id);
				$email = \Config\Services::email();
				$filename = '/images/logo.png';
				$email->attach($filename);
				$email->setTo($user['email']);
				$cid = $email->setAttachmentCID($filename);
				$email->setSubject('Selamat Datang Di MataramUtama.com');
				$message = '
						<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
							<head>
								<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
								<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
								<title>Selamat Datang Di MataramUtama.com</title>
								<style type="text/css">
									@import url("https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,900");
									html {
										font-family: "Montserrat", sans-serif;
										font-size: 16px;
										font-weight: 400;
										line-height: 1.6;
										background: #0062ad;
										color: #fff;
									}
									h1,
									uk-h1 {
										font-size: 20px;
										line-height: 1.1;
										font-weight: 600;
									}
									h2,
									uk-h2 {
										font-size: 20px;
										line-height: 1.3;
										font-weight: 600;
									}
									h3,
									uk-h3 {
										font-size: 20px;
										line-height: 1.2;
										font-weight: 600;
									}
								</style>
							</head>
							<body>
								<div style="width:100%; text-align: center; display: block;">
									<a href="https://mataramutama.com"><img src="https://mataramutama.com/images/logo.png" alt="Indonesian Custom Show" style="width:10%" /></a>
								</div>
								<div style="width: 50%; margin:auto;">
									<h1 style="text-align: center;">Selamat Datang di<br/>MataramUtama.com - Situs resmi Mataram Utama FC</h1>
									<p>Terimakasih telah bergabung dengan kami di <a href="https://mataramutama.com"><strong>MataramUtama.com</strong></a>.</p>
									<p>Sebelum anda melanjutkan petualangan bersama kami, anda perlu melakukan verifikasi alamat email anda.</p>
									<p>Kami perlu memastikan bahwa ini adalah alamat email yang tepat yang anda daftarkan di <a href="https://mataramutama.com"><strong>MataramUtama.com</strong></a>. Kami menggunakan alamat email yang telah anda masukkan sebelumnya untuk memberikan informasi labih lanjut terkait petualangan anda bersama kami.</p>
									<h3 style="text-align: center; margin-top: 40px; margin-bottom: 40px;">Klik link di bawah ini untuk verifikasi email anda:<br/><a href="'. base_url() .'/register/verify/'. $user['verification'] .'">'. base_url() .'/register/verify/'. $user['verification'] .'</a></h3>
									<p>Bila anda mengalami kendala, silahkan copy/paste URL tersebut ke dalam web browser anda.</p>
									<p>Bila anda tidak merasa melakukan registrasi di <a href="https://mataramutama.com"><strong>MataramUtama.com</strong></a>, tinggalkan atau hapus email ini sebelum digunakan oleh orang yang tidak bertanggungjawab dan merugikan anda.</p>
								</div>
							</body>
						</html>
					';
				$email->setMessage($message);
				$email->send();
				
				$data['lang'] = 'en';
				$data['title'] = "Kirim Ulang Verifikasi - Mataram Utama FC";
				$data['desc'] = '';
				$data['id'] = $id;
				
				echo view('templates/header', $data);
				echo view('templates/body-open', $data);
				echo view('account/confirm', $data);
				echo view('templates/body-close', $data);
			}
		}
		else {
			return redirect()->to('/login');
		}
	}
	
	public function verify($verification)
	{
		$data['lang'] = 'en';
		$data['title'] = "Login - Mataram Utama FC";
		$data['desc'] = '';		
		
		$session = \Config\Services::session();
		$userModel = new \App\Models\UserModel();
		
		if (isset($_SESSION['id']))
		{
			$id = $session->get('id');
			$userModel = new \App\Models\UserModel();
			$user = $userModel->asArray()->find($id);
			
			$data['username'] = $user['username'];
			$data['email'] = $user['email'];
			$data['id'] = $id;
			
			echo view('templates/header', $data);
			echo view('templates/body-open', $data);
			
			$logedid = $session->get('id');
			$user = $userModel->asArray()->find($logedid);
			
			if ($verification == $user['verification'])
			{
				$userModel->update($logedid, ['status' => 1]);
				$session->set('status', 1);
				echo view('account/verify', $data);
			}			
			else {
				echo view('account/verifyerror', $data);
			}
			
			echo view('templates/body-close', $data);
		}
		else {
			return redirect()->to('/login');
		}
		
	}
}