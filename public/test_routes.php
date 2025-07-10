<!DOCTYPE html>
<html>

<head>
    <title>Direct Route Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Direct Route Test</h2>

        <div class="alert alert-info">
            This form posts directly to CodeIgniter route: <code>POST /requests/store</code>
        </div>

        <!-- Test form with absolute URL -->
        <form method="post" action="http://localhost:8080/requests/store">
            <div class="mb-3">
                <label>Request Date:</label>
                <input type="date" name="request_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="mb-3">
                <label>Purpose:</label>
                <textarea name="purpose" class="form-control" required>Test direct route submission to CodeIgniter</textarea>
            </div>

            <div class="mb-3">
                <label>Items (hidden):</label>
                <input type="hidden" name="items[]" value="1">
                <input type="text" class="form-control" value="Laptop Asus X441BA (ID: 1)" readonly>
            </div>

            <div class="mb-3">
                <label>Quantities:</label>
                <input type="hidden" name="quantities[]" value="1">
                <input type="text" class="form-control" value="1" readonly>
            </div>

            <div class="mb-3">
                <label>Notes:</label>
                <input type="hidden" name="notes[]" value="Direct route test">
                <input type="text" class="form-control" value="Direct route test" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Submit to CodeIgniter</button>
        </form>

        <hr>
        <p><a href="/requests">Back to Requests</a> | <a href="/check_routes.php">Check Routes</a></p>
    </div>
</body>

</html>