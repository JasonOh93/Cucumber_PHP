<?php

    header('Content-Type:text/plain; charset=utf-8');

    $personEmail = $_POST['personEmail'];
    $personName = $_POST['personName'];
    $title = $_POST['title'];
    $location = $_POST['location'];
    $message = $_POST['message'];
    $saveDate = $_POST['date'];
    $weight = $_POST['weight'];


    $allShare = $_POST['allShare'];
    $titleShare = $_POST['titleShare'];
    $pictureShare = $_POST['pictureShare'];
    $locationShare = $_POST['locationShare'];
    $messageShare = $_POST['messageShare'];
    $dateShare = $_POST['dateShare'];
    $weightShare = $_POST['weightShare'];

    $fileName = $_FILES['img']['name'];
    $fileSize = $_FILES['img']['size'];
    $tmpName = $_FILES['img']['tmp_name'];

    $favor = 0; //좋아요 여부 [true, false 대신에 1, 0 저장] -- 나중에 수정해야함!!

    $now = date('Y-m-d_A_h:i:s'); //DB에 Text 일경우 가능

    if($fileName != null) $dstName = "uploads/image/" . $now . $fileName;

    move_uploaded_file($tmpName, $dstName);

    $conn = mysqli_connect( "localhost", "jasonoh93", "aqz135swx213!%", "jasonoh93" );

    mysqli_query($conn, "set names utf8");

    $personEmail = addslashes($personEmail);
    $title = addslashes($title);
    $location = addslashes($location);
    $message = addslashes($message);
    $date = addslashes($date);
    $weight = addslashes($weight);

    //이미지 넣게 해야함!!
    $sql = "INSERT INTO cucumberboard(personName, personEmail, title, location, message, file, saveDate, weight, favor, date, allShare, titleShare, pictureShare, locationShare, messageShare, dateShare, weightShare )
     VALUES('$personName', '$personEmail', '$title', '$location', '$message', '$dstName', '$saveDate', '$weight', '$favor', '$now', '$allShare', '$titleShare', '$pictureShare', '$locationShare', '$messageShare', '$dateShare', '$weightShare')";

    $result = mysqli_query($conn, $sql);

    if($result) echo "게시글이 업로드 되었습니다.";
    else echo "업로드 실패.";

    mysqli_close($conn);

?>