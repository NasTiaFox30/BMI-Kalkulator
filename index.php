<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator BMI</title>
    <link rel="stylesheet" href="style.css">
    
</head>

<body>
    <header><h2>Obliczanie BMI</h2></header>
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <p>Wybierz płeć:</p>
        <div>
            <input type="radio" name="płeć" id="kobieta" value="kobieta" >
            <label for="kobieta">Kobieta</label>
            <input type="radio" name="płeć" id="mężczyzna" value="mężczyzna" >
            <label for="mężczyzna">Mężczyzna</label>
        </div>
        

        <label for="wiek">Wiek:</label>
        <input type="number" id="wiek" name="wiek" min="1" max="150" placeholder="wpisz wiek.." require>

        <label for="waga">Waga:</label>
        <input type="number" id="waga" name="waga" step="0.01" min="1" placeholder="wpisz wagę (kg).." require>

        <label for="wzrost">Wzrost:</label>
        <input type="number" id="wzrost" name="wzrost" step="0.01" min="1" placeholder="wpisz wzrost (cm).." require>


        <input type="submit" name="calculate" value="Oblicz" id="oblicz"> 
        <input type="submit" name="showHistory" value="Historia pomiarów" id="showHistory">

    </form>
    <img src="./bmi-skale_dla_zdrowia.png" alt="bmi-skale_dla_zdrowia"/>

    
    <?php

    //sekcja do obsugi przesywania formularza
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bmi";

    //Nawizanie poczenia z bazą danych
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_POST['showHistory'])){
        
        //Pobranie danych
        $result = $conn->query("SELECT id_pomiaru, płeć, wiek, waga, wzrost, data_pomiaru FROM pomiary ORDER BY data_pomiaru DESC");
        if($result->num_rows > 0){
            echo '
            <table 
            style="padding: 20px; background-color: rgb(240, 240, 240); border-radius: 5px; margin-top: 50px;
            ">
                <tr>
                <th>Nr pomiaru</th>
                <th>Płeć</th>
                <th>Wiek</th>
                <th>Waga</th>
                <th>Wzrost</th>
                <th>Data pomiaru</th>
                </tr>
            ';
            while($row = $result->fetch_assoc()){
                echo
                "<tr>   
                    <td>" .  htmlspecialchars($row["id_pomiaru"]) . "</td> 
                    <td>" .  htmlspecialchars($row["płeć"]) . "</td> 
                    <td>" .  htmlspecialchars($row["wiek"]) . "</td> 
                    <td>" . htmlspecialchars($row["waga"]) . "</td> 
                    <td>" .  htmlspecialchars($row["wzrost"]) . "</td>  
                    <td>" .  htmlspecialchars($row["data_pomiaru"]) . "</td>   
                </tr>";
            }
            echo "</table>";
        }
        else {
            echo "<p>Brak historii pomiarów.</p>";
        }

        $conn->close();

    }
    
    if (($_SERVER["REQUEST_METHOD"] === "POST") && isset($_POST['calculate'])) {
        
        $wiek = $_POST['wiek'];
        $waga = $_POST['waga'];
        $wzrost = $_POST['wzrost'];
        
        
        
        if(empty($wiek) || empty($waga) || empty($wzrost) || empty($_POST['płeć'])){
            //echo '<h3><h3><span style="color: red;">Prosze wypełnić wszystkie pola!</span></h3></h3>';
            $message = "Prosze wypełnić wszystkie pola!";
            echo "<script>alert('$message');</script>";
            
        }
        else if ($wiek < 18) {
            //echo '<h3><h3><span style="color: red;">BMI obliczamy tylko dla osób dorosłych!</span></h3></h3>';
            $message = "BMI obliczamy tylko dla osób dorosłych!";
            echo "<script>alert('$message');</script>";
            
        }
        else{
            $plec = $_POST['płeć'];


            if($wzrost > 0 && $waga > 0){
                $wzrostWMetrach = $wzrost / 100;
                $bmi = $waga / ($wzrostWMetrach * $wzrostWMetrach);
    
                if ($_POST['płeć'] == "kobieta"){
                    echo "<h3>Dla kobiety:</h3>";
                }
                if ($_POST['płeć'] == "mężczyzna") {
                    echo "<h3>Dla mężczyzny:</h3>";
                }
    
                if($bmi<16){
                    echo '<h3><span style="color: rgb(128, 202, 198);">Wygłodzenie</span></h3>' ;
                }
                else if(16 <= $bmi && $bmi < 17 ){
                    echo '<h3><span style="color: rgba(39, 164, 137, 0.923);">Wychudzenie</span></h3>' ;
                }
                else if(17 <= $bmi && $bmi < 18.5 ){
                    echo '<h3><span style="color: rgba(51, 137, 199, 0.923);">Niedowaga</span></h3>' ;
                }
                else if(18.5 <= $bmi && $bmi < 25 ){
                    echo '<h3><span style="color: rgba(112, 207, 64, 0.923);">Optimum</span></h3>' ;
                }
                else if(25 <= $bmi && $bmi < 30 ){
                    echo '<h3><span style="color: rgb(233, 218, 51);">Nadwaga</span></h3>' ;
                }
                else if(30 <= $bmi && $bmi < 35 ){
                    echo '<h3><span style="color: rgb(233, 139, 51);">Otyłość | stopnia</span></h3>' ;
                }
                else if(35 <= $bmi && $bmi < 40 ){
                    echo '<h3><span style="color: rgb(232, 102, 169);">Otyłość || stopnia</span></h3>' ;
                }
                else if(40 <= $bmi){
                    echo '<h3><span style="color: rgb(255, 45, 45);">Otyłość ||| stopnia</span></h3>' ;
                }
    
    
                //Przygotowanie zapytania SQL:
                $stmt = $conn->prepare("INSERT INTO pomiary (płeć, wiek, waga, wzrost) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sddi", $plec, $wiek, $waga, $wzrost);
                $stmt->execute();
                $stmt->close();
    
                //wynik
                echo "<h3>Twoje BMI wynosi: " . number_format($bmi, 2) . "</h3>";
    
            }
            else{
                //echo '<h3><span style="color: red;">Wprowadź poprawne wartości!</span></h3>';
                $message = "Wprowadź poprawne wartości";
                echo "<script>alert('$message');</script>";
            }
        }
        $conn->close();
    }

    ?>


    <!--przemieszczanie po stronie -->
    <div id="target-section"></div>
    <script>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['calculate']) || isset($_POST['showHistory'])) ) {
        echo 'document.getElementById("target-section").scrollIntoView({ behavior: "smooth" });';
    }
    ?>
    </script>
    
    <footer>
    <p>Numer albumu: 66617</p>
    <p>Copyright &#169 Anastasiia Bzova</p>
    <p>(08-16.05.2024)</p>
    </footer>

</body>
</html>