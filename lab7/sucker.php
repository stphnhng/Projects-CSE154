<!DOCTYPE html>
<html>
    <head>
        <title>Buy Your Way to a Better Education!</title>
        <link href="https://www.cs.washington.edu/education/courses/cse154/14sp/labs/4/buyagrade.css" type="text/css" rel="stylesheet" />
    </head>

    <body>
        <h1>Thanks, sucker!</h1>

        <p>Your information has been recorded.</p>
        <?php
        	$file_write = "";
        ?>
        <div>
            <strong>Name</strong>
            <?= $_POST["name"]?>
            <?php
            	$file_write = $file_write . $_POST["name"] . ";";
            ?>
        </div>

        <div>
            <strong>Section</strong>
            <?= $_POST["section"] ?>
            <?php
            	$file_write = $file_write . $_POST["section"] . ";";
            ?>
        </div>

        <div>
            <strong>Credit Card Type</strong>
            <?= $_POST["credit_card"]?>
            <?php
            	$file_write = $file_write . $_POST["credit_card"] . ";";
            ?>
        </div>

        <div>
            <strong>Credit Card Number</strong>
            <?= $_POST["number"] ?>
            <?php
            	$file_write = $file_write . $_POST["number"] . "\n";
            ?>
        </div>
        <?php
        	file_put_contents("suckers.txt", $file_write);
        ?>
        <pre>
        	<?=$file_write?>
        </pre>
    </body>
</html>  