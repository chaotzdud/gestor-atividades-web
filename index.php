<?php
require_once '/backend/includes/session.php';

startSecureSession();

if (isUserLoggedIn()) {
    header('Location: frontend/home.html');
} else {
    header('Location: frontend/signin.html');
}
exit();
