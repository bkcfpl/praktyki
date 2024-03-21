<?php
    $connect = mysqli_connect("localhost", "root", "", "sklep");
    $r = mysqli_query($connect, "SELECT * FROM `uzytkownicy`");

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

        <link rel="stylesheet" href="stylLogin.css">
    </head>
    <body>
        <nav>
            <h2><a href="index.php">Sklep ŚPŚD</a></h2>

            <h3 class = "login">zaloguj</h3>
            <h3 class = "cart"><a href="cart.php">koszyk</a></h3>
        </nav>

        <h1>LOGOWANIE</h1>
        <form action = 'login.php' method = 'post'>
            <p>Wprowadź login: </p>
            <input type = 'text' name = 'login'>

            <p>Wprowadź hasło: </p>
            <input type = 'password' name = 'password'><br/><br/>

            <button type = 'submit' name = 'accept'>Zaloguj</button>
            <button><a href='register.php'>Rejestracja</a></button>
            <br/>

            <?php
                if(!empty($_SESSION['login'])){
                    echo "Witaj <b>" . $_SESSION['login'] . "</b>. Jesteś już zalogowany <br/>";
                    echo "<button type = 'submit' name = 'logout'>Wyloguj</button>";
                }
                else if(isset($_POST['accept'])){
                    while($row = mysqli_fetch_array($r)){
                        if($_POST['login'] == $row['login'] && $_POST['password'] == $row['haslo']){
                            echo "Zalogowano! Witaj <b>" . $row['login'];
                            echo "</b><br/><button type = 'submit' name = 'logout'>Wyloguj</button>";
                            $_SESSION['login'] = $row['login'];
                            break;
                        }
    
                        if($row['id'] == mysqli_num_rows($r)){
                            echo "Zły login lub hasło. Spróbuj ponownie";
                        }
                    }
                }
                else{
                    echo "Wprowadź login i hasło";
                }

                if(isset($_POST['logout'])){
                    session_destroy();
                    header("Refresh: 0");
                }
            ?>
        </form>
    </body>
</html>