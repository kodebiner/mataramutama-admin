<?php namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel;
use App\Models\SponsorModel;
use CodeIgniter\I18n\Time;

class Sponsor extends Controller
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
			$data['title'] = "Daftar Pemain";
			$data['desc'] = 'Daftar pemain Mataram Utama FC';
			
			$userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);
			$data['fullname'] = $user->fullname;

            $SponsorModel = new SponsorModel();
            $pager = \Config\Services::pager();

            $data['sponsors'] = $SponsorModel->findAll();
            $data['pager'] = $SponsorModel->pager;
            $data['mobile'] = $agent->isMobile();

            echo view('templates/header', $data);
            echo view('templates/body-open', $data);
            if ($agent->isMobile()) {
				echo view('templates/navbar-mobile', $data);
			}
			else {
				echo view('templates/navbar-desktop', $data);
			}

            echo view('sponsor/home', $data);

            if ($agent->isMobile()) {
				echo view('templates/footer-mobile', $data);
			} 
			else {
				echo view('templates/footer-desktop', $data);
			}
			echo view('templates/body-close', $data);
        }
        else
        {
            return redirect()->to('login');
        }
    }
}