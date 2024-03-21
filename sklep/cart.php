<?php
    $connect = mysqli_connect("localhost", "root", "", "sklep");
    $r = mysqli_query($connect, "SELECT * FROM `produkty`");

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

        <link rel="stylesheet" href="stylCart.css">
    </head>
    <body>
        <nav>
            <h2><a href="index.php">Sklep ŚPŚD</a></h2>

            <h3 class = "login"><a href="login.php">zaloguj</a></h3>
            <h3 class = "cart">koszyk</h3>
        </nav>

<!-- Jak będą dwa takie same przedmioty, to żeby się dodały -->
        <?php
            echo "<table>";

                echo "<tr class = 'headers'>";
                    echo "<th>nazwa</th>";
                    echo "<th>ilość</th>";
                    echo "<th>cena</th>";
                echo "</tr>";

                $loop = true;
                $i = 0;
                $summary = 0;
                while($loop){
                    if($_SESSION['koszyk']['produkt' . $i]['nazwa'] != null){
                        if($i % 2 == 0){
                            echo "<tr>";
                        }
                        else{
                            echo "<tr class = 'second'>";
                        }
                            echo "<td>" . $_SESSION['koszyk']['produkt' . $i]['nazwa'] . "</td>";
                            echo "<td>" . $_SESSION['koszyk']['produkt' . $i]['ilosc'] . "</td>";
                            echo "<td>" . number_format($_SESSION['koszyk']['produkt' . $i]['cena'], 2) . "zł</td>";
                        echo "</tr>";

                        $summary += floatval($_SESSION['koszyk']['produkt' . $i]['cena']);
                        $i++;
                    }
                    else{
                        $loop = false;
                    }
                }
                $_SESSION['summary'] = $summary;
            echo "</table>";

            if(empty($_SESSION['koszyk']['produkt0']['nazwa'])){
                echo "Twój koszyk jest pusty";
            }
            else{
                echo "<button><a href = 'pay.php' class = 'pay'>Przejdź do płatności</a></button>";
            }
        ?>
    </body>
</html>