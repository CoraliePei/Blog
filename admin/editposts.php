<?php
require('../inc/request.php');
require('../inc/fonction.php');
require('inc/validForm.php');
require('../inc/pdo.php');

?>
<?php
if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql_edit_user = "SELECT * FROM articles WHERE id = :id";
    $query = $pdo->prepare($sql_edit_user);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $article = $query->fetch();
    if (empty($article)) {
        die();
    }
    // debug($article);

    $errors = [];
    if (!empty($_POST['submitted'])) {

        $title = cleanXss('title');
        $auteur = cleanXss('auteur');
        $content = cleanXss('content');
        $content = cleanXss('status');


        $errors = validText($errors, $title, 'title', 2, 100);
        $errors = validText($errors, $auteur, 'auteur', 2, 50);
        $errors = validText($errors, $content, 'content', 10, 2000);
        $errors = validText($errors, $status, 'status', 3, 10);

        if (count($errors) === 0) {
            $requete_update = "UPDATE articles SET title= :title, auteur= :auteur, content = :content, status = :status, modified_at = NOW() WHERE id= :id";
            $query = $pdo->prepare($requete_update);
            $query->bindValue(':title', $title, PDO::PARAM_STR);
            $query->bindValue(':auteur', $auteur, PDO::PARAM_STR);
            $query->bindValue(':content', $content, PDO::PARAM_STR);
            $query->bindValue(':status', $status, PDO::PARAM_STR);
            $query->bindValue(':id', $id, PDO::PARAM_INT);

            $query->execute();
            header('Location: listposts.php');
        }
    }
} else {
    die();
}

include('inc/header-back.php'); ?>

<h1>Editer un article</h1>

<form action="" method="post" novalidate class="wrap2">
    <label for="title">Titre</label>
    <input type="text" name="title" id="title" value="<?php if (!empty($_POST['title'])) {
                                                            echo $_POST['title'];
                                                        } elseif (!empty($article['title'])) {
                                                            echo $article['title'];
                                                        } ?>">
    <span class="error"><?php if (!empty($errors['title'])) {
                            echo $errors['title'];
                        } ?></span>

    <label for="content">Contenu</label>
    <textarea name="content" id="content" cols="30" rows="10"><?php if (!empty($_POST['content'])) {
                                                                    echo $_POST['content'];
                                                                } elseif (!empty($article['content'])) {
                                                                    echo $article['content'];
                                                                } ?></textarea>
    <span class="error"><?php if (!empty($errors['content'])) {
                            echo $errors['content'];
                        } ?></span>

    <label for="auteur">Auteur</label>
    <input type="text" name="auteur" id="auteur" value="<?php if (!empty($_POST['auteur'])) {
                                                            echo $_POST['auteur'];
                                                        } elseif (!empty($article['auteur'])) {
                                                            echo $article['auteur'];
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
            } elseif ($article['status'] == $key) {
                $selected = ' selected="selected"';
            }
        ?>
            <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
        <?php } ?>
    </select>
    <span class="error"><?php if (!empty($errors['status'])) {
                            echo $errors['status'];
                        } ?></span>
    <input type="submit" name="submitted" value="Editer">
</form>

<?php include('inc/footer-back.php');
