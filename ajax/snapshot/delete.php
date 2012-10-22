<?php
include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php';

// Delete the snapshot
$snapshotDelete = new Controller_Snapshot_Delete();
$snapshotDelete->delete(array(
    'user'        => $user,
    'settings'    => $settings,
    'book'        => $book,

    'snapshot_id' => $_POST['snapshot_id']
));