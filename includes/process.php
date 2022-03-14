<!--
Citation: Created using template from Bootstrap
Name: Forms 
Author: Bootstrap developers
URL: https://getbootstrap.com/docs/5.1/forms/form-control/
Date accessed: 14 Mar 2022
-->

<div>
    <form method="post" action="includes/process.php">
        <div class="form">
            <!-- user login input form -->
            <div>
                <h2>Add Contact</h2>
            </div>
            <div>
                <img src=" img/profile.jpg" alt="profile picture" id="imageProfile">
            </div>
            <!-- takes in the first name -->
            <div class="mb-3">
                <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Firstname" name="inputFirstname" required>
            </div>
            <!-- takes in the last name -->
            <div class="mb-3">
                <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Lastname" name="inputLastname" required>
            </div>
            <!-- takes in the email -->
            <div class="mb-3">
                <input type="email" class="form-control" id="formGroupExampleInput" placeholder="example@abc.com" name="inputEmail" required>
            </div>
            <!-- takes in the number -->
            <div class="mb-3">
                <input type="tel" class="form-control" id="formGroupExampleInput2" placeholder="xxx xxx-xxxx" pattern="[0-9]{3} [0-9]{3}-[0-9]{4}" name="inputNumber" required><em>Input format: xxx xxx-xxxx</em>
            </div>
            <!-- submit button for the form -->
            <div class="col-12">
                <button type="submit" class="btn btn-primary" name="buttonAdd">Add Contact</button>
            </div>
        </div>
    </form>
</div>

<?php

    session_start();    
    require_once "functions.php";

    if(isset($_POST["buttonAdd"])){

        $inputFirstname = sanitizeData($_POST['inputFirstname']);
        $inputLastname = sanitizeData($_POST['inputLastname']);
        $inputEmail = sanitizeData($_POST['inputEmail']);
        $inputNumber = sanitizeData($_POST['inputNumber']);

        $mysqli = new mysqli("localhost", "root", "root", "WeUsThem");

        $sqlQuery = "SELECT * FROM contacts";

        $result = $mysqli->query($sqlQuery);

        while($resultArray = $result->fetch_assoc()){
            $lastID = $resultArray['contact_id'];
        }

        $lastID = $lastID + 1;

        $_SESSION["userIDLast"] = "{$lastID}";

        $queryToAdd = "INSERT INTO contacts VALUES({$_SESSION['userIDLast']} , '{$inputFirstname}' , '{$inputLastname}' , '{$inputEmail}' , '{$inputNumber}')";

        $mysqli->query($queryToAdd);

        $_SESSION['contact_firstname'] = $inputFirstname;
        $_SESSION['contact_lastname'] = $inputLastname;
        $_SESSION['contact_email'] = $inputEmail;
        $_SESSION['contact_number'] = $inputNumber;

        header("Location: ../contacts.php");
        //echo "{$_SESSION['userIDLast']}";
    }
?>
