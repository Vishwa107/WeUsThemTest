<?php
    session_start();
    require_once "includes/header.php";
    require_once "includes/functions.php";
?>

<div id="formform">
    <form method="post" action="index.php">
        <div class="form">
            <div class="mb-3">
                <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Firstname" name="inputName">
            </div>
            <!-- submit button for the form -->
            <div class="col-12">
                <button type="submit" class="btn btn-primary" name="buttonSearch">Search Contact</button>
            </div>
        </div>
    </form>
</div>
<?php

    if(isset($_POST['buttonSearch'])){

        $mysqli = new mysqli("localhost", "root", "root", "WeUsThem");

        $inputName = sanitizeData($_POST['inputName']);

        $sqlQuery = "SELECT * FROM contacts WHERE contact_firstname = '{$inputName}'";

        $result = $mysqli->query($sqlQuery);

        if($result->num_rows != 0){
            echo "<table><tr><th>ID</th><th>Firstname</th><th>Lastname</th><th>Email</th><th>Phone number</th></tr>";
            while($sqlResultsArray = $result->fetch_assoc()){
                echo "<tr><td>" . $sqlResultsArray['contact_id'] . "</td><td>" . $sqlResultsArray['contact_firstname'] . "</td><td>" . $sqlResultsArray['contact_lastname'] . "</td><td>" . $sqlResultsArray['contact_email'] . "</td><td>" . $sqlResultsArray['contact_phone'] . "</td></tr>";
            }
            echo "</table>";
        }else {
            echo "<h2> No results found!</h2>";
        }

        unset($_POST['buttonSearch']);
    } else {
        $mysqli = new mysqli("localhost", "root", "root", "WeUsThem");

        $sqlQuery = "SELECT * FROM contacts";

        $result = $mysqli->query($sqlQuery);

        echo "<table><tr><th>ID</th><th>Firstname</th><th>Lastname</th><th>Email</th><th>Phone number</th></tr>";
        while($sqlResultsArray = $result->fetch_assoc()){
            echo "<tr><td>" . $sqlResultsArray['contact_id'] . "</td><td>" . $sqlResultsArray['contact_firstname'] . "</td><td>" . $sqlResultsArray['contact_lastname'] . "</td><td>" . $sqlResultsArray['contact_email'] . "</td><td>" . $sqlResultsArray['contact_phone'] . "</td></tr>";
        }
        echo "</table>";
    }
    
?>
<?php
    require_once "includes/footer.php";
?>