<?php

    session_start();
    require_once "includes/header.php";
    require_once "includes/functions.php";

    $mysqli = new mysqli("localhost", "root", "root", "WeUsThem");

    // checks if the database is connected and prints message if not connected and exits
    if($mysqli->connect_error){
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    $sqlQuery = "SELECT * FROM contacts";

    $result = $mysqli->query($sqlQuery);

    echo "<div id='content'>";
    while($sqlResultsArray = $result->fetch_assoc()){
        echo "<p>" . $sqlResultsArray['contact_id'] . " | " . $sqlResultsArray['contact_firstname'] . " " . $sqlResultsArray['contact_lastname'] . " <br> " . $sqlResultsArray['contact_email'] . " <br> " . $sqlResultsArray['contact_phone'] . "<br><a href='edit.php?edited={$sqlResultsArray['contact_id']}' >Edit</a> <a href='edit.php?deleted={$sqlResultsArray['contact_id']}'>Delete </a></p>";

        if(isset($_REQUEST['edited'])){

            if($_REQUEST['edited'] == $sqlResultsArray['contact_id']){
                $_SESSION['idChange'] = $_REQUEST['edited'];

                $placeholder = "SELECT * FROM contacts WHERE contact_id = {$_REQUEST['edited']}";

                $answer = $mysqli->query($placeholder);

                $answerArray = $answer->fetch_assoc();

                echo "<div>
                    <form method='post' action='#'>
                        <div class='form'>
                            <div>
                                <h2>Edit Contact</h2>
                            </div>
                            <div>
                                <img src='img/profile.jpg' alt='profile picture' id='imageProfile'>
                            </div>
                            <div class='mb-3'>
                                <input type='text' class='form-control' id='formGroupExampleInput' placeholder='Firstname' value='{$answerArray['contact_firstname']}' name='inputFirstnamee' required>
                            </div>
                            <div class='mb-3'>
                                <input type='text' class='form-control' id='formGroupExampleInput' placeholder='Lastname' value='{$answerArray['contact_lastname']}' name='inputLastnamee' required>
                            </div>
                            <div class='mb-3'>
                                <input type='text' class='form-control' id='formGroupExampleInput' placeholder='example@abc.com' value='{$answerArray['contact_email']}' name='inputEmaill' required>
                            </div>
                            <div class='mb-3'>
                                <input type='tel' class='form-control' id='formGroupExampleInput2' placeholder='xxx xxx-xxxx' value='{$answerArray['contact_phone']}' name='inputNumberr' pattern='[0-9]{3} [0-9]{3}-[0-9]{4}' required><em>Input format: xxx xxx-xxxx</em>
                            </div>
                            <!-- submit button for the form -->
                            <div class='col-12'>
                                <button type='submit' class='btn btn-primary' name='buttonUpdate'>Update Contact</button>
                            </div>
                        </div>
                    </form>
                </div>";
                    
            }
        } else if(isset($_REQUEST['deleted'])){
            if($_REQUEST['deleted'] == $sqlResultsArray['contact_id']){
                $query = "DELETE FROM contacts WHERE contact_id = {$sqlResultsArray['contact_id']}";
                $mysqli->query($query);
                unset($_REQUEST['deleted']);
                header("Location: edit.php");
            }
        }
        echo "<hr>";
    }
    echo "</div>";

    if(isset($_POST['buttonUpdate'])){

        echo "hello";
        $queryUpdate = "UPDATE contacts SET contact_firstname = '{$_POST['inputFirstnamee']}', contact_lastname = '{$_POST['inputLastnamee']}', contact_email = '{$_POST['inputEmaill']}', contact_phone = '{$_POST['inputNumberr']}' WHERE contact_id = {$_SESSION['idChange']}";

        $mysqli->query($queryUpdate);

        unset($_REQUEST['edited']);
        unset($_SESSION['idChange']);

        header("Location: edit.php");
    }
    
?>

<?php
    require_once "includes/footer.php";
?>