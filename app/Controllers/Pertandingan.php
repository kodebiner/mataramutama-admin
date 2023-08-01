<?php namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel;
use App\Models\PertandinganModel;
use App\Models\PlayerModel;
use App\Models\GoalsModel;
use App\Models\ClubModel;
use CodeIgniter\I18n\Time;

class Pertandingan extends Controller
{
	protected $helpers = ['url', 'text', 'form'];
	
	public function index() {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		setlocale(LC_TIME, 'id_ID');
		if (isset($_SESSION['id']))
		{
			$data['lang'] = 'id';
			$data['title'] = "Daftar Pertandingan";
			$data['desc'] = 'Daftar pertandingan Mataram Utama FC.';
			
			$userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);			
			$data['fullname'] = $user->fullname;
			
			$pager = \Config\Services::pager();
			$pertandinganModel = new PertandinganModel();
			$clubModel = new ClubModel();
			$goalsModel = new GoalsModel();
			$data['goalswon'] = $goalsModel->where('type', '0')->findAll();
			$data['goalsconceded'] = $goalsModel->where('type', '1')->findAll();
			$data['clubs'] = $clubModel->findAll();
			$data['matches'] = $pertandinganModel->orderBy('date', 'DESC')->paginate(25, 'match');
			$data['pager'] = $pertandinganModel->pager;
			
			echo view('templates/header', $data);
			echo view('templates/body-open', $data);
			if ($agent->isMobile()) {
				echo view('templates/navbar-mobile', $data);
			}
			else {
				echo view('templates/navbar-desktop', $data);
			}
			
			echo view('pertandingan/home', $data);
			
			if ($agent->isMobile()) {
				echo view('templates/footer-mobile', $data);
			} 
			else {
				echo view('templates/footer-desktop', $data);
			}
			echo view('templates/body-close', $data);
		} else
		{
			return redirect()->to('login');
		}
	}
	
	public function clublogo() {
		$session = \Config\Services::session();
		$validation =  \Config\Services::validation();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$file = $this->request->getFile('filein');
			$valid = $this->validate([
				'filein' => ['label' => 'dokumen', 'rules' => 'uploaded[filein]|mime_in[filein,image/png]|max_size[filein, 500]']
			],
			[
				'filein' => [
					'uploaded' => '{field} belum terunggah.',
					'mime_in' => '{field} harus berupa gambar dengan extensi .png',
					'max_size' => 'Maks ukuran {field} adalah 500kb.'
				]
			]);
			
			if (!$valid)
			{
				header('HTTP/1.1 500 Internal Server Booboo');
				header('Content-Type: application/json; charset=UTF-8');
				die(json_encode($validation->getError('filein')));
			}
			else
			{
				if (!empty($file)) {
					$time = Time::now();
					function clean($string) {
						$string = str_replace(' ', '', $string); // Remove all spaces.
						$string = str_replace('-', '', $string); // Remove all dashes.
						$string = str_replace('_', '', $string); // Remove all undescores.
						return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
					}
					
					if ($file->isValid() && ! $file->hasMoved())
					{
						$filename = $file->getRandomName();
						$file->move(FCPATH.'../../images/club', $filename);
						die($filename);
					}
					
				} else {
					throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
				}
			}
		}
		else
		{
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}
	
	public function clubremove($id) {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$clubModel = new ClubModel();
			$clubModel->delete(['id' => $id]);
			return redirect()->back();
		}
		else
		{
			return redirect()->to('login');
		}
	}
	
	public function club() {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$data['lang'] = 'id';
			$data['title'] = "Daftar Club";
			$data['desc'] = 'Daftar club peserta liga Indonesia.';
			
			$userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);			
			$data['fullname'] = $user->fullname;
			
			$pager = \Config\Services::pager();
			$clubModel = new ClubModel();
			$data['clubs'] = $clubModel->orderBy('name', 'ASC')->paginate(12, 'club');
			$data['pager'] = $clubModel->pager;
			
			echo view('templates/header', $data);
			echo view('templates/body-open', $data);
			if ($agent->isMobile()) {
				echo view('templates/navbar-mobile', $data);
			}
			else {
				echo view('templates/navbar-desktop', $data);
			}
			
			echo view('pertandingan/clublist', $data);
			
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
	
	public function addclub() {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$data['lang'] = 'id';
			$data['title'] = "Tambah Club";
			$data['desc'] = 'Form menambah club peserta liga Indonesia.';
			
			$userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);			
			$data['fullname'] = $user->fullname;
			
			$clubModel = new ClubModel();
			$request = \Config\Services::request();
			
			echo view('templates/header', $data);
			echo view('templates/body-open', $data);
			if ($agent->isMobile()) {
				echo view('templates/navbar-mobile', $data);
			}
			else {
				echo view('templates/navbar-desktop', $data);
			}
			
			if ($request->getPost())
			{
				$validation =  \Config\Services::validation();
				$data['post'] = $request->getPost();
				
				if (! $this->validate([
					'nama' => ['label' => 'Nama Club', 'rules' => 'required']
				],
				[
					'nama' => [
						'required' => '{field} wajib diisi.'
					]
				]))
				{
					$errors = $validation->getErrors();
					$session->setFlashdata('errors', $errors);
					$data['errors'] = $errors;
					echo view('pertandingan/addclub', $data);
				}
				else
				{
					$submit = '';
					if (!empty($this->request->getPost('logo')))
					{
						$submit = [
							'name' => $this->request->getPost('nama'),
							'logo' => $this->request->getPost('logo')
						];
					}
					else
					{
						$submit = ['name' => $this->request->getPost('nama')];
					}
					$clubModel->save($submit);
					return redirect()->to('pertandingan/club');
				}
			}
			else
			{
				echo view('pertandingan/addclub', $data);
			}
			
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
	
	public function updateclub($id) {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$data['lang'] = 'id';
			$data['title'] = "Tambah Club";
			$data['desc'] = 'Form menambah club peserta liga Indonesia.';
			
			$userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);			
			$data['fullname'] = $user->fullname;
			
			$clubModel = new ClubModel();
			$club = $clubModel->find($id);
			$request = \Config\Services::request();
			
			echo view('templates/header', $data);
			echo view('templates/body-open', $data);
			if ($agent->isMobile()) {
				echo view('templates/navbar-mobile', $data);
			}
			else {
				echo view('templates/navbar-desktop', $data);
			}
			
			if ($request->getPost())
			{
				
			} else
			{
				$data['club'] = $club;
				echo view('pertandingan/addclub', $data);
			}
			
			if ($agent->isMobile()) {
				echo view('templates/footer-mobile', $data);
			} 
			else {
				echo view('templates/footer-desktop', $data);
			}
			echo view('templates/body-close', $data);
		}
	}
}