<?php
    session_start();
    while(!session_unset())
    {
        session_unset();
    }
    session_destroy();
?>