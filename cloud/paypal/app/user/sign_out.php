<?php
require_once __DIR__ . '/../bootstrap.php';
session_start();

signOut();
header("Location: ../index.php?message=Signed+out+successfully");
exit;