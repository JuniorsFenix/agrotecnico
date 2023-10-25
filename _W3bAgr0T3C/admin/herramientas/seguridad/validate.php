<?php 

class varValidator {
	
	private static function validateMethod($method){
		if( $method!="get" && $method!="post"){
			echo "Metodo invalido {$method}, solo se permite get y post";
			exit;
		}
	}
	
	private static function getVar($method,$name){
		
		if( $method=="post" && isset($_POST[$name])){
			return $_POST[$name];
		}
		
		if( $method=="get" && isset($_GET[$name])){
			return $_GET[$name];
		}
		
		throw new Exception("Invalid var");
	}
		
	public static function validateReqInt($method,$name,$required=true,$default='0'){
		self::validateMethod($method);
		
		try {
			$var = self::getVar($method,$name);
		}
		catch (Exception $e){
			if($required) return null;
			if(!$required) return $default;			
		}

		$var = filter_var($var,FILTER_VALIDATE_INT,FILTER_NULL_ON_FAILURE);
		return $var; 	
	}

	public static function validateReqFloat($method,$name,$required=true,$default=''){
		self::validateMethod($method);
		
		try {
			$var = self::getVar($method,$name);
		}
		catch (Exception $e){
			if($required) return null;
			if(!$required) return $default;			
		}

		$var = filter_var($var,FILTER_VALIDATE_FLOAT,FILTER_NULL_ON_FAILURE);
		return $var; 	
	}
	
	public static function validateReqEmail($method,$name,$required=true,$default=''){
		self::validateMethod($method);
		
		try {
			$var = self::getVar($method,$name);
		}
		catch (Exception $e){
			if($required) return null;
			if(!$required) return $default;			
		}

		$var = filter_var($var,FILTER_VALIDATE_EMAIL,FILTER_NULL_ON_FAILURE);
		return $var; 	
	}

	public static function validateReqUrl($method,$name,$required=true,$default=''){
		self::validateMethod($method);
		
		try {
			$var = self::getVar($method,$name);
		}
		catch (Exception $e){
			if($required) return null;
			if(!$required) return $default;			
		}

		$var = filter_var($var,FILTER_VALIDATE_URL,FILTER_NULL_ON_FAILURE);
		return $var; 	
	}
	
	
	public static function validateReqString($method,$name,$required=true,$default=''){
		self::validateMethod($method);
		
		try {
			$var = self::getVar($method,$name);
		}
		catch (Exception $e){
			if($required) return null;
			if(!$required) return $default;			
		}

		$var = filter_var($var,FILTER_SANITIZE_STRING,FILTER_NULL_ON_FAILURE);
		return addslashes($var); 	
	}
	
	
}

/*
$codigo = varValidator::validateReqInt('get','codigo');
if(is_null($codigo)){
	echo "Valor de entrada invalido para el campo codigo";
	exit;
}


$email = varValidator::validateReqEmail('get','email');
if(is_null($email)){
	echo "Valor de entrada invalido para el campo email";
	exit;
}


$string = varValidator::validateReqString('get','string');
if(is_null($string)){
	echo "Valor de entrada invalido para el campo string";
	exit;
}



echo $string;
*/
?>