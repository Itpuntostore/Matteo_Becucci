<?php
function formatta_data($maschera, $data, $language) {
	 
	  switch($language) {
		case "it":  
			$arr_weekdays = array('Domenica', 'Lunedi\'', 'Martedi\'', 'Mercoledi\'', 'Giovedi\'', 'Venerdi\'', 'Sabato');
	  		$arr_months = array('Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');
		break;
	 	case "en":  
			$arr_weekdays = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
	  		$arr_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		break;
	  }
	  if($data == '') {
		$data = time();
	  }
	 
	  $arr_maschera = str_split($maschera);
	 
	  $s = '';
	 
	  foreach($arr_maschera as $m) {
		switch($m) {
		  case 'F': $s .= $arr_months[date('n', $data) - 1]; break;
		  case 'M': $s .= substr($arr_months[date('n', $data) - 1], 0, 3); break;
		  case 'l': $s .= $arr_weekdays[date('w', $data)]; break;
		  case 'D': $s .= $arr_weekdays[date('w', $data)]; break;
		  default: $s .= date($m, $data); break;
		}
	  }
	 
	  return $s;
	}
?>