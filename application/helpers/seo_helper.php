<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('seo')){
    function seo($link, $ret = false){ 
		$newLink = '';
		       
		$arrSym = array(
		"a", "ả", "ã", "à", "á", "ạ", "A", "Ả", "Ã", "À", "Á", "Ạ",
		"â", "ẩ", "ẫ", "ầ", "ấ", "ậ", "Â", "Ẩ", "Ẫ", "Ầ", "Ấ", "Ậ",
		"ă", "ẳ", "ẵ", "ằ", "ắ", "ặ", "Ă", "Ẳ", "Ẵ", "Ằ", "Ắ", "Ặ",
		"e", "ẻ", "ẽ", "è", "é", "ẹ", "E", "Ẻ", "Ẽ", "È", "É", "Ẹ",
		"ê", "ể", "ễ", "ề", "ế", "ệ", "Ê", "Ể", "Ễ", "Ề", "Ế", "Ệ", 
		"i", "ỉ", "ĩ", "ì", "í", "ị", "I", "Ỉ", "Ĩ", "Ì", "Í", "Ị", 
		"o", "ỏ", "õ", "ò", "ó", "ọ", "O", "Ỏ", "Õ", "Ò", "Ó", "Ọ",
		"ô", "ổ", "ỗ", "ồ", "ố", "ộ", "Ô", "Ổ", "Ỗ", "Ồ", "Ố", "Ộ",
		"ơ", "ở", "ỡ", "ờ", "ớ", "ợ", "Ơ", "Ở", "Ỡ", "Ờ", "Ớ", "Ộ",
		"u", "ủ", "ũ", "ù", "ú", "ụ", "U", "Ủ", "Ũ", "Ù", "Ú", "Ụ",
		"ư", "ử", "ữ", "ừ", "ứ", "ự", "Ư", "Ử", "Ữ", "Ừ", "Ứ", "Ự",
		"y", "ỷ", "ỹ", "ỳ", "ý", "ỵ", "Y", "Ỷ", "Ỹ", "Ỳ", "Ý", "Ỵ",
		"đ", "Đ",
		);
		
		$arrRep = array(
		"a", "a", "a", "a", "a", "a", "A", "A", "A", "A", "A", "A",
		"a", "a", "a", "a", "a", "a", "A", "A", "A", "A", "A", "A",
		"a", "a", "a", "a", "a", "a", "A", "A", "A", "A", "A", "A",
		"e", "e", "e", "e", "e", "e", "E", "E", "E", "E", "E", "E",
		"e", "e", "e", "e", "e", "e", "E", "E", "E", "E", "E", "E", 
		"i", "i", "i", "i", "i", "i", "I", "I", "I", "I", "I", "I", 
		"o", "o", "o", "o", "o", "o", "O", "O", "O", "O", "O", "O",
		"o", "o", "o", "o", "o", "o", "O", "O", "O", "O", "O", "O",
		"o", "o", "o", "o", "o", "o", "O", "O", "O", "O", "O", "O",
		"u", "u", "u", "u", "u", "u", "U", "U", "U", "U", "U", "U",
		"u", "u", "u", "u", "u", "u", "U", "U", "U", "U", "U", "U",
		"y", "y", "y", "y", "y", "y", "Y", "Y", "Y", "Y", "Y", "Y",
		"d", "D",
		);
		
		$linkConvert = str_replace($arrSym, $arrRep, $link);
		$pattern = "/[a-zA-Z0-9]+/";
		preg_match_all($pattern, $linkConvert, $matches);
		
		
		foreach($matches[0] as $key => $val){
			$newLink .= "-" . ucwords($val);
		}		
		
		if($ret == true){
			return strtolower(substr($newLink, 1));	
		}else{
			echo strtolower(substr($newLink, 1));
		}	
    }   
}
