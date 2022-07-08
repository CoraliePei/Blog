<?php

require('../inc/pdo.php');
require('../inc/fonction.php');
require('../inc/request.php');
require('inc/validForm.php');

// traitement Formulaire
$success = false;
$errors = array();
if (!empty($_POST['submitted'])) {
    // Faille XSS
    $title = trim(strip_tags($_POST['title']));
    $content = trim(strip_tags($_POST['content']));
    $auteur = trim(strip_tags($_POST['auteur']));
    $status = trim(strip_tags($_POST['status']));
    // Validation
    $errors = validText($errors, $title, 'title', 3, 100);
    $errors = validText($errors, $content, 'content', 10, 1000);
    $errors = validText($errors, $auteur, 'auteur', 2, 50);
    $errors = validText($errors, $status, 'status', 3, 10);

    if (count($errors) === 0) {
        $sql = "INSERT INTO articles (title,content,auteur,created_at,modified_at,status) VALUES (:title,:content,:auteur,NOW(),NOW(),:status)";
        $query = $pdo->prepare($sql);
        $query->bindValue(':title', $title, PDO::PARAM_STR);
        $query->bindValue(':content', $content, PDO::PARAM_STR);
        $query->bindValue(':auteur', $auteur, PDO::PARAM_STR);
        $query->bindValue(':status', $status, PDO::PARAM_STR);
        $query->execute();
        header('Location: listposts.php');
        $success = true;
    }
}

include('inc/header-back.php'); ?>

<h1>Ajouter un article</h1>
<form action="" method="post" novalidate class="wrap2">
    <label for="title">Titre</label>
    <input type="text" name="title" id="title" value="<?php if (!empty($_POST['title'])) {
                                                            echo $_POST['title'];
                                                        } ?>">
    <span class="error"><?php if (!empty($errors['title'])) {
                            echo $errors['title'];
                        } ?></span>

    <label for="content">Contenu</label>
    <textarea name="content" id="content" cols="30" rows="10"><?php if (!empty($_POST['content'])) {
                                                                    echo $_POST['content'];
                                                                } ?></textarea>
    <span class="error"><?php if (!empty($errors['content'])) {
                            echo $errors['content'];
                        } ?></span>

    <label for="auteur">Auteur</label>
    <input type="text" name="auteur" id="auteur" value="<?php if (!empty($_POST['auteur'])) {
                                                            echo $_POST['auteur'];
                                                        } ?>">
    <span class="error"><?php if (!empty($errors['auteur'])) {
                            echo $errors['auteur'];
                        } ?></span>

    <?php
    $status = array(
        'draft' => 'brouillon',
        'publish' => 'Publié'
    );

    ?>
    <select name="status">
        <option value="">---------------------</option>
        <?php foreach ($status as $key => $value) {
            $selected = '';
            if (!empty($_POST['status'])) {
                if ($_POST['status'] == $key) {
                    $selected = ' selected="selected"';
                }
            }
        ?>
            <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
        <?php } ?>
    </select>
    <span class="error"><?php if (!empty($errors['status'])) {
                            echo $errors['status'];
                        } ?></span>

    <input type="submit" name="submitted" value="Ajouter un New Post !">
</form>

<?php include('inc/footer-back.php');
