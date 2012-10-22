<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Language" content="en-gb" />
    <title>WebBook</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    
    <!-- Styles //-->
    <link rel="stylesheet" type="text/css" href="/public/styles/bones.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/public/styles/interface.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/public/styles/book.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/public/styles/custom/<?=$book->getInfo('book_id')?>.css?" media="screen" id="custom-styles" />
    <!-- Individual pages //-->
    <link rel="stylesheet" type="text/css" href="/public/styles/page/target.css" media="screen" />
    
    <!-- Scripts //-->
    <!-- Variables //-->
    <script type="text/javascript">
    var bookId     = <?=(int)$book->getInfo('book_id')?>;
    var page       = null;
    var readonly   = false;
    var password   = '';
    var snapshotId = 0;
    </script>
    <!-- jQuery //-->
    <!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>//-->
    <script type="text/javascript" src="/public/scripts/jquery.js"></script>
    <!-- Common //-->
    <script type="text/javascript" src="/public/scripts/common.js"></script>
    <script type="text/javascript" src="/public/scripts/init.js"></script>
    <!-- Book //-->
    <script type="text/javascript" src="/public/scripts/book/section.js"></script>
    <script type="text/javascript" src="/public/scripts/book/chapter.js"></script>
    <script type="text/javascript" src="/public/scripts/book/title.js"></script>
    <script type="text/javascript" src="/public/scripts/book/wysiwyg.js"></script>
    <script type="text/javascript" src="/public/scripts/book/outline.js"></script>
    <!-- Settings //-->
    <script type="text/javascript" src="/public/scripts/settings/settings.js"></script>
    <!-- Snapshot //-->
    <script type="text/javascript" src="/public/scripts/snapshot/snapshot.js"></script>
    <!-- Target //-->
    <script type="text/javascript" src="/public/scripts/target/target.js"></script>
    <!-- Distribution //-->
    <script type="text/javascript" src="/public/scripts/distribution/distribution.js"></script>
    <!-- Plugins //-->
    <script type="text/javascript" src="/public/scripts/plugin/php.js"></script>
    <script type="text/javascript" src="/public/scripts/plugin/fullscreen.js"></script>
    <script type="text/javascript" src="/public/scripts/plugin/color.js"></script>
    <!-- Google things //-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">google.load('visualization', '1', {'packages':['annotatedtimeline']});</script>
</head>
<body>
    <div id="navigation">
        <p id="webBook"><span>web</span>Book</p>
        
        <ul>
            <li><a href="#book" rel="book" class="icon icon-book">My Book</a></li>
            <li><a href="#character" rel="character" class="icon icon-character">Characters</a></li>
            <li><a href="#location" rel="location" class="icon icon-location">Locations</a></li>
            <li><a href="#scrapbook" rel="scrapbook" class="icon icon-scrapbook">Scrapbook</a></li>
            <li><a href="#tag" rel="tag" class="icon icon-tag">Tags</a></li>
            <li><a href="#todo" rel="todo" class="icon icon-todo">Todo</a></li>
            <li><a href="#timeline" rel="timeline" class="icon icon-timeline">Timeline</a></li>
            <li><a href="#snapshot" rel="snapshot" class="icon icon-snapshot">Snapshots</a></li>
            <li><a href="#chapter" rel="chapter" class="icon icon-chapter">Chapters</a></li>
            <li><a href="#comment" rel="comment" class="icon icon-comment">Comments</a></li>
            <li><a href="#distribution" rel="distribution" class="icon icon-private">Distribution</a></li>
            <li><a href="#target" rel="target" class="icon icon-target">Targets</a></li>
            <li><a href="#book" rel="fullscreen" class="icon icon-fullscreen">Fullscreen</a></li>
            <li><a href="#settings" rel="settings" class="icon icon-settings">Page setup</a></li>
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
    <div id="content"></div>
    
    <!-- Dynamic elements //-->
    <div id="wysiwyg" class="none">
        <button id="wysiwyg-bold">Bold</button>
        <button id="wysiwyg-italic">Italic</button>
        <button id="wysiwyg-underline">Underline</button>
        <button id="wysiwyg-highlight">Highlight</button>
        <button id="wysiwyg-unformat">Unformat</button>
    </div>
    
    <div id="status-indicator"></div>
</body>
</html>