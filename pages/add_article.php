<?php
// pages/add_article.php
require_once '../includes/db.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $author = trim($_POST['author_name'] ?? 'Администратор');
    $rating = max(1, min(5, (int)($_POST['rating'] ?? 5)));
    
    if (!$title || !$content) {
        $msg = '<div class="alert error">❌ Заголовок и содержание обязательны</div>';
    } else {
        $res = pg_query_params($conn,
            "INSERT INTO articles (title, content, author_name, rating) 
             VALUES ($1, $2, $3, $4) RETURNING id",
            [$title, $content, $author, $rating]
        );
        if ($res) {
            $id = pg_fetch_result($res, 0, 0);
            header("Location: /articles.php?id=$id");
            exit;
        } else {
            $msg = '<div class="alert error">❌ ' . pg_last_error($conn) . '</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Новая статья</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <main class="container">
        <h1>➕ Новая статья</h1>
        <?= $msg ?>
        <!-- <form method="post" class="form">
            <label class="form-group">Заголовок *<br>
                <input type="text" name="title" required 
                       value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
            </label>
            <label><br>Автор<br>
                <input type="text" name="author_name" 
                       value="<?= htmlspecialchars($_POST['author_name'] ?? 'Администратор') ?>">
            </label>
            <label><br>Рейтинг (1-5)
                <select name="rating">
                    <?php for($i=1;$i<=5;$i++): ?>
                        <option value="<?= $i ?>" <?= (($_POST['rating']??5)==$i)?'selected':'' ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </label>
            <label><br>Содержание *<br>
                <textarea name="content" required rows="10"><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
            </label>
            <br><button type="submit">💾 Опубликовать</button>
            <a href="/articles.php" class="btn-secondary">Отмена</a>
        </form> -->
        <form method="post" class="form">
    <div class="form-group">
        <label>Заголовок *</label>
        <input type="text" name="title" class="form-control" required 
               value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
    </div>
    
    <div class="form-group">
        <label>Автор</label>
        <input type="text" name="author_name" class="form-control" 
               value="<?= htmlspecialchars($_POST['author_name'] ?? 'Администратор') ?>">
    </div>
    
    <div class="form-group">
        <label>Рейтинг (1-5)</label>
        <select name="rating" class="form-control">
            <?php for($i=1;$i<=5;$i++): ?>
                <option value="<?= $i ?>" <?= (($_POST['rating']??5)==$i)?'selected':'' ?>><?= $i ?></option>
            <?php endfor; ?>
        </select>
    </div>
    
    <div class="form-group">
        <label>Содержание *</label>
        <textarea name="content" class="form-control" required rows="10"><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-success">💾 Опубликовать</button>
        <a href="/articles.php" class="btn btn-secondary">Отмена</a>
    </div>
</form>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
