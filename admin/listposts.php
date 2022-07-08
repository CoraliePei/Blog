<?php
require('../inc/request.php');
require('../inc/fonction.php');
require('../inc/pdo.php');

// // Get all beers
// $sql = "SELECT * FROM beer ORDER BY created_at DESC";
// $query = $pdo->prepare($sql);
// $query->execute();
// fetchAll, fetch , fetchColumn
// $beers = $query->fetchAll();
$allArticles = getAllArticles('ASC');
debug($allArticles);

include('inc/header-back.php'); ?>

<h1>Liste de tous les articles</h1>
<a href="newpost.php">Ajouter un nouvel article</a>
<ul>
    <?php foreach ($allArticles as $article) {
        //debug($beer); 
    ?>
        <li>
            <p><?php echo $article['id']; ?></p>
            <h2><?php echo ucfirst($article['title']); ?></h2>
            <h2><?php echo ucfirst($article['auteur']); ?></h2>
            <p><?php echo nl2br($article['content']); ?></p>
            <p>Date: <?php echo dateSite($article['created_at']); ?></p>
            <p>Modifié le : <?php echo dateSite($article['modified_at']); ?></p>
            <a href="editposts.php?id=<?php echo $article['id']; ?>">Editer</a>
            <a href="deleteposts.php?id=<?php echo $article['id']; ?>">Supprimer</a>
        </li>
    <?php } ?>
</ul>
<?php include('inc/footer-back.php');
