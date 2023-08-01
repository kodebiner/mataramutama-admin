<?php namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel;
use App\Models\BeritaModel;
use CodeIgniter\I18n\Time;

class Berita extends Controller
{
	protected $helpers = ['url', 'text', 'form'];
	
	public function index() {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$data['lang'] = 'id';
			$data['title'] = "Berita";
			$data['desc'] = 'Daftar berita mataramutama.com.';
			
			$userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);			
			$data['fullname'] = $user->fullname;
			
			$pager = \Config\Services::pager();
			$beritaModel = new BeritaModel();
			$data['berita'] = $beritaModel->orderBy('id', 'DESC')->paginate(10, 'berita');
			$data['pager'] = $beritaModel->pager;
			
			echo view('templates/header', $data);
			echo view('templates/body-open', $data);
			if ($agent->isMobile()) {
				echo view('templates/navbar-mobile', $data);
			}
			else {
				echo view('templates/navbar-desktop', $data);
			}
			echo view('berita/home', $data);
			
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
	
	public function remove($id) {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$beritaModel = new BeritaModel();
			$beritaModel->delete(['id' => $id]);
			return redirect()->to('berita');
		}
		else
		{
			return redirect()->to('login');
		}
	}
	
	public function view($qyt) {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$data['lang'] = 'id';
			$data['title'] = "Berita";
			$data['desc'] = 'Daftar berita mataramutama.com.';
			
			$userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);			
			$data['fullname'] = $user->fullname;
			
			$pager = \Config\Services::pager();
			$beritaModel = new BeritaModel();
			$data['berita'] = $beritaModel->orderBy('id', 'DESC')->paginate($qyt, 'berita');
			$data['pager'] = $beritaModel->pager;
			
			echo view('templates/header', $data);
			echo view('templates/body-open', $data);
			if ($agent->isMobile()) {
				echo view('templates/navbar-mobile', $data);
			}
			else {
				echo view('templates/navbar-desktop', $data);
			}
			echo view('berita/home', $data);
			
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
	
	public function upload() {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$file = $this->request->getFile('filein');
			$validation =  \Config\Services::validation();
			$valid = $this->validate([
				'filein' => ['label' => 'dokumen', 'rules' => 'uploaded[filein]|mime_in[filein,image/jpg,image/jpeg]|max_size[filein, 300]']
			],
			[
				'filein' => [
					'uploaded' => '{field} belum terunggah.',
					'mime_in' => '{field} harus berupa gambar dengan extensi .jpg atau .jpeg',
					'max_size' => 'Maks ukuran {field} adalah 300kb.'
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
						$file->move(FCPATH.'../../images/berita', $filename);
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
	
	public function new() {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$data['lang'] = 'id';
			$data['title'] = "Buat Berita";
			$data['desc'] = 'Formulir pembuatan berita baru';
			
			$userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);			
			$data['fullname'] = $user->fullname;		
			$beritaModel = new BeritaModel();
			$request = \Config\Services::request();
			
			echo view('templates/header', $data);
			echo '<script src="https://cdn.tiny.cloud/1/fbtmdxwnanfjdicy4oh9uxzzp0idhv1sdbyxml3t9lgz0v6r/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>';
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
					'judul' => ['label' => 'Judul', 'rules' => 'required'],
					'foto' => ['label' => 'Foto', 'rules' => 'required'],
					'intro' => ['label' => 'Intro Paragraf', 'rules' => 'required'],
					'content' => ['label' => 'Konten Berita', 'rules' => 'required']
				],
				[
					'judul' => [
						'required' => '{field} wajib diisi.'
					],
					'foto' => [
						'required' => '{field} wajib disertakan.'
					],
					'intro' => [
						'required' => '{field} wajib diisi.'
					],
					'content' => [
						'required' => '{field} wajib diisi.'
					]
				]))
				{
					$errors = $validation->getErrors();
					$session->setFlashdata('errors', $errors);
					$data['errors'] = $errors;
					echo view('berita/new', $data);
				} else
				{
					$slug = $this->request->getPost('judul');
					$slug = preg_replace('~[^\pL\d]+~u', '-', $slug);
					$slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
					$slug = preg_replace('~[^-\w]+~', '', $slug);
					$slug = trim($slug, '-');
					$slug = preg_replace('~-+~', '-', $slug);
					$slug = strtolower($slug);
					$submit = [
						'title' => $this->request->getPost('judul'),
						'slug' => $slug,
						'foto' => $this->request->getPost('foto'),
						'intro' => $this->request->getPost('intro'),
						'konten' => $this->request->getPost('content')
					];
					$beritaModel->save($submit);
					return redirect()->to('berita');
				}
			} else
			{
				echo view('berita/new', $data);
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
	
	public function edit($id) {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$data['lang'] = 'id';
			$data['title'] = "Edit Berita";
			$data['desc'] = 'Formulir pembuatan berita baru';
			
			$userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);			
			$data['fullname'] = $user->fullname;
			$data['beritaid'] = $id;
			$beritaModel = new BeritaModel();
			$berita = $beritaModel->find($id);
			$request = \Config\Services::request();
			
			echo view('templates/header', $data);
			echo '<script src="https://cdn.tiny.cloud/1/fbtmdxwnanfjdicy4oh9uxzzp0idhv1sdbyxml3t9lgz0v6r/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>';
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
					'judul' => ['label' => 'Judul', 'rules' => 'required'],
					'foto' => ['label' => 'Foto', 'rules' => 'required'],
					'intro' => ['label' => 'Intro Paragraf', 'rules' => 'required'],
					'content' => ['label' => 'Konten Berita', 'rules' => 'required']
				],
				[
					'judul' => [
						'required' => '{field} wajib diisi.'
					],
					'foto' => [
						'required' => '{field} wajib disertakan.'
					],
					'intro' => [
						'required' => '{field} wajib diisi.'
					],
					'content' => [
						'required' => '{field} wajib diisi.'
					]
				]))
				{
					$errors = $validation->getErrors();
					$session->setFlashdata('errors', $errors);
					$data['errors'] = $errors;
					echo view('berita/update', $data);
				} else
				{
					$submit = [
						'title' => $this->request->getPost('judul'),
						'foto' => $this->request->getPost('foto'),
						'intro' => $this->request->getPost('intro'),
						'konten' => $this->request->getPost('content')
					];
					$beritaModel->update($id, $submit);
					return redirect()->to('berita');
				}
			}
			else
			{
				$data['berita'] = $berita;
				echo view('berita/update', $data);
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
}