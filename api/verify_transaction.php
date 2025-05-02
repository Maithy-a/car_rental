<?php
header('Content-Type: application/json');
include('../includes/config.php');

$reference = isset($_GET['reference']) ? $_GET['reference'] : '';

if (empty($reference)) {
    echo json_encode(['status' => 'error', 'message' => 'No transaction reference provided']);
    exit();
}

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . $reference,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer " . $SecretKey,
        "Content-Type: application/json"
    ],
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo json_encode(['status' => 'error', 'message' => 'cURL Error: ' . $err]);
    exit();
}

$transaction = json_decode($response, true);

if ($transaction['status'] && $transaction['data']['status'] === 'success') {
    $amount = $transaction['data']['amount'] / 100; // Convert from kobo to KES
    $email = $transaction['data']['customer']['email'];
    $bookingNumber = $transaction['data']['metadata']['booking_number'];

    // Check if transaction already exists
    $checkSql = "SELECT * FROM tbltransactions WHERE TransactionReference = :reference";
    $checkQuery = $dbh->prepare($checkSql);
    $checkQuery->bindParam(':reference', $reference, PDO::PARAM_STR);
    $checkQuery->execute();

    if ($checkQuery->rowCount() == 0) {
        // Insert transaction into tbltransactions
        $insertSql = "INSERT INTO tbltransactions (BookingNumber, userEmail, TransactionReference, Amount, PaymentStatus, created_at) 
                      VALUES (:bookingNumber, :userEmail, :reference, :amount, 1, NOW())";
        $insertQuery = $dbh->prepare($insertSql);
        $insertQuery->bindParam(':bookingNumber', $bookingNumber, PDO::PARAM_STR);
        $insertQuery->bindParam(':userEmail', $email, PDO::PARAM_STR);
        $insertQuery->bindParam(':reference', $reference, PDO::PARAM_STR);
        $insertQuery->bindParam(':amount', $amount, PDO::PARAM_STR);
        $insertQuery->execute();
    }

    // Store success message in session
    session_start();
    $_SESSION['payment_success'] = "Payment for booking #$bookingNumber was successful! Transaction Reference: $reference";

    echo json_encode(['status' => 'success', 'message' => 'Transaction verified and stored']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Transaction verification failed']);
}
?>