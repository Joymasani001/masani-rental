<?php
$dbconn=mysqli_connect("localhost",'root',"","rentals");
$contact=$_GET['contact'];
if(!$dbconn)
{
    echo "Database connection error";
}
if(isset($_POST['transaction_code'])) {
    $transaction_code = $_POST['transaction_code'];
    $verification_result = verifyTransaction($transaction_code);
    if($verification_result === true) {
        $update="update books set status='2' where contact='$contact'";
        if(!mysqli_query($dbconn,$update))
        {
            echo "Try again";
        }
        else{
            $sql="select room_no from books where contact='$contact'";
            $query=mysqli_query($dbconn,$sql);
            $row=mysqli_fetch_assoc($query);
            $room=$row['room_no'];
            $updateSql="update rooms set status='taken' where room_no='$room'";
            $updateQuery=mysqli_query($dbconn,$updateSql);
            echo "Payment confirmed successfully.";
        }
       
    } else {
        $sql2="select room_no from books where contact='$contact'";
        $query2=mysqli_query($dbconn,$sql2);
        $row2=mysqli_fetch_assoc($query2);
        $room2=$row2['room_no'];
        $updateSql2="update rooms set status='available' where room_no='$room2'";
        $updateQuery2=mysqli_query($dbconn,$updateSql2);
        echo "Payment confirmation failed. Try again.";
    }
}
function verifyTransaction($transaction_code) {
    $dbconn=mysqli_connect("localhost",'root',"","rentals");
if(!$dbconn)
{
    echo "Database connection error";
}
    $sql="select * from transaction where MpesaReceiptNumber='$transaction_code'";
    echo $transaction_code;
    $query=mysqli_query($dbconn,$sql);
    echo mysqli_num_rows($query);
    if(mysqli_num_rows($query)>0)
    {
       
        return true; 
    } else {
        return false;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify M-Pesa Transaction</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 20%;
        }
        .form-container {
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Verify M-Pesa Transaction</h2>
        <div class="form-container">
            <form method="post" action="" class="needs-validation" novalidate>
                <div class="form-group">
                    <label for="transaction_code">Transaction Code:</label>
                    <input type="text" class="form-control" id="transaction_code" name="transaction_code" required>
                    <div class="invalid-feedback">
                        Please enter the transaction code.
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Verify Transaction</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Form validation script -->
    <script>
        // Disable form submission if fields are empty
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
    </script>
</body>
</html>

