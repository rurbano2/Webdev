<?php

/*******w******** 
    
    Name:           Rimando Urbano
    Date:           2024-02-02
    Description:    Insert records into the blog.

****************/
    require('authenticate.php');
    require('connect.php');

    if($_POST && !empty($_POST['title']) && !empty($_POST['content'])) {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST,'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $query = "INSERT INTO blog (title, content) VALUES (:title, :content)";
        $statement = $db->prepare($query);

        $statement->bindValue("title", $title);
        $statement->bindValue("content", $content);

        $statement->execute();

        header("Location: index.php?($id)");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Your Blog - Post a New Blog</title>
</head>
<body>
    <?php include("header.php"); ?>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <main id="updatePost">
        <form method="POST" action="post.php">
            <div>
                <label for="title"><h3>Title</h3></label>
                <input type="text" name="title" id="title" minlength="1" required>
            </div>
            <div>
                <label for="content"><h3>Content</h3></label>
                <textarea name="content" id="content" cols="50" rows="10" minlength="1" required></textarea>
            </div>
            <div>
                <button type="submit" name="submit" id="submit">New Blog</button>
            </div>
        </form>
    </main>
</body>
</html>