<?php namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel;
use App\Models\PlayerModel;
use App\Models\TimModel;
use App\Models\PositionModel;
use App\Models\PositionGroup;
use App\Models\OfficialModel;
use CodeIgniter\I18n\Time;

class Tim extends Controller
{
	protected $helpers = ['url', 'text', 'form'];
    
    public function index() {
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

            $PlayerModel = new PlayerModel();
            $TimModel = new TimModel();
            $PositionModel = new PositionModel();
            $PositionGroup = new PositionGroup();

            $pager = \Config\Services::pager();
            $data['team'] = $TimModel->findAll();
            $data['positions'] = $PositionModel->findAll();
            $data['player'] = '';
            $data['mobile'] = $agent->isMobile();
            $data['posgroup'] = $PositionGroup->findAll();

            $request = \Config\Services::request();
			if ($request->getPost())
            {
                $tim = $this->request->getPost('tim');
                $position = $this->request->getPost('position');
                if ((!empty($tim)) && (!empty($position)))
                {
                    $data['player'] = $PlayerModel->where('timid', $tim)->where('positionid', $position)->orderBy('nopunggung', 'ASC')->paginate(25, 'player');
                    $data['selpos'] = $position;
                    $data['seltim'] = $tim;
                }
                elseif ((!empty($tim)) && (empty($position)))
                {
                    $data['player'] = $PlayerModel->where('timid', $tim)->orderBy('positionid', 'ASC')->orderBy('nopunggung', 'ASC')->paginate(25, 'player');
                    $data['seltim'] = $tim;
                }
                elseif ((empty($tim)) && (!empty($position)))
                {
                    $data['player'] = $PlayerModel->where('positionid', $position)->orderBy('timid', 'ASC')->orderBy('nopunggung', 'ASC')->paginate(25, 'player');
                    $data['selpos'] = $position;
                }
                else
                {
                    $data['player'] = $PlayerModel->orderBy('timid', 'ASC')->orderBy('positionid', 'ASC')->orderBy('nopunggung', 'ASC')->paginate(25, 'player');
                }
            }
            else
            {
                $data['player'] = $PlayerModel->orderBy('timid', 'ASC')->orderBy('positionid', 'ASC')->orderBy('nopunggung', 'ASC')->paginate(25, 'player');
            }

            $data['pager'] = $PlayerModel->pager;

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

            echo view('tim/player', $data);

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
    
    public function pelatih() {
        $session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
        {
			$data['lang'] = 'id';
			$data['title'] = "Daftar Pelatih";
			$data['desc'] = 'Daftar pelatih Mataram Utama FC';
			
			$userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);			
			$data['fullname'] = $user->fullname;

            $OfficialModel = new OfficialModel();

            $pager = \Config\Services::pager();
            $data['officials'] = $OfficialModel->findAll();
            $data['mobile'] = $agent->isMobile();

            $data['pager'] = $OfficialModel->pager;

            echo view('templates/header', $data);
            echo view('templates/body-open', $data);
            if ($agent->isMobile()) {
				echo view('templates/navbar-mobile', $data);
			}
			else {
				echo view('templates/navbar-desktop', $data);
			}

            echo view('tim/official', $data);

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
				'filein' => ['label' => 'dokumen', 'rules' => 'uploaded[filein]|mime_in[filein,image/png]|max_size[filein, 80]']
			],
			[
				'filein' => [
					'uploaded' => '{field} belum terunggah.',
					'mime_in' => '{field} harus berupa gambar dengan extensi .png',
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
						$file->move(FCPATH.'../../images/pemain', $filename);
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

    public function uploadpic() {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$file = $this->request->getFile('filein');
			$validation =  \Config\Services::validation();
			$valid = $this->validate([
				'filein' => ['label' => 'dokumen', 'rules' => 'uploaded[filein]|mime_in[filein,image/jpg,image/jpeg]|max_size[filein, 80]']
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
						$file->move(FCPATH.'../../images/pemain', $filename);
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

    public function uploadofficial() {
		$session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
		{
			$file = $this->request->getFile('filein');
			$validation =  \Config\Services::validation();
			$valid = $this->validate([
				'filein' => ['label' => 'dokumen', 'rules' => 'uploaded[filein]|mime_in[filein,image/png]|max_size[filein, 80]']
			],
			[
				'filein' => [
					'uploaded' => '{field} belum terunggah.',
					'mime_in' => '{field} harus berupa gambar dengan extensi .png',
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
						$file->move(FCPATH.'../../images/official', $filename);
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

    public function simpanpemain()
    {
        $session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
        {
            $PlayerModel = new PlayerModel();

            $request = \Config\Services::request();
            if ($request->getPost())
            {
                $validation =  \Config\Services::validation();
                $data['post'] = $request->getPost();

                if (! $this->validate([
                    'fullname' => ['label' => 'Nama Lengkap', 'rules' => 'required'],
                    'name' => ['label' => 'Nama Punggung', 'rules' => 'required'],
                    'no' => ['label' => 'Nomor Punggung', 'rules' => 'required'],
                    'height' => ['label' => 'Tinggi Badan', 'rules' => 'required','integer'],
                    'weight' => ['label' => 'Berat Badan', 'rules' => 'required','integer'],
                    'position' => ['label' => 'Tinggi Badan', 'rules' => 'required'],
                    'team' => ['label' => 'Tim', 'rules' => 'required'],
                    'birthdate' => ['label' => 'Tanggal Lahir', 'rules' => 'required'],
                    'pic' => ['label' => 'Foto Profil', 'rules' => 'required'],
                    'foto' => ['label' => 'Foto Header', 'rules' => 'required']
                ],
                [
                    'fullname' => [
						'required' => '{field} wajib diisi.'
					],
                    'name' => [
						'required' => '{field} wajib diisi.'
					],
                    'no' => [
						'required' => '{field} wajib diisi.'
					],
                    'height' => [
						'required' => '{field} wajib diisi.',
                        'integer' => '{field} harus berupa angka'
					],
                    'weight' => [
						'required' => '{field} wajib diisi.',
                        'integer' => '{field} harus berupa angka'
					],
                    'position' => [
						'required' => '{field} wajib diisi.'
					],
                    'team' => [
						'required' => '{field} wajib diisi.'
					],
                    'birthdate' => [
						'required' => '{field} wajib diisi.'
					],
                    'pic' => [
						'required' => '{field} wajib diisi.'
					],
                    'foto' => [
						'required' => '{field} wajib diisi.'
					]
                ]))
                {
                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }
                else
                {
                    $submit = [
                        'name' => $this->request->getPost('fullname'),
                        'namapunggung' => $this->request->getPost('name'),
                        'profilepic' => $this->request->getPost('pic'),
                        'photo' => $this->request->getPost('foto'),
                        'nopunggung' => $this->request->getPost('no'),
                        'tinggibadan' => $this->request->getPost('height'),
                        'beratbadan' => $this->request->getPost('weight'),
                        'tgllahir' => $this->request->getPost('birthdate'),
                        'positionid' => $this->request->getPost('position'),
                        'timid' => $this->request->getPost('team'),
                        'description' => $this->request->getPost('quote')
                    ];
                    $PlayerModel->save($submit);
                    return redirect()->back()->with('success', 'Data pemain berhasil disimpan');
                }
            }
            else
            { return redirect()->to('/'); }
        }
        else
        {
            return redirect()->to('login');
        }
    }
    
    public function simpanpelatih()
    {
        $session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
        {
            $OfficialModel = new OfficialModel();

            $request = \Config\Services::request();
            if ($request->getPost())
            {
                $validation =  \Config\Services::validation();
                $data['post'] = $request->getPost();

                if (! $this->validate([
                    'fullname' => ['label' => 'Nama Lengkap', 'rules' => 'required'],
                    'position' => ['label' => 'Posisi', 'rules' => 'required'],
                    'pic' => ['label' => 'Foto Profil', 'rules' => 'required']
                ],
                [
                    'fullname' => [
						'required' => '{field} wajib diisi.'
					],
                    'position' => [
						'required' => '{field} wajib diisi.'
					],
                    'pic' => [
						'required' => '{field} wajib diisi.'
					]
                ]))
                {
                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }
                else
                {
                    $submit = [
                        'name' => $this->request->getPost('fullname'),
                        'photo' => $this->request->getPost('foto'),
                        'position' => $this->request->getPost('position')
                    ];
                    $OfficialModel->save($submit);
                    return redirect()->back()->with('success', 'Data pelatih berhasil disimpan');
                }
            }
            else
            { return redirect()->to('/'); }
        }
        else
        {
            return redirect()->to('login');
        }
    }

    public function editpemain($id)
    {
        $session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
        {
            $PlayerModel = new PlayerModel();
            $TimModel = new TimModel();
            $PositionModel = new PositionModel();

            $player = $PlayerModel->find($id);

            $data['lang'] = 'id';
			$data['title'] = 'Edit '.$player['name'];
			$data['desc'] = 'Edit pemain '.$player['name'];
			
			$userid = $_SESSION['id'];
			$userModel = new UserModel();
			$user = $userModel->find($userid);			
			$data['fullname'] = $user->fullname;

            $pager = \Config\Services::pager();
            $data['team'] = $TimModel->findAll();
            $data['positions'] = $PositionModel->findAll();
            $data['player'] = $player;

            echo view('templates/header', $data);
            echo view('templates/body-open', $data);
            if ($agent->isMobile()) {
				echo view('templates/navbar-mobile', $data);
			}
			else {
				echo view('templates/navbar-desktop', $data);
			}

            echo view('tim/editplayer', $data);

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

    public function hapuspemain($id)
    {
        $session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
        {
            $PlayerModel = new PlayerModel();
            $player = $PlayerModel->find($id);
            $name = $player['name'];
            $PlayerModel->delete(['id' => $id]);
            return redirect()->back()->with('success', 'Data pemain <b>'.$name.'</b> berhasil dihapus');
        }
        else
        {
            return redirect()->to('login');
        }
    }

    public function playeredit()
    {
        $session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
        {
            $PlayerModel = new PlayerModel();
            
            $request = \Config\Services::request();
            if ($request->getPost())
            {
                $validation =  \Config\Services::validation();

                if (! $this->validate([
                    'id' => ['label' => 'ID Pemain', 'rules' => 'required'],
                    'fullname' => ['label' => 'Nama Lengkap', 'rules' => 'required'],
                    'name' => ['label' => 'Nama Punggung', 'rules' => 'required'],
                    'no' => ['label' => 'Nomor Punggung', 'rules' => 'required'],
                    'height' => ['label' => 'Tinggi Badan', 'rules' => 'required','integer'],
                    'weight' => ['label' => 'Berat Badan', 'rules' => 'required','integer'],
                    'position' => ['label' => 'Tinggi Badan', 'rules' => 'required'],
                    'team' => ['label' => 'Tim', 'rules' => 'required'],
                    'birthdate' => ['label' => 'Tanggal Lahir', 'rules' => 'required'],
                    'pic' => ['label' => 'Foto Profil', 'rules' => 'required'],
                    'foto' => ['label' => 'Foto Header', 'rules' => 'required']
                ],
                [
                    'id' => [
						'required' => '{field} wajib diisi.'
					],
                    'fullname' => [
						'required' => '{field} wajib diisi.'
					],
                    'name' => [
						'required' => '{field} wajib diisi.'
					],
                    'no' => [
						'required' => '{field} wajib diisi.'
					],
                    'height' => [
						'required' => '{field} wajib diisi.',
                        'integer' => '{field} harus berupa angka'
					],
                    'weight' => [
						'required' => '{field} wajib diisi.',
                        'integer' => '{field} harus berupa angka'
					],
                    'position' => [
						'required' => '{field} wajib diisi.'
					],
                    'team' => [
						'required' => '{field} wajib diisi.'
					],
                    'birthdate' => [
						'required' => '{field} wajib diisi.'
					],
                    'pic' => [
						'required' => '{field} wajib diisi.'
					],
                    'foto' => [
						'required' => '{field} wajib diisi.'
					]
                ]))
                {
                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }
                else
                {
                    $submit = [
                        'id' => $this->request->getPost('id'),
                        'name' => $this->request->getPost('fullname'),
                        'namapunggung' => $this->request->getPost('name'),
                        'profilepic' => $this->request->getPost('pic'),
                        'photo' => $this->request->getPost('foto'),
                        'nopunggung' => $this->request->getPost('no'),
                        'tinggibadan' => $this->request->getPost('height'),
                        'beratbadan' => $this->request->getPost('weight'),
                        'tgllahir' => $this->request->getPost('birthdate'),
                        'positionid' => $this->request->getPost('position'),
                        'timid' => $this->request->getPost('team'),
                        'description' => $this->request->getPost('quote')
                    ];
                    $PlayerModel->save($submit);
                    return redirect()->back()->with('success', 'Data pemain berhasil disimpan');
                }
            }
            else
            { return redirect()->to('/'); }
        }
        else
        {
            return redirect()->to('login');
        }
    }

    public function addposition()
    {
        $session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
        {
            $PositionModel = new PositionModel();

            $request = \Config\Services::request();
            if ($request->getPost())
            {
                $validation =  \Config\Services::validation();

                if (! $this->validate([
                    'name' => ['label' => 'Nama Posisi', 'rules' => 'required'],
                    'group' => ['label' => 'Grup Posisi', 'rules' => 'required']
                ],
                [
                    'name' => [
						'required' => '{field} wajib diisi.'
					],
                    'group' => [
						'required' => '{field} wajib diisi.'
					]
                ]))
                {
                    return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
                }
                else
                {
                    $submit = [
                        'name' => $this->request->getPost('name'),
                        'goupid' => $this->request->getPost('group')
                    ];
                    $PlayerModel->save($submit);
                    return redirect()->back()->with('success', 'Data posisi berhasil disimpan');
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

    public function addteam()
    {
        $session = \Config\Services::session();
		$agent = $this->request->getUserAgent();
		$data['uri'] = $this->request->uri;
		if (isset($_SESSION['id']))
        {
            $TimModel = new TimModel();

            $request = \Config\Services::request();
            if ($request->getPost())
            {
                $validation =  \Config\Services::validation();

                if (! $this->validate([
                    'name' => ['label' => 'Nama Posisi', 'rules' => 'required']
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
                        'name' => $this->request->getPost('name'),
                        'slug' => $slug
                    ];
                    $PlayerModel->save($submit);
                    return redirect()->back()->with('success', 'Data tim berhasil disimpan');
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
}