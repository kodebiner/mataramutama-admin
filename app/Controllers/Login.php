<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Login extends Controller
{
	protected $helpers = ['url', 'text', 'form'];
	
	public function index()
	{
		$session = \Config\Services::session();
		if (isset($_SESSION['id']))
		{
			return redirect()->to('/');
		}
		else {
			$data['lang'] = 'id';
			$data['title'] = "Login - Mataram Utama FC";
			$data['desc'] = 'Lakukan login untuk dapat melihat dashboard akun.';
			
			echo view('templates/header', $data);			
			echo view('templates/body-open', $data);
			
			$request = \Config\Services::request();
			if ($request->getPost())
			{
				$validation =  \Config\Services::validation();
				if (! $this->validate([
					'username' => ['label' => 'Username', 'rules' => 'required'],
					'password' => ['label' => 'Password', 'rules' => 'required|min_length[8]']
				]))
				{
					echo view('account/loginerror', [
						'validation' => $this->validator
					]);
				}
				
				$userModel = new \App\Models\UserModel();
				$datalogin = $this->request->getPost();
				$userlog = $datalogin['username'];
				$user = $userModel->where('username', $userlog)->first();
				
				if ($user)
				{
					if(password_verify($datalogin['password'], $user->password))
					{
						$sesdata = [
							'id' => $user->id,
							'logedin' => true,
							'status' => $user->status,
							'type' => $user->type
						];
						$session->set($sesdata);
						return redirect()->back();
					}
					else {
						$data['error'] = 'Password yang anda masukkan salah. Pastikan anda menggunakan password yang benar.';
						echo view('account/logindataerror', $data);
					}
				}
				else {
					$data['error'] = 'Akun dengan username '. $userlog .' tidak ditemukan. Pastikan anda memasukkan username yang benar.';
					echo view('account/logindataerror', $data);
				}
			}
			else {
				echo view('account/login');
			}
			
			echo view('templates/body-close', $data);
		}
	}
}