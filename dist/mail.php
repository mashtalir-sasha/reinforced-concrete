<?
	if(isset ($_POST['title'])) {$title=$_POST['title'];}
	if(isset ($_POST['name'])) {$name=$_POST['name'];}
	if(isset ($_POST['phonenumb'])) {$phonenum=$_POST['phonenumb'];}
	if(isset ($_POST['email'])) {$email=$_POST['email'];}
	if(isset ($_POST['addr'])) {$addr=$_POST['addr'];}
	if(isset ($_POST['product'])) {$product=$_POST['product'];}
	if(isset ($_POST['number'])) {$number=$_POST['number'];}

	if ( isset($_FILES['file']['tmp_name']) ) {
		$file = $_FILES['file']['name'];
		$uploaddir = 'uploads/';
		$uploadfile = $uploaddir . basename($file);
		move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
		$fileLink ="http://site.com/uploads/$file"; // Заменить домен на домен клиента
	}

	$to = "mashtalir_sasha@ukr.net"; // Замениь на емаил клиента

	$message = "Форма: $title <br><br>";
	if ( $name || $phonenum || $email || $addr || $product || $number || $file) {
		$message .= ""
			. ( $name ?" Имя:  $name <br>" : "")
			. ( $phonenum ?" Телефон:  $phonenum <br>" : "")
			. ( $email  ? " E-mail: $email <br>" : "")
			. ( $addr ?" Адрес:  $addr <br>" : "")
			. ( $product ?" Название изделия:  $product <br>" : "")
			. ( $number ?" Кол-во изделий:  $number <br>" : "")
			. ( $file ?" Файл: $fileLink <br>" : "");
	}

	$comments = "";
	if ($addr || $product || $number || $file) {
		$comments .= ""
			. ( $addr ?" Адрес:  $addr <br>" : "")
			. ( $product ?" Название изделия:  $product <br>" : "")
			. ( $number ?" Кол-во изделий:  $number <br>" : "")
			. ( $file ?" Файл: $fileLink <br>" : "");
	}

	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	$headers .= "From: no-reply@site.com"; // Заменить домен на домен клиента

	if (!$title && !$phonenum) {
	} else {
		mail($to,"New lead(site.com)",$message,$headers); // Заменить домен на домен клиента

		// CRM server conection data
		define('CRM_HOST', 'novomoskovskij-dp-ua.bitrix24.ua');
		define('CRM_PORT', '443');
		define('CRM_PATH', '/crm/configs/import/lead.php');
		define('CRM_AUTH', 'e4793fc78fb22dcda2a1350875c7ac59');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$postData = array(
				'TITLE' => $title,
				'NAME' => $name,
				'PHONE_WORK' => $phonenum,
				'EMAIL_WORK' => $email,
				'SOURCE_ID' => WEB,
				'COMMENTS' => $comments
			);
			if (defined('CRM_AUTH')) {
				$postData['AUTH'] = CRM_AUTH;
			} else {
				$postData['LOGIN'] = CRM_LOGIN;
				$postData['PASSWORD'] = CRM_PASSWORD;
			}
			$fp = fsockopen("ssl://".CRM_HOST, CRM_PORT, $errno, $errstr, 30);
			if ($fp) {
				$strPostData = '';
				foreach ($postData as $key => $value)
					$strPostData .= ($strPostData == '' ? '' : '&').$key.'='.urlencode($value);
				$str = "POST ".CRM_PATH." HTTP/1.0\r\n";
				$str .= "Host: ".CRM_HOST."\r\n";
				$str .= "Content-Type: application/x-www-form-urlencoded\r\n";
				$str .= "Content-Length: ".strlen($strPostData)."\r\n";
				$str .= "Connection: close\r\n\r\n";
				$str .= $strPostData;
				fwrite($fp, $str);
				$result = '';
				while (!feof($fp)) {
					$result .= fgets($fp, 128);
				}
				fclose($fp);
				$response = explode("\r\n\r\n", $result);
				$output = '<pre>'.print_r($response[1], 1).'</pre>';
			} else {
				echo 'Connection Failed! '.$errstr.' ('.$errno.')';
			}
		} else {$output = '';}
	}
?>