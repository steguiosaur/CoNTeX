<?php
require 'layouts/header.php';
require 'layouts/navbar.php';
?>

<div class="main">
    <div class="container">
        <div class="contain-row">
            <div class="banner">

<?php
// check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // redirect to login page if not logged in
    header('Location: login.php');
    exit;
}

// example profile picture URL only (replace with actual path)
$profile_picture = 'img/account.png';
?>

                <img class="profile-img" src="<?php echo $profile_picture; ?>" alt="Profile Picture" />
                <div class="profile-info">
                    <h4 class="profile-name"><?php echo $_SESSION['username']; ?></h4>
                    <p>ID: <?php echo $_SESSION['user_id']; ?></p>
                    <p>Email: <?php echo $_SESSION['email']; ?></p>
                    <p>Joined <?php echo $_SESSION['created_at']; ?></p>
                    <form action="sessions/session_out.php" method="POST">
                        <button type="submit" name="logout">Sign Out</button>
                    </form>
                </div>
            </div>
<?php
include 'db/db_connect.php';

// fetch all user's accessible vaults
$user_vaults = [];

// your vaults
$stmt = $conn->prepare("SELECT vault_id, name FROM vaults WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $user_vaults[] = $row;
}

$stmt->close();
$conn->close();
?>
            <div class="vaults">
                <h4>Your Vault</h4>
                <section class="vault-section">
                    <button class="btn-outline" id="add-vault-btn" type="button">Add Vault</button>
                    <?php foreach ($user_vaults as $vault): ?>
                    <form class="vault-form" action="editor.php" method="GET">
                        <input type="hidden" name="vault_id" value="<?php echo htmlspecialchars($vault['vault_id']); ?>">
                        <button class="btn-fill" type="submit"><?php echo htmlspecialchars($vault['name']); ?></button>
                    </form>
                    <?php endforeach; ?>
                </section>
                <h4>Other Vault</h4>
                <section class="vault-section">
                    <button class="btn-fill" type="button">WebDev</button>
                    <button class="btn-fill" type="button">Thesis</button>
                </section>
            </div>
        </div>
    </div>
</div>

<div id="create-vault-modal" class="modal">
    <form class="modal-content" method="POST">
        <div class="modal-header">
            <h3>Create Vault</h3>
        </div>
        <div class="modal-body">
            <input type="text" id="vault-name" name="vault-name" placeholder="Enter vault name">
        </div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vault_name = $_POST['vault-name'];
    $errors = [];

    if (!isset($_SESSION['user_id'])) {
        $errors[] = "User not logged in";
    }

    if (empty($vault_name)) {
        $errors[] = "Vault name cannot be empty";
    }

    // accept only letters, numbers and space
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $vault_name)) {
        $errors[] = "Vault name can only contain letters and numbers";
    }

    if (count($errors) == 0) {
        include 'db/db_connect.php';
        // check if vault name already exists
        $stmt = $conn->prepare("SELECT * FROM vaults WHERE name = ? AND user_id = ?");
        $stmt->bind_param("si", $vault_name, $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Vault name already exists";
        } else {
            // create new vault
            $stmt = "INSERT INTO vaults (user_id, name) VALUES ('$_SESSION[user_id]', '$vault_name')";

            if ($conn->query($stmt) === true) {
                echo "New vault created successfully";
                header('Location: vault.php');
                exit;
            } else {
                $errors[] = "Error: " . $stmt . "<br>" . $conn->error;
            }
        }

        $stmt->close();
        $conn->close();
    }

    // Handle errors
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red; padding: 0;'>" . $error . "</p>";
        }
    }
}
?>
        <br>
        <div class="modal-buttons">
            <button class="btn-create" id="create-vault" type="submit">Create</button>
            <button class="btn-cancel" id="cancel-vault">Cancel</button>
        </div>

    </form>
</div>

<?php require 'layouts/footer.php'; ?>

<script src="js/vault_modal.js"></script>
