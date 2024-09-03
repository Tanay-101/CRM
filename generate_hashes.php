<?php
// Generate password hashes
$password1 = password_hash('password123', PASSWORD_DEFAULT);
$password2 = password_hash('mypassword', PASSWORD_DEFAULT);

echo "Hashed Password 1: $password1\n";
echo "Hashed Password 2: $password2\n";
?>
