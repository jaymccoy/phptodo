<?php include_once("header.php"); ?>

    <div class="btn-group">
        <button type="button" class="btn btn-primary">About</button>
        <button type="button" class="btn btn-primary">Settings</button>
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                Lists
            </button>
            <div class="dropdown-menu">
                <?php
                    if ($handle = opendir('./lists')) {
                        while (false !== ($entry = readdir($handle))) {
                            if ($entry !== '.' && $entry !== '..') {
                                $file_name = pathinfo($entry, PATHINFO_FILENAME);
                                $line_count=0;
                                $fh=fopen('./lists'.DIRECTORY_SEPARATOR.$entry, 'rb');
                                while (!feof($fh)) {
                                    $line = fgets($fh);
                                    $line_count++;
                                }//end while
                                //TODO: look into a better way to count the number of items in a file
                                $item_count=floor(($line_count-2)/6);
                                echo "<a class=\"dropdown-item\" href=\"#\">$file_name <span class=\"badge badge-primary badge-pill\">$item_count</span></a>";
                            }//end if
                        }//end while
                    }//end if
                ?>
            </div>
        </div>
    </div>


<?php include_once("footer.php"); ?>