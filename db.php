<?PHP

$user = 'u67293';
$pass = '3126725';
$db = new PDO(
    'mysql:host=localhost;dbname=u67293',
    $user,
    $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

try {
    $stmt = $db->prepare("INSERT INTO users (full_name, phone,email,birth_date,gender,bio,contract_agreed) VALUES (:full_name, :phone,:email,:birth_date,:gender,:bio,:contract_agreed)");
    $login = $_POST['login'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $date = $_POST['date'];
    $someGroupName = $_POST['someGroupName'];
    $bio = $_POST['bio'];
    $checkt = $_POST['checkt'];
    $stmt->bindParam(':full_name', $login);
    $stmt->bindParam(':phone', $tel);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':birth_date', $date);
    $stmt->bindParam(':gender', $someGroupName);
    $stmt->bindParam(':bio', $bio);
    $stmt->bindParam(':contract_agreed', $checkt);
    $stmt->execute();
    $user_id = $db->lastInsertId();
    $Languages =  $_POST['language'];   
    foreach ($Languages as $language_name) {
        $stmt = $db->prepare("INSERT INTO user_languages (user_id, language_name) VALUES (:user_id,:language_name)");
         $stmt->bindParam(':user_id', $user_id);
         $stmt->execute([':language_name', $language_name]);
         $stmt->execute();
    }
    
} catch (PDOException $e) {
    print ('Error : ' . $e->getMessage());
    exit();
}

//error
function clear_data($val){
  $val = trim($val);
  $val = stripslashes($val);
  $val = strip_tags($val);
  $val = htmlspecialchars($val);
  return $val;
}

$login = clear_data($_POST['login']);
$tel = clear_data($_POST['tel']);
$email = clear_data($_POST['email']);
$date = clear_data($_POST['date']);
$someGroupName = clear_data($_POST['someGroupName']);
$checkt = clear_data($_POST['checkt']);
$bio = clear_data($_POST['bio']);

$pattern_tel = '/^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/';

$pattern_login = '/^[А-ЯЁ][а-яё]*$/';
$err = [];
$flag = 0;
// echo $err['login'];
// echo $err['tel'];
// echo $err['email'];
// echo $err['date'];
// echo $err['bio'];
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if (preg_match($pattern_login, $login)){
      $err['login'] = '<small class="text-danger">Введите корректное имя</small>';
      $flag = 1;
  }
  if (mb_strlen($login) > 10 || empty($name)){
      $err['name'] = '<small class="text-danger">Имя должно быть не больше 10 символов</small>';
      $flag = 1;
  }
  if (!preg_match($pattern_tel, $tel)){
      $err['tel'] = '<small class="text-danger">Формат телефона не верный!</small>';
      $flag = 1;
  }
  if (empty($tel)){
      $err['tel'] = '<small class="text-danger">Поле не может быть пустым</small>';
      $flag = 1;
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $err['email'] = '<small class="text-danger">Формат Email не верный!</small>';
      $flag = 1;
  }
  if (empty($email)){
      $err['email'] = '<small class="text-danger">Поле не может быть пустым</small>';
      $flag = 1;
  }
  if (empty($_POST['date']) || !is_numeric($_POST['date']) || !preg_match('/^\d+$/', $_POST['date'])) {
    print('Заполните год.<br/>');
    $errors = TRUE;
  }
  for ($i = 1960; $i <= 2006; $i++) {
    printf('<option value="%d">%d год</option>', $i, $i);
  }
  // if (!filter_var($ip, FILTER_VALIDATE_IP)){
  //     $err['ip'] = '<small class="text-danger">Формат ip не верный!</small>';
  //     $flag = 1;
  // }
  // if (empty($ip)){
  //     $err['ip'] = '<small class="text-danger">Поле не может быть пустым</small>';
  //     $flag = 1;
  // }
  // if (!filter_var($url, FILTER_VALIDATE_URL)){
  //     $err['url'] = '<small class="text-danger">Формат url не верный!</small>';
  //     $flag = 1;
  // }
  // if (empty($url)){
  //     $err['url'] = '<small class="text-danger">Поле не может быть пустым</small>';
  //     $flag = 1;
  // }
  if (empty($bio)){
      $err['bio'] = '<small class="text-danger">Поле не может быть пустым</small>';
      $flag = 1;
  }
  if ($flag == 0){
    header('Location: ?save=1');

  }
}
// if ($_GET['mes'] == 'success'){
//   $err['success'] = '<div class="alert alert-success">Сообщение успешно отправлено!</div>';
// }





?>