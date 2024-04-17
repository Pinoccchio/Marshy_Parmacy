<?php
include_once('includes/load.php');

date_default_timezone_set('Asia/Manila');

$req_fields = array('username','password');

validate_fields($req_fields);

$username = remove_junk($_POST['username']);
$password = remove_junk($_POST['password']);

$password_min_length = 8; 
$has_uppercase = preg_match('/[A-Z]/', $password); 
$has_lowercase = preg_match('/[a-z]/', $password); 
$has_number = preg_match('/\d/', $password); 
$has_special_char = preg_match('/[^a-zA-Z0-9]/', $password); 

if (
    strlen($password) < $password_min_length ||
    !$has_uppercase ||
    !$has_lowercase ||
    !$has_number ||
    !$has_special_char
) {
    
    $session->msg("d", "Password must be 8+ characters with 1 uppercase, 1 lowercase,\n1 number, and 1 special character.");
    redirect('index.php', false);
} else {
    
    if(empty($errors)){
        $user_id = authenticate($username, $password);
        if ($user_id) {
            
            $session->login($user_id);
            
        
            updateLastLogIn($user_id); 
            
            $session->msg("s", "Welcome to Inventory Management System");
            redirect('admin.php', false);
        } else {
            $session->msg("d", "Sorry, the username/password is incorrect.");
            redirect('index.php', false);
        }
    } else {
        
        $session->msg("d", $errors);
        redirect('index.php', false);
    }
}
?>