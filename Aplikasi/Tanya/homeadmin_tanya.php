<?php
namespace Aplikasi\Tanya; //echo __NAMESPACE__; 
class Homeadmin_Tanya extends \Aplikasi\Kitab\Tanya
{
#====================================================================================================
	public function __construct()
	{
		parent::__construct();
	}
#---------------------------------------------------------------------------------------------------#
	
#---------------------------------------------------------------------------------------------------#
	public function semakPost($myTable, $senarai, $post)
	{
		# validasi data $_POST, masuk dalam $posmen, validasi awal
		foreach ($post as $myTable => $value)
			if ( in_array($myTable,$senarai) )
				foreach ($value as $key => $value2)
					foreach ($value2 as $kekunci => $papar)
						$posmen[$myTable][0][$kekunci] = bersih($papar);
						//echo "$kekunci";
		
		# pulangkan pemboleubah
		return $posmen;		
	}
#---------------------------------------------------------------------------------------------------#
	public function ubahPosmen($posmen)
	{
		//echo '<pre>$posmen='; print_r($posmen) . '</pre>';
		$cantum = "('";
		$senaraiData = array();
		foreach ($posmen as $key => $value1):
			foreach ($value1 as $key2): 
			foreach ($key2 as $key3 => $dataS):
				$cantum .= ($dataS) . "', '"; 
			endforeach;
		endforeach;
		endforeach;
		$cantum .= "')";
		$senaraiData[0] = $cantum;
		$senaraiData[0] = substr($senaraiData[0], 0, -5) . ')';
		# pulangkan pemboleubah
		return $senaraiData;
	}
#---------------------------------------------------------------------------------------------------#
#---------------------------------------------------------------------------------------------------#
#---------------------------------------------------------------------------------------------------#
#---------------------------------------------------------------------------------------------------#
#====================================================================================================
}