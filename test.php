<?php

$can_edit = false;
$is_admin = true;

if ( $is_admin ) {
   echo 'Welcome, admin!';
   $can_edit = true;
}
