<?php
    $_SESSION['theme'] = ($_SESSION['theme'] === 'night') ? 'day' : 'night';
    $result = ['ok' => true];
    echo json_encode($result);
    return;
?>