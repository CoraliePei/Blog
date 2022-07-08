<?php
require('inc/pdo.php');
require('inc/fonction.php');
require('inc/request.php');

$allArticles = getAllArticles('DESC');
debug($allArticles);

include('inc/header.php'); ?>

<h1>Home page</h1>
<h2>Derniers articles parus</h2>

<ul>
    <?php foreach ($allArticles as $article) {
        if ($article['status'] === 'publish') {
    ?>
            <li>
                <h2><?php echo ucfirst($article['title']); ?></h2>
                <h3><?php echo ucfirst($article['auteur']); ?></h3>
                <p>Posté le : <?php echo dateSite($article['created_at']); ?></p>
                <a href="single.php?id=<?php echo $article['id']; ?>">Lire l'article</a>
            </li>
    <?php }
    } ?>
</ul>


<?php include('inc/footer.php');
