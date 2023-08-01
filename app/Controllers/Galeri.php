<?php namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel;
use App\Models\GalleryCatModel;
use App\Models\PhotoGalleryModel;
use App\Models\VideoGalleryModel;
use CodeIgniter\I18n\Time;

class Galeri extends Controller
{
	protected $helpers = ['url', 'text', 'form'];
	
	public function index() {
		return redirect()->to('galeri/foto');
	}
	
	public function uploadfoto() {
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
					'uploaded' => 'Ada {field} yang belum terunggah.',
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
						$file->move(FCPATH.'../../images/gallery', $filename);
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
	
	public function removephoto() {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$request = \Config\Services::request();
			if ($request->getPost()) {
				$fotoid = $this->request->getPost('id');
				$FotoModel = new PhotoGalleryModel();
				$foto = $FotoModel->find($fotoid);
				
				unlink('../../images/gallery/'.$foto['photo']);
				$FotoModel->delete(['id' => $fotoid]);
				
				die(json_encode($foto));
			} else {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}
		}
		else
		{
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}
	
	public function removephotoonly() {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$request = \Config\Services::request();
			if ($request->getPost()) {
				$file = $this->request->getPost('filename');
				
				unlink('../../images/gallery/'.$file);
				
				die($file);
			} else {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}
		}
		else
		{
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}
	
	public function foto() {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$data['lang'] = 'id';
			$data['title'] = "Galeri Foto";
			$data['desc'] = 'Daftar galeri foto';
			
			$userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);			
			$data['fullname'] = $user->fullname;			
			
			$CategoryModel = new GalleryCatModel();
			$FotoModel = new PhotoGalleryModel();
			
			$request = \Config\Services::request();
			if ($request->getPost())
			{
				if ($this->request->getPost('submit') == 'newcat')
				{
					$slug = $this->request->getPost('judul');
					$slug = preg_replace('~[^\pL\d]+~u', '-', $slug);
					$slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
					$slug = preg_replace('~[^-\w]+~', '', $slug);
					$slug = trim($slug, '-');
					$slug = preg_replace('~-+~', '-', $slug);
					$slug = strtolower($slug);
					$submit = [
						'name' => $this->request->getPost('judul'),
						'slug' => $slug
					];
					$CategoryModel->save($submit);
				} else
				{
					echo 'not newcat';
				}
			}
			
			$pager = \Config\Services::pager();
			$data['photos'] = $FotoModel->findAll();
			$data['categories'] = $CategoryModel->orderBy('id', 'DESC')->paginate(10, 'category');
			$data['pager'] = $CategoryModel->pager;
			
			echo view('templates/header', $data);
			echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>';
			echo view('templates/body-open', $data);
			if ($agent->isMobile()) {
				echo view('templates/navbar-mobile', $data);
			}
			else {
				echo view('templates/navbar-desktop', $data);
			}
			
			echo view('galeri/foto', $data);
			
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
	
	public function updategalerifoto($id) {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$data['lang'] = 'id';
			$data['title'] = "Galeri Foto";
			$data['desc'] = 'Daftar galeri foto';
			
			$userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);			
			$data['fullname'] = $user->fullname;
			$request = \Config\Services::request();			
			
			$CategoryModel = new GalleryCatModel();
			$FotoModel = new PhotoGalleryModel();
			
			if ($request->getPost()) {
				if (($this->request->getPost('submit') == 'save') OR ($this->request->getPost('submit') == 'publish')) {
					$slug = $this->request->getPost('judul');
					$slug = preg_replace('~[^\pL\d]+~u', '-', $slug);
					$slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
					$slug = preg_replace('~[^-\w]+~', '', $slug);
					$slug = trim($slug, '-');
					$slug = preg_replace('~-+~', '-', $slug);
					$slug = strtolower($slug);
					$submit = [
						'name' => $this->request->getPost('judul'),
						'slug' => $slug,
						'featured' => $this->request->getPost('cover')
					];
					
					$CategoryModel->update($id, $submit);
					
					if ($this->request->getPost('submit') == 'publish') {
						$publish = ['status' => '1'];
						$CategoryModel->update($id, $publish);
					}
					
					if (!empty($this->request->getPost('fotoin'))) {
						$fotoin = explode(', ', $this->request->getPost('fotoin'), -1);
						
						foreach ($fotoin as $fotokey => $foto) {
							$fotodata = [
								'catid' => $id,
								'photo' => $foto
							];
							$FotoModel->save($fotodata);
						}
					}
				} elseif ($this->request->getPost('submit') == 'unpublish') {
					$unpublish = ['status' => '0'];
					$CategoryModel->update($id, $unpublish);
				}
			}
			
			$data['category'] = $CategoryModel->find($id);
			$data['photos'] = $FotoModel->orderBy('id DESC')->where('catid', $id)->find();
			
			echo view('templates/header', $data);
			echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>';
			echo view('templates/body-open', $data);
			if ($agent->isMobile()) {
				echo view('templates/navbar-mobile', $data);
			}
			else {
				echo view('templates/navbar-desktop', $data);
			}
			
			echo view('galeri/updatefoto', $data);
			
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
	
	public function removegallery($id) {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{			
			if (isset($_SERVER['HTTP_REFERER'])) {
				$referer = $_SERVER['HTTP_REFERER'];
				
				if ($referer == 'https://admin.mataramutama.com/galeri/updategalerifoto/'.$id) {
					$CategoryModel = new GalleryCatModel();
					$FotoModel = new PhotoGalleryModel();
					
					$photos = $FotoModel->where('catid', $id)->findAll();
					
					foreach ($photos as $photo) {
						$photoid = $photo['id'];
						$photoimg = $photo['photo'];
						
						unlink('../../images/gallery/'.$photoimg);
						
						$FotoModel->delete(['id' => $photoid]);
					}
					
					$CategoryModel->delete(['id' => $id]);
					
					return redirect()->to('galeri/foto');
				} else {
					throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
				}
			} else {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}			
		}
		else
		{
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}
	
	public function video() {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id'])) {
			$data['lang'] = 'id';
			$data['title'] = "Galeri Video";
			$data['desc'] = 'Daftar galeri video';
			
			$userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);			
			$data['fullname'] = $user->fullname;
			$request = \Config\Services::request();			
			
			$VideoModel = new VideoGalleryModel();
			
			if ($request->getPost()) {
				$submit = [
					'title' => $this->request->getPost('judul'),
					'videoid' => $this->request->getPost('videoid')
				];
				$VideoModel->save($submit);
			}
			
			$data['videos'] = $VideoModel->orderBy('id', 'DESC')->paginate(20, 'video');
			$data['pager'] = $VideoModel->pager;
			
			echo view('templates/header', $data);
			echo view('templates/body-open', $data);
			if ($agent->isMobile()) {
				echo view('templates/navbar-mobile', $data);
			}
			else {
				echo view('templates/navbar-desktop', $data);
			}
			
			echo view('galeri/video', $data);
			
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
	
	public function editvideo($id) {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id'])) {
			$VideoModel = new VideoGalleryModel();
			$request = \Config\Services::request();
			
			if ($request->getPost()) {
				$submit = [
					'title' => $this->request->getPost('judul'),
					'videoid' => $this->request->getPost('videoid')
				];
				$VideoModel->update($id, $submit);
				return redirect()->to('galeri/video');
				
			} else {
			
				$data['video'] = $VideoModel->find($id);
				
				$data['lang'] = 'id';
				$data['title'] = $data['video']['title'];
				$data['desc'] = 'Edit video '.$data['video']['title'];
				
				$userid = $_SESSION['id'];
				$userModel = new UserModel();
				$user = $userModel->find($userid);			
				$data['fullname'] = $user->fullname;
				
				echo view('templates/header', $data);
				echo view('templates/body-open', $data);
				if ($agent->isMobile()) {
					echo view('templates/navbar-mobile', $data);
				}
				else {
					echo view('templates/navbar-desktop', $data);
				}
				
				echo view('galeri/editvideo', $data);
				
				if ($agent->isMobile()) {
					echo view('templates/footer-mobile', $data);
				} 
				else {
					echo view('templates/footer-desktop', $data);
				}
				echo view('templates/body-close', $data);
			}
		}
		else
		{
			return redirect()->to('login');
		}
	}
	
	public function removevideo($id) {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$VideoModel = new VideoGalleryModel();
			$VideoModel->delete(['id' => $id]);
			return redirect()->to('galeri/video');
		}
		else
		{
			return redirect()->to('login');
		}
	}
}