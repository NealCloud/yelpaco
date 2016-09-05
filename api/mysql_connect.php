<?php
$conn = mysqli_connect("52.35.3.250", "tacoking", "9cMLjGhVtSzsP6K4", "tacofinder");

if(mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}