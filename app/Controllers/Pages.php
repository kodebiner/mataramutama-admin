<?php namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel;

class Pages extends Controller
{
	protected $helpers = ['url', 'text', 'form'];
	
	public function index()
	{
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$data['lang'] = 'id';
			$data['title'] = "Mataram Utama FC";
			$data['desc'] = 'Website resmi Mataram Utama FC lengkap dengan berita seputar tim, update pertandingan, dan profil pemain.';
			
			$userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);			
			$data['fullname'] = $user->fullname;
			
			$beritaModel = new \App\Models\BeritaModel();
			$data['berita'] = $beritaModel->orderBy('id', 'DESC')->limit(5)->find();
			
			echo view('templates/header', $data);
			echo view('templates/body-open', $data);
			if ($agent->isMobile()) {
				echo view('templates/navbar-mobile', $data);
			} else {
				echo view('templates/navbar-desktop', $data);
			}
			echo view('pages/home', $data);
			if ($agent->isMobile()) {
				echo view('templates/footer-mobile', $data);
			} else {
				echo view('templates/footer-desktop', $data);
			}
			echo view('templates/body-close', $data);
		}
		else
		{
			return redirect()->to('login');
		}
	}
	
	public function logout()
	{
		
		$session = \Config\Services::session();
		$session->destroy();
		return redirect()->to('/');		
	}	
}