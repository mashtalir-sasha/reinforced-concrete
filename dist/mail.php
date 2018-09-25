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
		$fileLink ="http://site.com/uploads/$file";
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

	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	$headers .= "From: no-reply@site.com"; // Заменить домен на домен клиента

	if (!$title && !$phonenum) {
	} else {
		mail($to,"New lead(site.com)",$message,$headers); // Заменить домен на домен клиента
	}
?>