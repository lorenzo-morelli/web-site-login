<?php

$connessione = new mysqli("fdb20.biz.nf", "2751365_login", "Lorenzo01", "2751365_login");    //mysqli(SERVER, ROOT, PASSWORD, DATABASE)

/* check connection */
if (mysqli_connect_errno()) {
    echo "Connect failed: %s\n" . mysqli_connect_error();
    exit();
}