<?php
    //połączenie się z bazą danych sklep i tabelką produkty
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

        <?php
            echo "<table>";
                echo "<tr class = 'headers'>";
                    echo "<th>nazwa</th>";
                    echo "<th>ilość</th>";
                    echo "<th>cena</th>";
                echo "</tr>";

                //nie wiem czy zmęczony byłem, ale można to było lepiej zrobić. Nie poprawiam, bo wiem że działą, a może nawet z czegoś takiego można się nauczyć
                $loop = true;
                $i = 0;
                $summary = 0;

                //pętla będzie się powtarzać, dopóki nazwa produktu nie będzie istnieć. czyli 1-"dlc" 2-"dlc" 3-null koniec pętli
                while($loop){
                    if($_SESSION['koszyk']['produkt' . $i]['nazwa'] != null){
                        //ustawa że co drugi wiersz ma inny kolor
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

                        $summary += $_SESSION['koszyk']['produkt' . $i]['cena'];
                        $i++;
                    }
                    else{
                        $loop = false;
                    }
                }
                $_SESSION['summary'] = $summary;
            echo "</table>";

            //jeśli koszyk jest pusty
            if(empty($_SESSION['koszyk']['produkt0']['nazwa'])){
                echo "Twój koszyk jest pusty";
            }
            //jeśli w koszyku jest chociaż jeden przedmiot
            else{
                echo "<button><a href = 'pay.php' class = 'pay'>Przejdź do płatności</a></button>";
            }
        ?>
    </body>
</html>