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
    $stmt = $db->prepare("INSERT INTO language (lange_name) VALUES (@lange_name)");
    $lange = json_encode($_POST['lange']);
    $stmt->execute();
} catch (PDOException $e) {
    print ('Error : ' . $e->getMessage());
    exit();
}
// try {
//     $stmt = $db->prepare("INSERT INTO language (lange_name) VALUES (:lange_name)");
//     $lange = json_encode($_POST['lange']);
//     $stmt->execute();
// } catch (PDOException $e) {
//     print ('Error : ' . $e->getMessage());
//     exit();
// }

?>