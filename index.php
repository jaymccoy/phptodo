<?php include_once 'header.php'; ?>
<?php
    $selected_list=$_SESSION['selected_list'];
    if ($_GET['list'] && '' !== $_GET['list']) {
        $selected_list=$_GET['list'];
        $_SESSION['selected_list']=$selected_list;
    }//end if
?>

    <div class="btn-group">
        <button type="button" class="btn btn-default disabled">About</button>
        <button type="button" class="btn btn-default disabled">Settings</button>
        <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
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
                                echo "<a class=\"dropdown-item\" href=\"?list=$file_name\">$file_name <span class=\"badge badge-primary badge-pill\">$item_count</span></a>";
                            }//end if
                        }//end while
                    }//end if
                ?>
            </div>
        </div>
<!--        TODO: make menu able to toggle left and right-->
<!--        <button type="button" class="btn btn-primary">Move right</button>-->
    </div>
    <h4>&nbsp;<?php echo $selected_list; ?></h4>


    <div id="accordion">
<?php
    //TODO: fix error when no list is selected yet
    if ('' !== $selected_list) {
        $item_list = json_decode(file_get_contents("./lists/$selected_list.json"));
        foreach ($item_list as $key => $item) {
            ?>
            <div class="card">
                <div class="card-header" data-toggle="collapse" href="#collapse<?php echo $key; ?>">
                    <a class="collapsed card-link" data-toggle="collapse" href="#collapse<?php echo $key; ?>">
                        <?php echo $item->text; ?>
                    </a>
                </div>
                <div id="collapse<?php echo $key; ?>" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                        Created by <i><?php echo $item->author; ?></i> on <i><?php echo $item->date_created; ?></i>.
                    </div>
                </div>
            </div>
            <?php
        }//end foreach
    }//end if
?>



        <div class="card">
            <div id="collapseAdd" class="" data-parent="#accordion">
                <div class="card-body">
                    <form class="form-inline" name="add_list_item">
                        <input type="hidden" name="list" value="<?php echo $selected_list; ?>">
                        <label for="item_text" class="mb-2 mr-sm-2">Add new item:</label>
                        <input type="text" class="form-control mb-2 mr-sm-2" id="item_text" placeholder="Enter list item" name="item_text">
                        <button type="submit" class="btn btn-primary mb-2">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



<?php include_once 'footer.php'; ?>