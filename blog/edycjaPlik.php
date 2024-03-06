<?php
    error_reporting(0);
    session_start();
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>edycja</title>
    </head>
    <body>
        <?php
            if($_SESSION['zalogowany']){
                $connect = mysqli_connect("localhost", "root", "", "formularz");
                $result = mysqli_query($connect, "SELECT * FROM `uzytkownicy` WHERE id = " . $_GET['id']);
                $row = mysqli_fetch_assoc($result);
                $rowID = $_GET['id'];
                echo "<form action = 'edycjaPlik.php?id=$rowID' method = 'post'>";
                    echo "<label for = \"tytul\">Edytuj tytuł: </label><input type = \"text\" name = \"tytul\" value = '". $row['tytuł'] . "'><br/><br/>";
                    echo "<label for = \"wpis\">Edytuj wpis: </label><input type = \"text\" name = \"wpis\" value = '". $row['wpis'] . "'><br/><br/>";
                    echo "<input type='hidden' name='id_wpisu' value='{$rowID}'/>";
                    echo "<button type = 'submit' name = 'edytuj'>edytuj</button>";
                echo "</form>";

                    
                echo "Zalogowano na konto użytkownika " . $_SESSION["login"] . "<br/>";
                echo "<button><a href='nowyWpis.php' style = 'color: black; text-decoration: none'>Wprowadź nowy wpis</a></button>";
                echo "<button><a href='wpisy.php' style = 'color: black; text-decoration: none'>Zobacz wszystkie wpisy</a></button>";
                echo "<form action = 'login.php' method = 'post'>";
                    echo "<button type = 'submit' name = 'logout'>Wyloguj</button>";
                echo "</form>";
            }
            else{
                echo "Nie jesteś zalogowany. Proszę się zalogować lub zarejestrować. <br/>";
                echo "<button><a href='login.php' style = 'color: black; text-decoration: none'>Zaloguj</a></button>";
                echo "<button><a href='register.php' style = 'color: black; text-decoration: none'>Zarejestruj</a></button>";
            }
        ?>
    </body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id_wpisu'];
    $tytul = $_POST["tytul"];
    $wpis = $_POST["wpis"];
    
    if(!empty($tytul) && !empty($wpis) && !empty($id)){
        mysqli_query($connect, "UPDATE `uzytkownicy` SET `tytuł` = '$tytul', `wpis` = '$wpis' WHERE `uzytkownicy`.`id` = $id;");
        // header("Refresh:0");
    }
    else{
        print("Błąd: Wprowadzone wartości są puste. Proszę wprowadzić wartości <br/>");
    }
}


?>