<?php
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/request.php');

if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM articles WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $article = $query->fetch();
    // debug($beer);
    if (empty($article)) {
        die('404');
    }
} else {
    die('404');
}

include('inc/header.php'); ?>


<h2><?php echo strtoupper($article['title']); ?></h2>
<h2>Articlé écrit par <?php echo ucfirst($article['auteur']); ?>.</h2>
<p><?php echo nl2br($article['content']); ?></p>
<p>Date: <?php echo dateSite($article['created_at']); ?></p>
<?php if (dateSite($article['created_at']) !== dateSite($article['modified_at'])) { ?>
    <p>Modifié le : <?php echo dateSite($article['modified_at']);
                } ?></p>





    <?php include('inc/footer.php');
