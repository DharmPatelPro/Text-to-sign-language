<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
    <style>
        #in input {
            border-radius: 5px;
            border: 2px solid;
        }

        #btn {
            background-color: red;
            color: white;
            height: 30px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <form action="TextToSign.php" method="POST">
        <center>
            <div>
                <div id="in">
                    <h1>Enter Text:</h1>
                    <input type="text" required="required" name="txt" />
                </div>
                <div>
                    <input type="radio" name="select_language" value="ASL">
                    <label for="html">American Sign Language</label><br>
                    <input type="radio" name="select_language" value="ISL" checked>
                    <label for="css">Indian sign language</label><br>
                </div>
                <br />
                <input type="submit" name="btnSubmit" value="Convert to Sign" id="btn" />
            </div>
        </center>
        <br />
        <hr />

        <?php
        if (isset($_POST['btnSubmit'])) {
            $con = mysqli_connect("localhost", "root", "", "dharmdatabase", 3306);
            if ($con) {

                $arr = str_split($_POST['txt']);
                foreach ($arr as $char) {
                    $sel = "select * from language where input='" . $char . "'";
                    $res = mysqli_query($con, $sel);
                    $row = mysqli_num_rows($res);

                    if ($row == 0) {
                        echo "<script>alert('Record no Found');</script>";
                    } else {
                        $col = mysqli_num_fields($res);

        ?>



                        <?php

                        for ($i = 0; $i < $row; $i++) {

                            $f = mysqli_fetch_row($res);
                            for ($j = 0; $j < $col; $j++) {

                                if (mysqli_fetch_field_direct($res, $j)->name == "img") { ?>
                                    <img src="Images/<?php echo $_POST['select_language'] ?>/<?php echo $f[$j]; ?>" width="150px" height="150px" />
        <?php } else {
                                    echo "<font size='15'>" . $f[$j] . "</font>";
                                }
                            }
                        }
                    }
                }
            } else {
                echo "<script>alert('Connection Error');</script>";
            }
        }
        ?>

    </form>

</body>

</html>