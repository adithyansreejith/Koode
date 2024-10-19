<?php
session_start();
require_once("./Connector/DbConnectorPDO.php");
require("./helper/helperFunctions.php");

$connection = getConnection();
$errors = [];

// Handle delete request
if (isset($_GET['delete_id'])) {
    try {
        $deleteId = $_GET['delete_id'];
        $deleteQuery = "DELETE FROM profile WHERE id = :id";
        $deleteStmt = $connection->prepare($deleteQuery);
        $deleteStmt->bindParam(':id', $deleteId, PDO::PARAM_INT);
        $deleteStmt->execute();

        if ($deleteStmt->rowCount() > 0) {
            header("Location: ./admin.php"); // Redirect to refresh the page after deletion
            exit();
        } else {
            $errors[] = "Failed to delete profile with ID $deleteId.";
        }
    } catch (Exception $e) {
        $errors[] = "Error deleting profile: " . $e->getMessage();
    }
}

// Fetch all profiles except the one with ID 999
try {
    $queryForProfiles = "SELECT id, firstName, lastName FROM profile WHERE id != 999";
    $stmt = $connection->prepare($queryForProfiles);
    $stmt->execute();
    $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errors[] = "Error fetching profiles: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-dark bg-danger">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Hello Admin!</span>
                <a href="./logout.php" class="btn btn-lg btn-light" style="border-radius: 30px;">Logout</a>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
        <h1>All User Profiles</h1>

        <!-- Display Errors -->
        <?php if (count($errors) > 0): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <table class="table table-bordered table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($profiles) > 0): ?>
                    <?php foreach ($profiles as $profile): ?>
                        <tr>
                            <td><?= htmlspecialchars($profile['firstName']) ?></td>
                            <td>
                                <a href="./full-profile.php?id=<?= $profile['id'] ?>" 
                                   class="btn btn-success" style="border-radius: 30px;">View</a>
                                <a href="./admin.php?delete_id=<?= $profile['id'] ?>" 
                                   class="btn btn-danger" style="border-radius: 30px;"
                                   onclick="return confirm('Are you sure you want to delete this profile?');">
                                   Remove
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="text-center">
                        <td colspan="2">No profiles found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>

