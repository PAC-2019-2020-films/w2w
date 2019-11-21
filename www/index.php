<?php

define("FR_AUTORUN", true);

if (! @include "../appsrc/bootstrap.php") {
    /* failed starting application : */
    header("HTTP/1.0 503 Service Unavailable");
    if (! @include "error503.php") {
        echo "503 Service Unavailable";
    }
}
