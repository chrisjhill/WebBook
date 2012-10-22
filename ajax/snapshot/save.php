<?php
include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php';

// Save the snapshot
$snapshotInsert = new Controller_Snapshot_Insert();
$snapshotInsert->insert(array(
    'user'     => $user,
    'settings' => $settings,
    'book'     => $book
));