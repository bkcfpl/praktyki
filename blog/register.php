<?php
    error_reporting(0);
    session_start();
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Rejestracja</title>
    </head>
    <body>
        <!--Tworzenie formularza-->
        <form action = "register.php" method = "post">
            <p>Wprowadź login: </p>
            <input type = "text" name = "login">

            <p>Wprowadź hasło: </p>
            <input type = "password" name = "password"><br/><br/>

            <button type = "submit" name = "accept">Zarejestruj</button>
            <button><a href="login.php" style = "color: black; text-decoration: none">Logowanie</a></button>
        </form>

        <?php
            $connect = mysqli_connect("localhost", "root", "", "formularz");
            $result = mysqli_query($connect, "SELECT * FROM `login`");

            //zmienna która sprawia że nie wyświetla się ciągle "złe hasło lub login"
            $wprowadzone = false;
            $i = 0;

            //jeśli przycisk został kliknięty i użytkownik wpisał coś do inputów
            if(isset($_POST["accept"]) && $_POST["login"] != "" && $_POST["password"] != "" && !$wprowadzone){
                while($row = mysqli_fetch_array($result)){
                    //Jeśli wprowadzony login jest taki sam jak login z tabelki
                    if($_POST["login"] != $row["login"]){
                        $i++;
                    }
                }

                if($i ==  mysqli_num_rows($result)){
                    mysqli_query($connect, "INSERT INTO `login` (`id`, `login`, `haslo`) VALUES (NULL, '" . $_POST['login'] . "', '" . $_POST['password'] . "');");
                    echo "Stworzono konto " . $_POST['login'];

                    $_SESSION['zalogowany'] = true;
                    $_SESSION['login'] = $_POST['login'];
                }
                else{
                    echo "Podany login już istnieje. Podaj inny login";
                }
            }
            //jeżeli przyscisk nie został kliknęty lub użytkownik nie wpisał czegoś do inputów
            else{
                echo "Proszę wprowadzić login i hasło";
                $_POST["login"] = "";
                $_POST["password"]  ="";
                $_SESSION['zalogowany'] = false;
            }

        ?>
    </body>
</html>