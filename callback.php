<?php

// INCLUDE THE DATABASE CONNECTION FILE
include 'dbcon.php';

// Get the M-Pesa callback data from the input stream
$callbackData = file_get_contents('php://input');

// Log the callback data for debugging
$logFile = "mpesa_callback.log";
file_put_contents($logFile, $callbackData . PHP_EOL, FILE_APPEND);

// Decode the JSON data
$data = json_decode($callbackData);

if ($data && isset($data->Body->stkCallback)) {
    $merchantRequestId = $data->Body->stkCallback->MerchantRequestID;
    $checkoutRequestId = $data->Body->stkCallback->CheckoutRequestID;
    $resultCode = $data->Body->stkCallback->ResultCode;
    $resultDesc = $data->Body->stkCallback->ResultDesc;

    // Check if the transaction was successful
    if ($resultCode == 0 && isset($data->Body->stkCallback->CallbackMetadata->Item)) {
        $callbackMetadata = $data->Body->stkCallback->CallbackMetadata->Item;

        // Extract metadata values
        $amount = findMetadataValue($callbackMetadata, 'Amount');
        $mpesaReceiptNumber = findMetadataValue($callbackMetadata, 'MpesaReceiptNumber');
        $transactionDate = findMetadataValue($callbackMetadata, 'TransactionDate');
        $phoneNumber = findMetadataValue($callbackMetadata, 'PhoneNumber');

        // Insert transaction data into database
        $query = "INSERT INTO `transaction` (MerchantRequestID, CheckoutRequestID, ResultCode, Amount, MpesaReceiptNumber, TransactionDate, PhoneNumber) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($db, $query);

        if ($stmt) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ssissss", $merchantRequestId, $checkoutRequestId, $resultCode, $amount, $mpesaReceiptNumber, $transactionDate, $phoneNumber);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                // Close the statement
                mysqli_stmt_close($stmt);
                echo "Data inserted successfully!";
            } else {
                // Handle database insertion error
                error_log("Error in database insertion: " . mysqli_error($db));
                echo "Error in database insertion!";
            }
        } else {
            // Handle prepared statement creation failure
            error_log("Error creating prepared statement: " . mysqli_error($db));
            echo "Error creating prepared statement!";
        }
    } else {
        // Handle non-successful transaction or missing metadata
        echo "Non-successful transaction or missing metadata!";
    }
} else {
    // Handle invalid or missing JSON data
    echo "Invalid or missing JSON data!";
}

// Helper function to find metadata value by key
function findMetadataValue($metadata, $key)
{
    foreach ($metadata as $item) {
        if ($item->Name == $key && isset($item->Value)) {
            return $item->Value;
        }
    }
    return null;
}

?>
