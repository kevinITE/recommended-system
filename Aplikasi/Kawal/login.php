<?php
namespace Aplikasi\Kawal; //echo __NAMESPACE__; 
class Login extends \Aplikasi\Kitab\Kawal
{
#==========================================================================================
	function __construct()
	{
		//echo '<br>class Index extends Kawal';
		parent::__construct();
		//\Aplikasi\Kitab\Kebenaran::kawalMasuk();
		$this->_folder = huruf('kecil', namaClass($this));
	}
#==========================================================================================
	public function index()
	{
		# Set pemboleubah utama
		$this->papar->menuatas = 'tak';
		$this->papar->TajukBesar = 'Sila Login';

		# Pergi papar kandungan
		//$this->semakPembolehubah($this->papar->mesej); # Semak data dulu
		$this->paparKandungan($this->_folder, 'index');
	}

	public function paparKandungan($folder, $fail, $noInclude = 0)
	{	# Pergi papar kandungan
		$jenis = $this->papar->pilihTemplate($template=0);
		$this->papar->bacaTemplate(
		//$this->papar->paparTemplate(
			$folder . '/' . $fail, $jenis, $noInclude); # $noInclude=0
			//'mobile/mobile',$jenis,0); # $noInclude=0
		//*/
	}

	public function semakPembolehubah($senarai)
	{
		echo '<pre>$senarai:<br>';
		print_r($senarai);
		echo '</pre>|';//*/
	}
#==========================================================================================
	function registerid()
	{
		# debug $_POST
		//echo '<pre>Test $_POST->'; print_r($_POST) . '</pre>';
		//$this->tanya->dapatid($_POST['password']);

		# Set pemboleubah utama
		$myTable = 'biodata';
		$senarai = array($myTable);
		$medan = '`namaawal`,`namaakhir`,`phone_number`,`email`,`password`,`level`';

		# bentuk tatasusunan
		$posmen = $this->tanya->semakPOST($myTable, $senarai, $_POST);
		$senaraiData = $this->tanya->ubahPosmen($posmen, $myTable);
		# sql insert
		//$this->tanya->tambahSqlBanyakNilai($myTable, $medan, $senaraiData); 
		$this->tanya->tambahBanyakNilai($myTable, $medan, $senaraiData); 
		//$this->log_sql($myTable, $medan, $senaraiData);
		# semak data
			//echo '<pre>$_POST='; print_r($_POST) . '</pre>';
			//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
			//echo '<pre>$senaraiData='; print_r($senaraiData) . '</pre>';
		# pergi papar kandungan
		//echo '<br>location: ' . URL . $this->_folder . '/rangkabaru/selesai';
		header('location: ' . URL . '');
		//*/
	}

	function semakid()
	{
		# debug $_POST
		//echo '<pre>Test $_POST->'; print_r($_POST) . '</pre>';
		//$this->tanya->dapatid($_POST['password']);

		# semak data $this->tanya->ujiID(); 
		$this->tanya->semakid();
		//*/
	}

	function salah()
	{
		# debug
		//$this->tanya->dapatid($_POST['password']);
		$this->papar->mesej = 'Ada masalah pada user dan password';

		# Set pemboleubah utama
		$this->papar->sesat = 'Enjin Carian - Sesat';
		$this->papar->isi = '';

		# Pergi papar kandungan
		//$this->semakPembolehubah($this->papar->mesej); # Semak data dulu
		$this->paparKandungan('index', 'salah');
	}
#==========================================================================================
	function register()
	{
		# Pergi papar kandungan
		//$this->semakPembolehubah($this->papar->mesej); # Semak data dulu
		$this->paparKandungan('index', 'register');
	}
#==========================================================================================
	function enter()
	{
		# Pergi papar kandungan
		//$this->semakPembolehubah($this->papar->mesej); # Semak data dulu
		$this->paparKandungan('index', 'login2', $noInclude=1);
	}
#==========================================================================================
	function checkid()
	{
		# semak data $_POST
		//echo '<pre>Test $_POST->'; print_r($_POST) . '</pre>';
		$email = $_POST['biodata'][0]['email'];
		$passwordAsal = $_POST['biodata'][0]['password'];
		$password = \Aplikasi\Kitab\RahsiaHash::rahsia('md5', $passwordAsal);
		//echo '<pre>password->'; print_r($password); echo '</pre>';

		# semak database
			$myTable = 'biodata';
			$medan = 'namaawal, namaakhir, phone_number, email, password, level';
			$carian[] = array('fix'=>'like', # cari x= atau %like%
				'atau'=>'WHERE', # WHERE / OR / AND
				'medan' => 'email', # cari dalam medan apa
				'apa' => $email); # benda yang dicari
			$carian[] = array('fix'=>'like', # cari x= atau %like%
				'atau'=>'AND', # WHERE / OR / AND
				'medan' => 'password', # cari dalam medan apa
				'apa' => $password); # benda yang dicari
			# mula cari $cariID dalam $myJadual
				$cariNama = 
					$this->tanya->cariSemuaData("`$myTable`", $medan, $carian, null);
					//$this->tanya->cariSql("`$myTable`", $medan, $carian, null);
				$kira = sizeof($cariNama);
		//echo '<pre>Test $_POST->'; print_r($_POST) . '</pre>';
		//echo '<pre>$cariNama::'; print_r($cariNama) . '<pre>';
		//echo '<hr>$data->' . sizeof($cariNama) . '<hr>';

		$this->kunciPintu($kira, $cariNama); # pilih pintu masuk
	}

	function kunciPintu($kira, $data)
	{
		if ($kira == 1) 
		{	# login berjaya
			\Aplikasi\Kitab\Sesi::init(); # setkan $_SESSION utk 
			# namaPenuh,namaPendek,kataLaluan,level 
			\Aplikasi\Kitab\Sesi::set('namaawal', $data[0]['namaawal']);
			\Aplikasi\Kitab\Sesi::set('namaakhir', $data[0]['namaakhir']);
			\Aplikasi\Kitab\Sesi::set('phone_number', $data[0]['phone_number']);
			\Aplikasi\Kitab\Sesi::set('email', $data[0]['email']);
			\Aplikasi\Kitab\Sesi::set('levelPengguna', $data[0]['level']);
			\Aplikasi\Kitab\Sesi::set('loggedIn', true);
			//echo '<hr>Berjaya';
			$this->levelPengguna($kira, $data, $data[0]['level']);
		} 
		else # login gagal
		{	//echo '<hr>Tidak Berjaya';
			header('location:' . URL . 'login/salah');
		}//*/
	}

	function levelPengguna($kira, $data, $level)
	{
		//header('location:' . URL . 'ruangtamu');
		if ($level == 'user')
			header('location:' . URL . 'homeuser');
		elseif($level == 'admin')
			header('location:' . URL . 'homeadmin');
		elseif($level == 'admin2')
			header('location:' . URL . 'homeadmin2');
		else
			header('location:' . URL . ''); //*/
	}

#==========================================================================================
}
