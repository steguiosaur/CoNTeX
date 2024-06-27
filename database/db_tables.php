<?php

// connect to database
include 'db_connect.php';

// define all table creation SQL statement
$create_users_table = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$create_vaults_table = "CREATE TABLE IF NOT EXISTS vaults (
    vault_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

$create_documents_table = "CREATE TABLE IF NOT EXISTS documents (
    document_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED,
    vault_id INT(11) UNSIGNED,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (vault_id) REFERENCES vaults(vault_id) ON DELETE SET NULL
)";

$create_vault_documents_table = "CREATE TABLE IF NOT EXISTS vault_documents (
    vault_id INT(11) UNSIGNED,
    document_id INT(11) UNSIGNED,
    PRIMARY KEY (vault_id, document_id),
    FOREIGN KEY (vault_id) REFERENCES vaults(vault_id) ON DELETE CASCADE,
    FOREIGN KEY (document_id) REFERENCES documents(document_id) ON DELETE CASCADE
)";

$create_collaborators_table = "CREATE TABLE IF NOT EXISTS collaborators (
    collaborator_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    document_id INT(11) UNSIGNED,
    user_id INT(11) UNSIGNED,
    role ENUM('owner', 'editor') NOT NULL,
    FOREIGN KEY (document_id) REFERENCES documents(document_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

$create_vault_collaborators_table = "CREATE TABLE IF NOT EXISTS vault_collaborators (
    vault_collaborator_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    vault_id INT(11) UNSIGNED,
    user_id INT(11) UNSIGNED,
    role ENUM('owner', 'editor') NOT NULL,
    FOREIGN KEY (vault_id) REFERENCES vaults(vault_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

// execute the table creation SQL statements
$conn->query($create_users_table);
$conn->query($create_vaults_table);
$conn->query($create_documents_table);
$conn->query($create_vault_documents_table);
$conn->query($create_collaborators_table);
$conn->query($create_vault_collaborators_table);

// close the connection
$conn->close();
