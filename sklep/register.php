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

        <h1>REJESTRACJA</h1>
        <form action = 'register.php' method = 'post'>
            <p>Wprowadź login: </p>
            <input type = 'text' name = 'login'>

            <p>Wprowadź hasło: </p>
            <input type = 'password' name = 'password'><br/><br/>

            <button type = 'submit' name = 'accept'>Zarejestruj</button>
            <button><a href='login.php'>Zaloguj</a></button>
            <br/>

            <?php
                if(!empty($_SESSION['login'])){
                    echo "Witaj <b>" . $_SESSION['login'] . "</b>. Jesteś już zalogowany <br/>";
                    echo "<button type = 'submit' name = 'logout'>Wyloguj</button>";
                }
                else if(isset($_POST['accept'])){
                    while($row = mysqli_fetch_array($r)){
                        if($_POST['login'] == $row['login']){
                            echo "Taki login już istnieje. Proszę spróbować ponownie";
                            break;
                        }
    
                        if($row['id'] == mysqli_num_rows($r)){
                            mysqli_query($connect, "INSERT INTO `uzytkownicy` (`id`, `login`, `haslo`) VALUES (NULL, '" . $_POST['login'] . "', '" . $_POST['password'] . "');");
                            echo "Stworzono nowe konto!";
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