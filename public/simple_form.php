<?php
// File: public/simple_form.php
// Super simple form test

if ($_POST) {
    echo "<h2>POST Data Received:</h2>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    echo "<br><a href='/requests/store' target='_blank'>Test CodeIgniter Store Method</a>";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Simple Form Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Simple Form Test</h2>

        <form method="post" action="">
            <div class="mb-3">
                <label>Request Date:</label>
                <input type="date" name="request_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="mb-3">
                <label>Purpose:</label>
                <textarea name="purpose" class="form-control" required>Test form submission</textarea>
            </div>

            <div class="mb-3">
                <label>Items:</label>
                <select name="items[]" class="form-control">
                    <option value="1">Laptop Asus X441BA</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Quantities:</label>
                <input type="number" name="quantities[]" class="form-control" value="1">
            </div>

            <div class="mb-3">
                <label>Notes:</label>
                <input type="text" name="notes[]" class="form-control" value="Test note">
            </div>

            <button type="submit" class="btn btn-primary">Test POST Data</button>
        </form>

        <hr>
        <p><a href="/requests/create">Back to Real Form</a></p>
    </div>
</body>

</html>