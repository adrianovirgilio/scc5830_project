<?php
    error_reporting(0);
    session_start();
    $excel = $_SESSION['nome'];
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename={$excel}.xls");
    echo $_SESSION['html'];
    die;
?>