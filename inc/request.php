<?php


function getArticle($id)
{
    global $pdo;
    $sql = "SELECT * FROM beer WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch();
}


function getAllArticles($ORDER)
{
    global $pdo;
    $sql = "SELECT * FROM articles ORDER BY created_at $ORDER";
    $query = $pdo->prepare($sql);
    $query->execute();
    return $query->fetchAll();
}
