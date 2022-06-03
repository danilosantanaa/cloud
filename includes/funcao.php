<?php
function verificarLogin() {
    if(!isset( $_SESSION['id'])) header("location: login.php");
}