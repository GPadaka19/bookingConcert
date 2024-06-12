<?php
    session_start(); //inisialisasi session
    if(session_destroy()) {//menghapus session
        header("Location: login.php"); 
    }
