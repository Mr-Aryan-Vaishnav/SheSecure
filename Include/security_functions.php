<?php
// Include/security_functions.php

// 1. Load the master keys from your config file
// Using __DIR__ ensures it always finds config.php in the same folder
require_once __DIR__ . '/db_connect.php';
/**
 * Encrypts plain text data using AES-256-CBC
 * * @param string $data The plain text data to encrypt (e.g., "Priya Sharma")
 * @return string|null The encrypted string, or null if the input was empty
 */
function encrypt_data($data) {
    // Don't try to encrypt empty strings
    if (empty($data)) {
        return null;
    }

    // Encrypt the data using the keys defined in config.php
    $encrypted = openssl_encrypt(
        $data, 
        'aes-256-cbc', 
        ENCRYPTION_KEY, 
        0, 
        ENCRYPTION_IV
    );

    return $encrypted;
}

/**
 * Decrypts AES-256-CBC encrypted data back to plain text
 * * @param string $data The encrypted string from the database
 * @return string|null The decrypted plain text, or null if it fails
 */
function decrypt_data($data) {
    if (empty($data)) {
        return null;
    }

    // Unlock the data using the same keys
    $decrypted = openssl_decrypt(
        $data, 
        'aes-256-cbc', 
        ENCRYPTION_KEY, 
        0, 
        ENCRYPTION_IV
    );

    return $decrypted;
}

/**
 * Creates a secure one-way hash for database lookups.
 * Because we encrypt emails (making them random strings like "xJ9/kL="), 
 * we can't easily search the database to see if an email already exists.
 * Instead, we save a HASH of the email and search for that.
 * * @param string $data The data to hash (e.g., an email address)
 * @return string The 64-character SHA-256 hash
 */
function create_lookup_hash($data) {
    if (empty($data)) {
        return null;
    }
    
    // We add your secret ENCRYPTION_KEY to the end of the email before hashing.
    // This acts as a "Pepper", meaning even if a hacker steals your database,
    // they cannot reverse-engineer the hashes without also stealing this PHP file.
    return hash('sha256', $data . ENCRYPTION_KEY);
}
?>