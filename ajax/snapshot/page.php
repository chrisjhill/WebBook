<?php
include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php';

// Grab all of their current snapshots
$snapshots = Controller_Snapshot_Resource::generate($book->getInfo('book_id'));
?>

<div class="container secondary">
    <div class="container-inner">
        <h1>Snapshots</h1>
        
        <p><em>You can store up to <?=(int)$user->getInfo('plan_snapshot_limit')?> book snapshots at any one time. A snapshot is a complete copy of your book at a particular moment in time, so is a good way for you to locate that all-important text you misplaced.</em></p>
        
        <h2>Take a snapshot</h2>
        
        <form>
            <p>
                <a href="#" id="snapshot-save" class="button orange bigrounded">Create a snapshot of my book, please</a><br />
            </p>
        </form>
        
        <h2>Your snapshots</h2>
        
        <table>
            <tr>
                <th>Snapshot generated</th>
                <th>Age</th>
                <th>View</th>
                <th>Remove</th>
            </tr>
            <?php if ($snapshots->rowCount() <= 0) { ?>
                <tr>
                    <td colspan="3">You currently have no snapshots.</td>
                </tr>
            <?php } else { ?>
                <?php while ($snapshot = $snapshots->fetch()) { ?>
                    <tr id="snapshot-<?=(int)$snapshot['snapshot_created']?>">
                        <td><?=Model_Date::getDate($snapshot['snapshot_created'])?></td>
                        <td><?=Model_Date::getDifference($snapshot['snapshot_created'], $_SERVER['REQUEST_TIME'])?></td>
                        <td><a href="/snap/<?=(int)$book->getInfo('book_id')?>/<?=(int)$snapshot['snapshot_created']?>/<?=Model_Format::parseUrl($book->getInfo('book_title'))?>" target="_blank" class="snapshot-view button white medium">View</a></td>
                        <td><a href="#" class="snapshot-remove button white medium" data-snapshotid="<?=(int)$snapshot['snapshot_created']?>">Remove</a></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
    </div>
</div>