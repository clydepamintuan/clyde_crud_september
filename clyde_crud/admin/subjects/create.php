<?php
session_start();
include "../../config/database.php";

// Only admin can access this page
if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") {
    header("Location: ../../index.php");
    exit();
}

// Save subject
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject_code = trim($_POST["subject_code"]);
    $subject_name = trim($_POST["subject_name"]);
    $units = (int) $_POST["units"];

    // Insert into database
    $sql = "INSERT INTO subjects (subject_code, subject_name, units)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {

        mysqli_stmt_bind_param(
            $stmt,
            "ssi",
            $subject_code,
            $subject_name,
            $units
        );

        if (mysqli_stmt_execute($stmt)) {

            // Successfully saved
            header("Location: index.php");
            exit();

        } else {

            $error = "Failed to save subject: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);

    } else {

        $error = "Failed to prepare query: " . mysqli_error($conn);
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Subject Form</title>

    <link
        href="../../assets/vendor/bootstrap/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

    <div
        class="container py-5"
        style="max-width: 700px;"
    >

        <div class="card border-0 shadow-sm">

            <div class="card-body p-4">

                <h2 class="mb-4">Add Subject</h2>

                <?php if (isset($error)) { ?>

                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>

                <?php } ?>

                <form method="POST" action="">

                    <!-- Subject Code -->
                    <div class="mb-3">

                        <label class="form-label">
                            Subject Code
                        </label>

                        <input
                            type="text"
                            name="subject_code"
                            class="form-control"
                            required
                        >

                    </div>

                    <!-- Subject Name -->
                    <div class="mb-3">

                        <label class="form-label">
                            Subject Name
                        </label>

                        <input
                            type="text"
                            name="subject_name"
                            class="form-control"
                            required
                        >

                    </div>

                    <!-- Units -->
                    <div class="mb-3">

                        <label class="form-label">
                            Units
                        </label>

                        <input
                            type="number"
                            name="units"
                            class="form-control"
                            min="1"
                            required
                        >

                    </div>

                    <!-- Form Actions -->
                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Save Subject
                    </button>

                    <a
                        href="index.php"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
