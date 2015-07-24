<?php
/**
 * PHP Youtube Downloader Package
 * @author Moniruzzaman Monir <monir.smith@gmail.com>
 */
require 'autoload.php';

$id        = $_POST['id']; 
$validator = new Validator();

if ($validator->validate() == true) {
    $fetcher = new Fetcher();
    $fetcher->setId($_POST['id']);
    $array = $fetcher->getData();
    $get_title = $fetcher->getTitle();
    $file_size = Filesize::getFilesize();

    echo $title = urldecode($get_title);

    ?>
    <!DOCTYPE html>

    <head>
        <title>PHP Youtube Downloader</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <html>

        <body>

            <form method="post" action="downloader.php">
                <p><strong>Enter video ID</strong></p>
                <input type="text" name="id">
               
                <p><strong>Select Video Format</strong></p>
                <select name="process">


                    <?php
                    foreach ($array as $item => $value) {

                        $format = explode(";", $value['type']);

                        echo '<option value="' . $array[$item]['url'] . '&title=' . $get_title . ' ">' . $format[0] . "-" . Converter::megaByte($file_size[$item]) . "mb" . '</option>';
                    }
                    ?>

                </select> 

                <input type="submit" name="submit" value="Submit">

            </form>

            <?php
            if (isset($_POST['submit'])) {
                $get_url = $_POST['process'];

                echo "<a href=\" $get_url \" target=\"_blank\">Download</a>";
            }
        } else {
            echo $validator->getErrors();
        }

        ?>

    </body>
</html>
