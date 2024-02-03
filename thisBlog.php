<?php

/*******w******** 
    
    Name:           Rimando Urbano 
    Date:           2024-02-02
    Description:    Read full post of the blog.

****************/
require('connect.php');
if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM blog WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $id, PDO::PARAM_INT);

    $statement->execute();
    $thisBlog = $statement->fetch();
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
            Your Blog - <?= $thisBlog['title'] ?>
        <?php endif;?>
    </title>
</head>
<body>
    <?php include('header.php');?>
    <main>
        <?php if($id): ?>
            <div class="content">
                <div>
                    <h3><?= $thisBlog["title"] ?></h3>
                    <a id="edit" href="edit.php?id=<?= $thisBlog["id"]?>">edit</a>
                </div>
                <p><?= date("F d, Y, h:i a",strtotime( $thisBlog["date_posted"] ));?></p>
                <p><?= $thisBlog['content'] ?></p>
            </div>
        <?php endif;?>
    </main>
</body>
</html>