<?php
$answer = $name = $email = $message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (empty($name) || empty($email) || empty($message)) {
        $answer = '<p style="color:red; font-weight:bold;">Пожалуйста, заполните все поля!</p>';
    } else {
        $answer = '<p style="color:green; font-weight:bold;">Ваше сообщение отправлено!</p>';
        $name = $email = $message = '';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Контакты</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" href="../assets/images/logo.png">
</head>
<?php include '../includes/header.php'; ?>
<main>
    <h1>Контакты</h1>
    <?= $answer ?>
    <form method="post">
        <input type="text" name="name" placeholder="Имя">
        <input type="email" name="email" placeholder="Email">
        <textarea name="message"><?= $message ?></textarea>
        <button type="submit">Отправить</button>
    </form>
</main>
<?php include '../includes/footer.php'; ?>