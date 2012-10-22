<?php
include $_SERVER['DOCUMENT_ROOT'] . '/library/Bootstrap.php';

// Get target
$target = Controller_Target_Resource::generate($book->getInfo('book_id'));
$target = $target->fetch();

// Progress
$progress = Controller_Progress_Resource::generate($book->getInfo('book_id'));
?>

<div class="container secondary">
    <div class="container-inner">
        <form>
            <h1>Targets &amp; Progression</h1>
            
            <h2>Have I reached my target?</h2>
            
            <?php
            // Percent complete
            $percentComplete = ($book->getInfo('book_word_count') / $target['target_word_count']) * 100;
            
            // Less than 0, or more than 100?
            if ($percentComplete < 0) {
                $percentComplete = 0;
            } else if ($percentComplete > 100) {
                $percentComplete = 100;
            }
            ?>
            
            <div class="target-pill-parent">
                <div class="target-pill-background">
                    <div class="target-pill-percent" data-percent="<?=number_format($percentComplete, 2)?>%">
                        <?php if ($percentComplete >= 8) { ?>
                            <span>
                                <?=number_format($percentComplete, 2)?>%
                            </span>
                        <?php } ?>
                    </div>
                </div>
            </div>
            
            <h2>Update my target</h2>
            
            <form>
                <p>
                    I hope to reach
                    <input type="text" id="target_word_count" value="<?=number_format($target['target_word_count'])?>" class="textbox nofloat" style="width:60px" />
                    words by
                    <input type="text" id="target_date" value="<?=Model_Date::getDate($target['target_date'], 'j F Y')?>" class="textbox nofloat" style="width:125px" />
                    <a href="#" id="target-save" class="button orange medium">Update Target</a>
                </p>
            </form>
            
            <h2>My progression</h2>
            
            <div id="wordcount-graph" style="width: 640px; height: 250px; margin-bottom:40px"></div>
            
            <script type="text/javascript">
            $(document).ready(function() {
                // Animate the pill
                $(".target-pill-percent").animate({ width: $(".target-pill-percent").data("percent") }, 1000, function() {
                    $("span", this).fadeIn(1000);
                });
            });
            
            // Chart the book progress
            google.setOnLoadCallback(drawChartWordCount);
            function drawChartWordCount() {
                var data = new google.visualization.DataTable();
                data.addColumn('date',   'Date');
                data.addColumn('number', 'Word Count');
                data.addRows([
                    <?php
                    while ($instance = $progress->fetch()) {
                        echo '[new Date(' . date('Y, n, j', $instance['progress_date']) . '), ' . (int)$instance['progress_word_count'] . '],';
                    }
                    ?>
                ]);
            
                var chart = new google.visualization.AnnotatedTimeLine(document.getElementById('wordcount-graph'));
                chart.draw(data, { displayExactValues: true, displayRangeSelector: false, displayZoomButtons: false, fill: 8 });
            }
            </script>
        </form>
    </div>
</div>