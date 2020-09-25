<?php

    header('Content-Type:application/json; charset=utf-8');

    $data = file_get_contents("php://input");
    $put = json_decode($data, true);

    $no = $put['no'];
    $favor = $put['favor'];

    $conn = mysqli_connect("localhost", "jasonoh93", "aqz135swx213!%", "jasonoh93");

    mysqli_query($conn, "set names utf8");

    if($favor) {
        $sql = "UPDATE cucumberboard SET favor=1 WHERE no=$no";
    } else {
        $sql = "UPDATE cucumberboard SET favor=0 WHERE no=$no";
    }

    mysqli_query($conn, $sql);

    mysqli_close($conn);

    echo $data; // 클라이언트로 부터 받았던 json 데이터를 그대로 리턴

?>