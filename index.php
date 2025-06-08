<?php
require_once 'includes/session.php';

startSecureSession();

if (isUserLoggedIn()) {
    header('Location: public/home.html');
} else {
    header('Location: public/signin.html');
}
exit();
