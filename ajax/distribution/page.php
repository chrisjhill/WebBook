<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php'; ?>

<div class="container secondary">
    <div class="container-inner">
        <form>
            <h1>Distribution on the Webernet</h1>
            
            <p><em>There are several ways for you to distribute your book. You can either "shut it down" so only you can view it, open it up to the whole world, or only let people view it whom you deem worthy.</em></p>
            
            <?php if ($book->getInfo('book_distribution') >= 1) { ?>
                <h2>Spread the word!</h2>
                
                <p>
                    Available at:
                    <input type="text" class="url" value="http://localhost/read/1/<?=$book->getPassword()?>/its-a-kind-of-magic" readonly />
                </p>
            <?php } ?>
            
            <form>
                <h2>Who can view your book?</h2>
                
                <table class="barebones">
                    <tr>
                        <td><input type="radio" name="book_distribution" value="0" <?=($book->getInfo('book_distribution') == '0' ? 'checked="checked"' : '')?> /></td>
                        <td>Only me</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="book_distribution" value="1" <?=($book->getInfo('book_distribution') == '1' ? 'checked="checked"' : '')?> /></td>
                        <td>Only people I tell</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="book_distribution" value="2" <?=($book->getInfo('book_distribution') == '2' ? 'checked="checked"' : '')?> /></td>
                        <td>The whole world</td>
                    </tr>
                </table>
                
                <p>
                    <a href="#" id="distribution-save" class="button orange bigrounded">Save distribution preferences</a>
                </p>
            </form>
        </form>
    </div>
</div>