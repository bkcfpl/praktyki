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
                $result = mysqli_query($connect, "SELECT * FROM `uzytkownicy`");

                echo "<form action = 'edytowanie.php' method = 'post'>";
                    echo "<table>";
                        while($row = mysqli_fetch_array($result)){
                            echo "<tr>";
                                echo "<td>" . $row['imie'] . "<td/>";
                                echo "<td>" . $row['nazwisko'] . "<td/>";
                                echo "<td>" . $row['email'] . "<td/>";
                                echo "<td>" . $row['numer telefonu'] . "<td/>";

                                $rowID = $row['id'];
                                echo "<button type = 'submit' name = 'edytuj$rowID'>edytuj</button>";
                            echo "</tr>";

                            if(isset($_POST['edytuj' . $rowID])){
                                echo "Po wprowadzeniu danych wybierz który wpis ma zostać zedytowany <br/><br/>";
                                echo "<form action = 'edytowanie.php' method = 'post'>";
                                    echo "<label for = \"imie\">Edytuj imię: </label><input type = \"text\" name = \"imie\" value =". $row['imie'] . "><br/><br/>";
                                    echo "<label for = \"nazwisko\">Wprowadź nazwisko: </label><input type = \"text\" name = \"nazwisko\" value = ". $row['nazwisko'] . "><br/><br/>";
                                    echo "<label for = \"email\">Wprowadź email: </label><input type = \"email\" name = \"email\" value = ". $row['email'] . "><br/><br/>";
                                    echo "<label for = \"telefon\">Wprowadź numer telefonu: </label><input type = \"number\" name = \"telefon\" value = ". $row['numer telefonu'] . "><br/><br/>";
                                echo "</form>";

                                $imie = $_POST["imie"];
                                $nazwisko = $_POST["nazwisko"];
                                $email = addslashes($_POST["email"]);
                                $nrTelefonu = $_POST["telefon"];

                                if($imie != "" && $nazwisko != "" && $email != "" && $nrTelefonu != ""){
                                    mysqli_query($connect, "UPDATE `uzytkownicy` SET `imie` = '$imie', `nazwisko` = '$nazwisko', `email` = '$email', `numer telefonu` = '$nrTelefonu' WHERE `uzytkownicy`.`id` = $rowID;");
                                    header("Refresh:0");
                                }
                                else{
                                    print("Błąd: Wprowadzone wartości są puste. Proszę wprowadzić wartości <br/>");
                                }
                            }
                        }
                    echo "</table>";
                echo "</form>";

                    
                echo "Zalogowano na konto użytkownika " . $_SESSION["login"] . "<br/>";
                echo "<button><a href='wpisy.php' style = 'color: black; text-decoration: none'>Usuwanie wpisów</a></button>";
                echo "<button><a href='form.php' style = 'color: black; text-decoration: none'>Wprowadź nowy wpis</a></button>";
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