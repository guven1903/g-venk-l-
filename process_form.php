<?php

$ilkisim = $_POST['ilkisim'];
$soyadi = $_POST['soyadi'];
$email = $_POST['e-posta'];
$sifre = $_POST['sifre'];
$passwordConfirm = $_POST['passwordConfirm'];
$dogumtarihi = $_POST['dogumtarihi'];
$cinsiyet = $_POST['cinsiyet'];


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Lütfen Var olan bir Mail Hesabı giriniz.");
}

if (strlen($sifre) < 6) {
    die("en az 7 karakterli bir şifre giriniz.");
}

if ($sifre !== $passwordConfirm) {
    die("Şifreler eşleşmiyor.");
}


$hashed_password = password_hash($sifre, PASSWORD_DEFAULT);


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "webprogramlama";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}


$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    die("Bu e-posta adresi zaten kullanılıyor.");
}


$sql = "INSERT INTO users (firstname, lastname, email, password, birthdate, gender) VALUES ('$ilkisim', '$soyadi', '$email', '$hashed_password', '$dogumtarihi', '$cinsiyet')";

if ($conn->query($sql) === TRUE) {
    echo "Hastane kaydınız başarıyla oluşturuldu";
} else {
    echo "Hata: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
