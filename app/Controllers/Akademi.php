<?php namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel;
use App\Models\PlayerAkademiModel;
use App\Models\AkademiModel;

class Akademi extends Controller
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
			$data['title'] = "Daftar Siswa Akademi";
			$data['desc'] = 'Daftar siswa akademi Mataram Utama FC';

            $userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);			
			$data['fullname'] = $user->fullname;

            $PlayerAkademiModel = new PlayerAkademiModel();
            $AkademiModel = new AkademiModel();

            $pager = \Config\Services::pager();
            $data['akademi'] = $AkademiModel->findAll();
            $data['mobile'] = $agent->isMobile();

            $request = \Config\Services::request();
            if ($request->getPost())
            {
                $academy = $this->request->getPost('academy');

                if (!empty($academy))
                {
                    $data['players'] = $PlayerAkademiModel->where('akademiid', $academy)->orderBy('birthdate', 'ASC')->orderBy('nama', 'ASC')->paginate(25, 'player');
                    $data['acd'] = $academy;
                    $sesdata = ['acad' => $academy];
                    $session->set($sesdata);
                }
                else
                {
                    $data['players'] = $PlayerAkademiModel->orderBy('birthdate', 'ASC')->orderBy('akademiid', 'ASC')->orderBy('nama', 'ASC')->paginate(25, 'player');
                    $session->remove('acad');
                }
            }
            else
            {
                if (isset($_SESSION['acad']))
                {
                    $academy = $_SESSION['acad'];
                    $data['players'] = $PlayerAkademiModel->where('akademiid', $academy)->orderBy('birthdate', 'ASC')->orderBy('nama', 'ASC')->paginate(25, 'player');
                    $data['acd'] = $academy;
                }
                else
                {
                    $data['players'] = $PlayerAkademiModel->orderBy('birthdate', 'ASC')->orderBy('akademiid', 'ASC')->orderBy('nama', 'ASC')->paginate(25, 'player');
                }
            }

            $data['pager'] = $PlayerAkademiModel->pager;

            echo view('templates/header', $data);
            echo '<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css" >';
            echo '<script src="/js/jquery.js"></script>';
            echo '<script src="/js/jquery.datetimepicker.full.min.js"></script>';
            echo view('templates/body-open', $data);
            if ($agent->isMobile()) {
				echo view('templates/navbar-mobile', $data);
			}
			else {
				echo view('templates/navbar-desktop', $data);
			}

            echo view('akademi/player', $data);

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

    public function uploadpic() {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$file = $this->request->getFile('filein');
			$validation =  \Config\Services::validation();
			$valid = $this->validate([
				'filein' => ['label' => 'dokumen', 'rules' => 'uploaded[filein]|mime_in[filein, image/jpg, image/jpeg]|max_size[filein, 80]']
			],
			[
				'filein' => [
					'uploaded' => '{field} belum terunggah.',
					'mime_in' => '{field} harus berupa gambar dengan extensi .jpg atau .jpeg',
					'max_size' => 'Maks ukuran {field} adalah 80kb.'
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
						$file->move(FCPATH.'../../images/akademi', $filename);
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

    public function addstudent()
    {
        $session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
        {
            $PlayerAkademiModel = new PlayerAkademiModel();
            $request = \Config\Services::request();
            if ($request->getPost())
            {
                $validation =  \Config\Services::validation();
                if (! $this->validate([
                    'name' => ['label' => 'Nama Lengkap', 'rules' => 'required'],
                    'birthdate' => ['label' => 'Tanggal Lahir', 'rules' => 'required'],
                    'academy' => ['label' => 'Akademi', 'rules' => 'required']
                ],
                [
                    'name' => [
						'required' => '{field} wajib diisi.'
					],
                    'academy' => [
						'required' => '{field} wajib diisi.'
					],
                    'birthdate' => [
						'required' => '{field} wajib diisi.'
					]
                ]))
                {
                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }
                else
                {
                    if ($this->request->getPost('pic') !== NULL) {
                        $submit = [
                            'nama' => $this->request->getPost('name'),
                            'akademiid' => $this->request->getPost('academy'),
                            'foto' => $this->request->getPost('pic'),
                            'birthdate' => $this->request->getPost('birthdate')
                        ];
                    } else {
                        $submit = [
                            'nama' => $this->request->getPost('name'),
                            'akademiid' => $this->request->getPost('academy'),
                            'birthdate' => $this->request->getPost('birthdate')
                        ];
                    }
                    
                    $PlayerAkademiModel->save($submit);
                    return redirect()->back()->with('success', 'Data pemain berhasil disimpan');
                }
            }
            else
            {
                return redirect()->to('/');
            }
        }
        else
        {
            return redirect()->to('login');
        }
    }

    public function addacademy()
    {
        $session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
        {
            $AkademiModel = new AkademiModel();
            $request = \Config\Services::request();
            if ($request->getPost())
            {
                $validation =  \Config\Services::validation();
                if (! $this->validate([
                    'name' => ['label' => 'Nama Lengkap', 'rules' => 'required']
                ],
                [
                    'name' => [
						'required' => '{field} wajib diisi.'
					]
                ]))
                {
                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }
                else
                {
                    $slug = $this->request->getPost('name');
					$slug = preg_replace('~[^\pL\d]+~u', '-', $slug);
					$slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
					$slug = preg_replace('~[^-\w]+~', '', $slug);
					$slug = trim($slug, '-');
					$slug = preg_replace('~-+~', '-', $slug);
					$slug = strtolower($slug);
                    $submit = [
                        'nama' => $this->request->getPost('name'),
                        'slug' => $slug
                    ];
                    $AkademiModel->save($submit);
                    return redirect()->back()->with('success', 'Data pemain berhasil disimpan');
                }
            }
            else
            {
                return redirect()->to('/');
            }
        }
        else
        {
            return redirect()->to('login');
        }
    }

    public function deletestudent($id)
    {
        $session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
        {
            $PlayerAkademiModel = new PlayerAkademiModel();
            $Student = $PlayerAkademiModel->find($id);
            $siswa = $Student['nama'];
            $PlayerAkademiModel->delete($id);
            return redirect()->back()->with('error', 'Siswa <b>'.$siswa.'</b> telah dihapus');
        }
        else
        {
            return redirect()->to('login');
        }
    }
}