<?php 

function good_mkdir($path,$permissions) { 
    $oldmask = umask(0); 
    mkdir($path,$permissions); 
    umask($oldmask);
}

?>