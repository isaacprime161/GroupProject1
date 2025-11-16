<?php
require_once 'db_connection.php';
session_start();

if (!isset($_SESSION['org_id'])) {
    die("Access denied.");
}

$org_id = $_SESSION['org_id'];
$sql = "SELECT * FROM payments WHERE org_id = ? ORDER BY timestamp DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $org_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f6f8;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 30px 30px 10px 30px;
        }
        h2 {
            text-align: center;
            color: #1b263b;
        }
        .payment-card {
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 18px 20px;
            margin-bottom: 18px;
            background: #f9fafb;
        }
        .payment-card strong {
            color: #1b263b;
        }
        .payment-card .status {
            font-weight: bold;
            color: #fff;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 0.95em;
            margin-left: 8px;
        }
        .payment-card .status.paid {
            background: #4CAF50;
        }
        .payment-card .status.pending {
            background: #fbc02d;
        }
        .payment-card .status.failed {
            background: #f44336;
        }
        .payment-card .status.other {
            background: #607d8b;
        }
        .payment-label {
            display: inline-block;
            width: 140px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Payment History</h2>
        <?php if ($result->num_rows === 0): ?>
            <p>No payments found.</p>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="payment-card">
                    <div><span class="payment-label">Payment ID:</span> <strong><?= htmlspecialchars($row['payment_id']) ?></strong></div>
                    <div><span class="payment-label">App ID:</span> <?= htmlspecialchars($row['app_id']) ?></div>
                    <div><span class="payment-label">Amount:</span> $<?= htmlspecialchars($row['amount']) ?></div>
                    <div><span class="payment-label">Transaction Code:</span> <?= htmlspecialchars($row['transaction_code']) ?></div>
                    <div><span class="payment-label">Date:</span> <?= htmlspecialchars($row['timestamp']) ?></div>
                    <div><span class="payment-label">Status:</span>
                        <?php
                            $status = strtolower($row['payment_status']);
                            $statusClass = 'other';
                            if ($status === 'paid') $statusClass = 'paid';
                            elseif ($status === 'pending') $statusClass = 'pending';
                            elseif ($status === 'failed') $statusClass = 'failed';
                        ?>
                        <span class="status <?= $statusClass ?>"><?= htmlspecialchars($row['payment_status']) ?></span>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</body>
</html>