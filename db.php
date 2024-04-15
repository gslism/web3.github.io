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
    $login = $_POST['login'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $date = date_diff(date_create($date), date_create('today'))->y;
    if (!preg_match('/^[А-ЯЁёа-я\s]+$/u', $login)) {
        echo " <p style='color: pink;'>Ошибка: поле должно содержать только русские буквы</p>";
        $login = '';
    } elseif (substr($tel, 0, 2) !== '8') {
        echo " <p style='color: red;'>Ошибка: номер телефона должен начинаться с 8</p>";
        $tel = '';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p style='color: red;'>Ошибка: неправильный формат email</p>";
        $email = '';
    } elseif ($date < 18) {
        echo "<p style='color: red;'>Ошибка: пользователь должен быть совершеннолетним</p>";
    } else {

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
        $Languages = $_POST['language'];

        foreach ($Languages as $language_name) {
            $stmt = $db->prepare("INSERT INTO user_languages (user_id, language_name) VALUES (:user_id,:language_name)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':language_name', $language_name);
            $stmt->execute();
        }
        echo "<h5 style='color: green;'>Форма успешно сохранена</h5>";
    }
} catch (PDOException $e) {
    print ('Error : ' . $e->getMessage());
    exit();
}


?>