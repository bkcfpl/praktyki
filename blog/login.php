<?php
    error_reporting(0);
    session_start();
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>logowanie</title>
    </head>
    <body>
        <?php
            $connect = mysqli_connect("localhost", "root", "", "formularz");
            $result = mysqli_query($connect, "SELECT * FROM `login`");

            $i = 0;

            if($_SESSION['zalogowany']){
                echo "Zalogowano na konto użytkownika " . $_SESSION["login"] . "<br/>";
                echo "<button><a href='nowyWpis.php' style = 'color: black; text-decoration: none'>Wprowadź nowy wpis</a></button>";
                echo "<button><a href='edycja.php' style = 'color: black; text-decoration: none'>Edytuj lub usuń wpis</a></button>";
                echo "<button><a href='wpisy.php' style = 'color: black; text-decoration: none'>Zobacz wszystkie wpisy</a></button>";
                echo "<form action = 'login.php' method = 'post'>";
                    echo "<button type = 'submit' name = 'logout'>Wyloguj</button>";
                echo "</form>";
            }
            else{
                echo "<form action = 'login.php' method = 'post'>";
                    echo "<p>Wprowadź login: </p>";
                    echo "<input type = 'text' name = 'login'>";

                    echo "<p>Wprowadź hasło: </p>";
                    echo "<input type = 'password' name = 'password'><br/><br/>";

                    echo "<button type = 'submit' name = 'accept'>Zaloguj</button>";
                    echo "<button><a href='register.php' style = 'color: black; text-decoration: none'>Rejestracja</a></button>";
                echo "</form>";
            }

            //jeśli przycisk został kliknięty i użytkownik wpisał coś do inputów
            if(isset($_POST["accept"]) && $_POST["login"] != "" && $_POST["password"] != ""){
                while($row = mysqli_fetch_array($result)){
                    //Jeśli wprowadzone wartości są takie same jak wartości tabelki
                    if(($_POST["login"] == $row["login"] && $_POST["password"] == $row["haslo"]) || $_SESSION['zalogowany']){
                        $i++;
                    }
                }

                if($i ==  mysqli_num_rows($result) || $i == 1){
                    $_SESSION["zalogowany"] = true;
                    $_SESSION["login"] = $_POST['login'];
                    $i = 0;

                    header("Refresh:0");
                }
                else{
                    echo "Złe hasło lub login. Spróbuj pownownie";
                }
            }
            //jeżeli przyscisk nie został kliknęty lub użytkownik nie wpisał czegoś do inputów
            else if (!$_SESSION['zalogowany']){
                echo "Proszę wprowadzić login i hasło";
                $_POST["login"] = "";
                $_POST["password"]  ="";
            }

            if(isset($_POST['logout'])){
                session_destroy();
                header("Refresh:0");
            }

        ?>
    </body>
</html>