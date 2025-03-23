<!-- app/Views/billingView.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Electricity Bills</title>
</head>
<body>
<h1>Update Billing Rates</h1>

<?php if (isset($errorMessage) && $errorMessage !== null): ?>
    <p style="color:red;">Error: <?= htmlspecialchars($errorMessage) ?></p>
<?php endif; ?>

<form method="POST" action="">
    <label for="peak_rate">Peak Rate ($/kWh):</label>
    <input type="number" step="0.01" id="peak_rate" name="peak_rate" value="<?= htmlspecialchars($currentPeakRate) ?>" required>
    <br><br>
    <label for="offpeak_rate">Off-Peak Rate ($/kWh):</label>
    <input type="number" step="0.01" id="offpeak_rate" name="offpeak_rate" value="<?= htmlspecialchars($currentOffPeakRate) ?>" required>
    <br><br>
    <button type="submit">Update Rates</button>
</form>

<h1>Calculated Electricity Bills</h1>
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
    <tr>
        <th>Meter ID</th>
        <th>Total Cost ($)</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($bills)): ?>
        <tr>
            <td colspan="2">No billing data available.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($bills as $meterId => $bill): ?>
            <tr>
                <td><?= htmlspecialchars($meterId) ?></td>
                <td><?= number_format($bill->totalCost, 2) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>
