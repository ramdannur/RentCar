<?php
include("library.php");
do_logout();
echo js_alert('berhasil logout!');
echo js_redir($base_url);
?>