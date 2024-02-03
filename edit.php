<?php

/*******w******** 
    
    Name:           Rimando Urbano
    Date:           2024-02-02
    Description:    Update and delete blog.

****************/

require('connect.php');
require('authenticate.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // update
    if (isset($_POST['action']) && $_POST['action'] === 'update' && !empty($_POST['title']) && !empty($_POST['content'])) {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST,'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        $query = "UPDATE blog SET title = :title , content = :content WHERE id = :id";
    
        $statement = $db->prepare($query);

        $statement->bindValue(":title", $title);
        $statement->bindValue(":content", $content);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);

        $statement->execute();

        header("Location: index.php?=$id");
        exit;
    // delete
    } else if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        $query = 'DELETE FROM blog WHERE id = :id';

        $statement = $db->prepare($query);

        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        $statement->execute();

        header("Location: index.php?($id)");
        exit;
    }

    

} else if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM blog WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $id, PDO::PARAM_INT);

    $statement->execute();
    $thisBlog = $statement->fetch();
} else {
    $id = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>
        <?php if($id) :?>
            Your Blog - Editing <?= htmlspecialchars($thisBlog['title']) ?>
        <?php endif ?>
    </title>
</head>
<body>
    <?php include('header.php'); ?>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <main id="updatePost">
        <?php if($id) :?>
            <form method="post">
                <div>
                    <input type="hidden" name="id" value="<?= $thisBlog['id'] ?>">
                    <label for="title">Title</label>
                    <input type="text" value="<?=$thisBlog['title'] ?>" name="title" id="title" minlength="1" required>
                </div>
                <div>
                    <label for="content">Content</label>
                    <textarea name="content" id="content" cols="50" rows="10" minlength="1" required><?=$thisBlog['content'] ?></textarea>
                </div>
                <div>
                    <input type="hidden" name="action" value="update"> 
                    <button type="submit" name="submit" id="update">Update Blog</button>
                </div>
            </form>
            <form method="post">
                <div>
                    <input type="hidden" name="id" value="<?= $thisBlog['id'] ?>">
                    <input type="hidden" name="action" value="delete"> 
                    <button type="submit" name="submit" id="delete">Delete Blog</button>
                </div>
            </form>
        <?php endif ?>
    </main>
</body>
</html>