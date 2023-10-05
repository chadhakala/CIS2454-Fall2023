<?php
//database server type, location, database name 


$data_source_name = 'mysql:host=localhost;dbname=stonks';
//  feels bad, but don't have time to show a better way.

$stonk_user = null;
$username = 'stockuser';
$password = 'test'; 

try {

    $database = new PDO($data_source_name, $username, $password);
    echo "<p class='dbChk'>Database connection successful!</p>";
    
    $action = htmlspecialchars(filter_input(INPUT_POST, "action"));
        
    $symbol = htmlspecialchars(filter_input(INPUT_POST, "symbol"));
    $name = htmlspecialchars(filter_input(INPUT_POST, "name"));
    $current_price = filter_input(INPUT_POST, "current_price", FILTER_VALIDATE_FLOAT);
    $user_id = filter_input(INPUT_POST, "user_id", FILTER_VALIDATE_INT);                                                                                    //@@@@@@ FLASH CARD SECTION @@@@@
                                                                                  
     if ( $action == "insert" && $symbol != "" && $name != "" && $current_price != 0){
                                                                                             // DANGER DANGER DANGER
                                                                                             //Don't ever just plug values into a query!!!
                                                                                                //This is how SQL Injection happens!
                                                                                    //  $query = "INSERT INTO stocks (symbol, name, current_price) "
                                                                                    //         . "VALUES ($symbol, $name, $current_price)";
                                                                      // instead, use substitutions
         
         
    $query = "insert INTO stocks (symbol, name, current_price)  "   // <---}
                . " VALUES (:symbol, :name, :current_price)";
    
    // value binding in PDO protections against sql injection
    $statement = $database->prepare($query);
     
        $statement->bindValue(":symbol", $symbol);
        $statement->bindValue(":name", $name);
        $statement->bindValue(":current_price", $current_price);
    
        if ($action == "new_user" && $user_id.isValid($id) && $email_address != ""){  //That's the brakes
            $query = "insert into users (INSERT INTO users (name, email_address, cash_balance, id) "
                    . "  VALUES (:name, email_address, :cash_balance);)"
        
        
    if($action == "buy" && is_valid($user_id) && $symbol != ""){ 
    
        $query = "insert INTO transaction (user_id, symbol, current_price, quantity)  "
              .  " VALUE  :user_id, :symbol, :current_price, :quantity";
        
        $total_pur = ($quantity * $current_price);
        
        }
        $statement->bindValue(":user_id", $user_id);
        $statement->bindValue(":symbol", $symbol);
        $statement->bindValue($total_pur(":current_price"), $total_pur);
        $statement->bindValue(":quantity", $quantity);
        
                                                                                  
                }
        $statement->execute();
           
        $statement->closeCursor();
    }else if ($action == "update" && $symbol != "" && $name != "" && $current_price != 0) {
         $query = "update stocks set name = :name, current_price = :current_price   "
                 . "  where symbol = :symbol";
     
    // value binding in PDO protections against sql injection
        $statement = $database->prepare($query);
        $statement->bindValue(":symbol", $symbol);
        $statement->bindValue(":name", $name);
        $statement->bindValue(":current_price", $current_price);
                                                                                  
        $statement->execute();
           
        $statement->closeCursor();
              
        
     }else if ($action == "delete" && $symbol != "" ) {
         $query = "delete from stocks  "
                 . "  where symbol = :symbol";
     
    // value binding in PDO protections against sql injection
        $statement = $database->prepare($query);
        $statement->bindValue(":symbol", $symbol);

        
        $statement->execute();
           
        $statement->closeCursor();
              
     }
     else if ($action != "" ) {
        echo "<p class='dbErr'>Missing Symbol, Name, or Current Price</p>";
    }
                                                                                    //@@@@@@ FLASH CARD SECTION @@@@@
    
    $query = 'SELECT symbol, name, current_price, id FROM stocks';

    //prepare the query please
    $statement = $database->prepare($query);

    //run the query please
    $statement->execute();
    // this might be risky if you have HUGE amounts of data
    $stocks = $statement->fetchAll();

    $statement->closeCursor();
    
   
   
} catch (Exception $e) {
    $error_message = $e->getMessage();
    echo "<p>Error message: $error_message </p>";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles/styles.css"/>
        <title>To The MOON! 🌚</title>
       
    </head>
    <body>

        <table class='stock-default'>
            <tr>
                <th>Name</th>
                <th>Symbol</th>
                <th>Current Price</th>
                <th>ID</th>
            </tr>

<?php foreach($stocks as $stonks) : ?>
                <tr>
                    <td><?php echo $stonks['symbol']; ?></td>
                    <td><?php echo $stonks['name']; ?></td>
                    <td><?php echo $stonks['current_price']; ?></td>
                    <td><?php echo $stonks['id']; ?></td>
                </tr>
                    <?php endforeach;  ?>
        </table>
        <br>
        <h2>Add Stock</h2>
        <form action="index.php" method="post">
            <label>Symbol:</label>
            <input type="text" name="symbol"/><br>
            <label>Name:</label>
            <input type="text" name="name"/><br>
            <label>Current Price:</label>
            <input type="text" name="current_price"/><br>
            <input type="hidden" name='action' value='insert'/>  <!--???? Whats this though? @@@@@ -->
            <label>&nbsp;</label>
            <input type="submit" value="Add Stock"/><br>
        </form>
        <br>
        <h2>Update Stock</h2>
        <form action="index.php" method="post">
            <label>Symbol:</label>
            <input type="text" name="symbol"/><br>
            <label>Name:</label>
            <input type="text" name="name"/><br>
            <label>Current Price:</label>
            <input type="text" name="current_price"/><br>
            <input type="hidden" name='action' value='update'/>
            <label>&nbsp;</label>
            <input type="submit" value="Update Stock"/><br>
        </form>
        <br>
        <h2>Delete Stock</h2>
        <form action="index.php" method="post">
            <label>Symbol:</label>
            <input type="text" name="symbol"/><br>
            <input type="hidden" name='action' value='delete'/>
            <label>&nbsp;</label>
            <input type="submit" value="Delete Stock"/><br>
        </form>
        
         <h2>Buy Stock</h2>
        <form action="index.php" method="post">
            <label>user id:</label>
            <input type="text" name="user_id"/><br>
             <label>Symbol:</label>
            <input type="text" name="symbol"/><br>
            <label>Quantity:</label>
            <input type="text" name="quantity"/><br>
            <input type="hidden" name='action' value='buy'/>
            <label>&nbsp;</label>
            <input type="submit" value="Buy Stock"/><br>
        </form>
         <h2>Add User</h2>
         <form action="index.php" method="post">
             <label>User id:</label>
             <input type="text" name="user_id"/><br>
             <label>Symbol:</label>
             <input type="text" name="symbol"/><br>
             <label>email address</label>
             <input type="text" name="email_address"/>
             <label>name:</label> 
             <input type="text" name="name"/><br>
             <input type="hidden" name='action' velue='add_user'/>
             <label>&nbsp;</label>
             <input type="submit" value="Add User"><br>
         </form>
        
    </body>
</html>
