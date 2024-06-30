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

// session variables
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$user_id = $_SESSION['user_id'];
$join_year = $_SESSION['created_at'];

// example profile picture URL only (replace with actual path)
$profile_picture = 'img/account.png';
?>

                <img class="profile-img" src="<?php echo $profile_picture; ?>" alt="Profile Picture" />
                <div class="profile-info">
                    <h4 class="profile-name"><?php echo $username; ?></h4>
                    <p>ID: <?php echo $user_id; ?></p>
                    <p>Email: <?php echo $email; ?></p>
                    <p>Joined <?php echo $join_year; ?></p>
                    <form action="sessions/session_out.php" method="POST">
                        <button type="submit" name="logout">Sign Out</button>
                    </form>
                </div>
            </div>
            <div class="vaults">
                <h4>Your Vault</h4>
                <section class="vault-section">
                    <button class="btn-outline" id="add-vault-btn" type="button">Add Vault</button>
                    <button class="btn-fill" type="button">Machine Learning</button>
                    <button class="btn-fill" type="button">Cybersecurity</button>
                    <button class="btn-fill" type="button">Software Engineering</button>
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
  <div class="modal-content">
    <div class="modal-header">
      <h3>Create Vault</h3>
    </div>
    <div class="modal-body">
      <input type="text" id="vault-name" placeholder="Enter vault name">
    </div>
    <div class="modal-buttons">
      <button class="btn-create" id="create-vault">Create</button>
      <button class="btn-cancel" id="cancel-vault">Cancel</button>
    </div>
  </div>
</div>

<?php require 'layouts/footer.php'; ?>

<script src="js/vault_modal.js"></script>
