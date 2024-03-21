<?php
    $connect = mysqli_connect("localhost", "root", "", "sklep");

    session_start();
    error_reporting(0);
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Sklep ŚPŚD</title>

        <link href="https://fonts.googleapis.com/css2?family=Konkhmer+Sleokchher&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong" rel="stylesheet">

        <link rel="stylesheet" href="stylPay.css">
    </head>
    <body>
        <nav>
            <h2><a href="index.php" class = "index">Sklep ŚPŚD</a></h2>

            <h3 class = "login"><a href="login.php">zaloguj</a></h3>
            <h3 class = "cart"><a href="cart.php">koszyk</a></h3>
        </nav>

        <div>
            <form action="pay.php" method = 'post'>
                <h2>Wprowadź rodzaj płatności</h2>
                <?php
                    $r = mysqli_query($connect, "SELECT * FROM `płatność` WHERE `rodzaj` = 'płatność';");

                    while ($row = mysqli_fetch_array($r)){

                        if($row['dostępne'] == 0){
                            echo "<input disabled type = 'radio' name = 'pay' value = '" . $row['nazwa'] . "' id = '" . $row['nazwa'] . "'>";
                            echo "<label for = '" . $row['nazwa'] . "' class = 'niedostepne'>" . $row['nazwa'] . "</label>";
                        }
                        else{
                            echo "<input required type = 'radio' name = 'pay' value = '" . $row['nazwa'] . "' id = '" . $row['nazwa'] . "'>";
                            echo "<label for = '" . $row['nazwa'] . "'>" . $row['nazwa'] . "</label>";
                        }
                    }

                    echo "<h2>Wprowadź rodzaj wysyłki</h2>"; 
                    $r = mysqli_query($connect, "SELECT * FROM `płatność` WHERE `rodzaj` = 'wysyłka';");

                    while ($row = mysqli_fetch_array($r)){
                        if($row['dostępne'] == 0){
                            echo "<input disabled type = 'radio' name = 'send' value = '" . $row['nazwa'] . "' id = '" . $row['nazwa'] . "'>";
                            echo "<label for = '" . $row['nazwa'] . "' class = 'niedostepne'>" . $row['nazwa'] . "</label>";
                        }
                        else{
                            echo "<input required type = 'radio' name = 'send' value = '" . $row['nazwa'] . "' id = '" . $row['nazwa'] . "'>";
                            echo "<label for = '" . $row['nazwa'] . "'>" . $row['nazwa'] . "</label>";
                        }
                    }
                ?>

                <h2>Wprowadź adres dostawy</h2>   <!--ma się zmieniać w zależności od rodzaju wysyłki-->
                <input type="text" placeholder = 'email lub adres' name = 'email' required>
                <br/><br/>

                <button type = 'submit' name = 'submit'><h2>Zapłać</h2></button>
                <br/><br/>

                <?php
                    if($_SESSION['login'] != ""){
                        echo "<input type='checkbox' id = 'save_data'>";
                        echo "<label for='save_data'>Zapisać dane?</label>";
                    }
                    else{
                        echo "<h3>Czy chcesz się zalogować aby zapisać te dane? UWAGA: Wszystkie wpisane dane zostaną usunięte!</h3>";
                        echo "<button><a href='login.php' class = 'log_in'>zaloguj!</a></button>";
                    }
                ?>
            </form>

            <aside>
                <h3>W sumie trzeba zapłacić:</h3>
                <?php
                    echo "<p>" . $_SESSION['summary'] . "zł</p>";
                ?>
            </aside>

            <?php
                if(isset($_POST['submit'])){
                    for($i = 0; ; $i++){
                        if($_SESSION['koszyk']['produkt' . $i]['nazwa'] != null){
                            $produkty = $produkty . " nazwa: " . $_SESSION['koszyk']['produkt' . $i]['nazwa'] . ", ilość: " . $_SESSION['koszyk']['produkt' . $i]['ilosc'] . ",";
                        }
                        else{
                            break;
                        }
                    }

                    mysqli_query($connect, "INSERT INTO `historia` (`id`, `płatność`, `wysyłka`, `adres`, `produkty`) VALUES (NULL, '" . $_POST['pay'] . "', '" . $_POST['send'] . "', '" . $_POST['email'] . "', '$produkty');");
                }
            ?>
        </div>
    </body>
</html>