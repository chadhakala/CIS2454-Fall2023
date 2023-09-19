<?php
    $first_name = $_GET['first_name'];
    $last_name = $_GET['last_name'];
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="index.php" method="get">
            <label>First Name: </label>
            <input type="text" name="first_name"/><br>
            <label>Last name: </label>
            <input type="text" name="last_name"/><br>
            <label>&nbsp;</label>
            <input type="submit" value="Submit"/>
            </form>
            <?php
            echo "Hi " . $first_name . $last_name;
            ?>
        <script type="text/javascript"> alert ("This is an alert dialog box"); </script>
    </body>
</html>

