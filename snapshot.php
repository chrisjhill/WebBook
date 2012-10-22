<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Language" content="en-gb" />
    <title>webBook</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    
    <!-- Styles //-->
    <link rel="stylesheet" type="text/css" href="/public/styles/bones.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/public/styles/interface.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/public/styles/book.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/public/styles/snapshot.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/public/styles/custom/<?=$book->getInfo('book_id')?>.css" media="screen" />
    
    <!-- Scripts //-->
    <!-- Variables //-->
    <script type="text/javascript">
    var bookId     = <?=(int)$book->getInfo('book_id')?>;
    var page       = null;
    var readonly   = <?=(isset($_GET['snapshot_id']) || isset($_GET['book_distribution']) ? 'true' : 'false')?>;
    var password   = '<?=(isset($_GET['snapshot_id']) ? '' : $_GET['book_distribution'])?>';
    var snapshotId = <?=(isset($_GET['snapshot_id']) ? (int)$_GET['snapshot_id'] : 'null')?>;
    </script>
    <!-- jQuery //-->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    <!-- Common //-->
    <script type="text/javascript" src="/public/scripts/common.js"></script>
    <script type="text/javascript" src="/public/scripts/init.js"></script>
    <!-- Book //-->
    <script type="text/javascript" src="/public/scripts/book/outline.js"></script>
</head>
<body>
    <div id="navigation">
        <ul>
            <li><a href="#book" rel="book" class="icon icon-book">My Book</a></li>
        </ul>
    </div>
    
    <!--
    <div id="outline">
        <ul>
            <li><a href="#cover">Cover page</a></li>
            <li>
                <a href="#chapter-1">Chapter 1</a>
                <ul>
                    <li><a href="#subheader-1">Introduction</a></li>
                    <li><a href="#subheader-2">Middle</a></li>
                    <li><a href="#subheader-3">Finale</a></li>
                </ul>
            </li>
            <li><a href="#chapter-2">Chapter 2</a></li>
            <li><a href="#chapter-3">Chapter 3</a></li>
            <li>
                <a href="#chapter-4">Chapter 4</a>
                <ul>
                    <li><a href="#subheader-4">Book ending</a></li>
                    <li><a href="#subheader-5">Thank yous</a></li>
                </ul>
            </li>
        </ul>
    </div>
    //-->
    
    <!-- The page content //-->
    <div id="snapshot">
        <!--<p id="webBook" class="text-center"><span>web</span>Book</p>//-->
        
        <div id="content"></div>
    </div>
</body>
</html>