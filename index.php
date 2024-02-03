<?php

/*******w******** 
    
    Name:           
    Date:           
    Description:    

****************/

require('connect.php');

$query = "SELECT * FROM blog ORDER BY date_posted DESC LIMIT 5";

$statement = $db->prepare($query);

$statement->execute();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Your Blog - Home Page</title>
</head>
<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <?php include('header.php'); ?>
    <?php include('nav.php'); ?>
    <main class="container">
        <h2>Recently Posted Blog Entries</h2>

        <?php if($statement->rowCount() == 0): ?>
            <div>
                <p>No entries yet.</p>
            </div>
        <?php exit; endif; ?>

        <?php while($row = $statement->fetch()): ?>
            <div class="content">
                <div>
                    <h3><a href="thisBlog.php?id=<?= $row["id"]?>"><?= $row["title"] ?></a></h3>
                    <a id='edit' href="edit.php?id=<?= $row["id"]?>">edit</a>
                </div>
                <span id='date'><?= date("F d, Y, h:i a",strtotime( $row["date_posted"] ));?></span>
                <?php if(strlen($row["content"]) > 200): ?>
                    <p><?= substr($row['content'], 0, 200) . " " ?><a href="thisBlog.php?id=<?= $row["id"]?>">Read Full Post...</a></p>
                <?php else: ?>
                    <p><?= $row["content"] ?></p>
                <?php endif ?>
            </div>
        <?php endwhile ?>
    </main>
</body>
</html>