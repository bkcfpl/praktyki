<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
    </head>
    <body>
        <form action="fetch1.php" method = "post">
            <h3>Wprowadź rasę psa (po angielsku) aby wybrać rasę, lub kliknij przycisk aby wylosować rasę, i zobaczyć zdjęcie. (Lista ras znajduje się w konsoli)</h3>
            <i>Jeśli nie widzisz listy ras, kliknij przycisk 'Potwierdź', który wylosuje losowe zdjęcie. Wtedy pojawi się lista</i><br/><br/>

            <input type="text" name = "rase">
            <button type="submit">Potwierdź</button>
        </form>
        <br/>

        <img id="a" src="" alt="">

        <script>
            //wyświetlanie rasy w consoli
            fetch("https://dog.ceo/api/breeds/list/all")
                .then(res => res.json())
                .then(res => {
                    console.log(res.message);
                })

            let rase = '<?php echo $_POST['rase'];?>';

            //jeśli input jest pusty, wyświetla losowe zdjęcie
            if(rase == ""){
                fetch("https://dog.ceo/api/breeds/image/random")
                    .then(res => res.json())
                    .then(res => {
                        document.getElementById("a").src = res.message;
                    })
            }
            //jeśli input NIE jest pusty, wyświetla zdjęcie wpisanej rasy
            else{
                fetch("https://dog.ceo/api/breed/" + rase + "/images/random")
                    .then(res => res.json())
                    .then(res => {
                        document.getElementById("a").src = res.message;
                        document.getElementById("a").alt = 'Nie znaleziono rasy ' + rase; //To się wyświetli tylko jeśli nie ma podanej rasy
                    })
            }

        </script>
    </body>
</html>

