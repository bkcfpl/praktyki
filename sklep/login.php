<?php
    //łączenie z bazą danych sklep
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
                //łączenie z tabelką użytkownicy, i szuka gdzie login = "admin"
                $r = mysqli_query($connect, "SELECT * FROM `uzytkownicy` WHERE `login` = 'admin'");
                $row = mysqli_fetch_array($r);

                //jeśli użytkownik jest już zalogowany
                if(!empty($_SESSION['login'])){
                    echo "Witaj <b>" . $_SESSION['login'] . "</b>. Jesteś już zalogowany <br/>";
                    echo "<button type = 'submit' name = 'logout'>Wyloguj</button>";
                }
                //jeśli wpisane dane są takie same jak login i hasło admina
                else if($_POST['login'] == $row['login'] && $_POST['password'] == $row['haslo']){
                    echo "Zalogowano na konto administratorskie.<br/>";
                    echo "<button><a href = 'admin.php'>administruj</button>";
                }
                //jeśli przycisk został kliknięty
                else if(isset($_POST['accept'])){

                    //łączenie z tabelką użytkownicy
                    $r = mysqli_query($connect, "SELECT * FROM `uzytkownicy`");

                    //dla każdego użytkownika, sprawdza czy wpisane dane są równe loginowi i haśle jakiegokolwiek użytkownika
                    while($row = mysqli_fetch_array($r)){
                        //jeśli wprowadzone dane są równe loginowi i haśle jednego z użytkowników
                        if($_POST['login'] == $row['login'] && $_POST['password'] == $row['haslo']){
                            echo "Zalogowano! Witaj <b>" . $row['login'];
                            echo "</b><br/><button type = 'submit' name = 'logout'>Wyloguj</button>";
                            $_SESSION['login'] = $row['login'];
                            break;
                        }

                        //jeśli $row['id'] będzie = ostatniemu id, czyli jeśli przeszukano całą tabelkę
                        if($row['id'] == mysqli_num_rows($r)){
                            echo "Zły login lub hasło. Spróbuj ponownie";
                        }
                    }
                }
                else{
                    echo "Wprowadź login i hasło";
                }

                //jeśli użytkownik chce się wylogować
                if(isset($_POST['logout'])){
                    session_destroy();
                    header("Refresh: 0");
                }
            ?>
        </form>
    </body>
</html>