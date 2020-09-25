<?php

    header('Content-Type:text/plain; charset=utf-8');

    $token = $_POST['token'];
    $name = $_POST['name'];
    $msg = $_POST['msg'];

    echo $token;

    $tokens = array(
        $token
    );

    $data = array("name"=>$name, "msg"=>$msg);

    // title과 body 즉 알림 상단에 나오는 글씨 설정하는 방법
    $notification = array("title"=>$name, "body"=>$msg);

    //FCM 서버에 보낼 데이터 2종류를 다시 하나의 연관 배열로
    $postData = array(
        'registration_ids'=> $tokens,
        'notification'=> $notification,
        'data'=> $data
    );
    //FCM 서버는 본인에게 보낼 데이터를 JSON으로 보내도록 되어있음
    //위에서 만든 연관베열을 json으로 변환
    $postDataJson = json_encode($postData);

    //위 데이터를 FCM에 보내려면 
    //FCM 서버에 접속하는 접속 서버 KEY가 필요
    //https://console.firebase.google.com/project/cucumber-app/settings/cloudmessaging/android:com.jasonoh.cucumber_app_v1
    // 서버 키
    //이 서버 키를 Body에 보낸느 것이 아니라 Header 정보로 보냄.
    //FCM 서버로 요청할 때 헤더정보 설정 - 배열로
    //1. Web Server Key : FCM에 접속할 수 있는 권한 키 (프로젝트 콘솔에서 확인)
    //2. 내가 보내는 데이터가 json형식 이라고 표시
    $serverkey = 'AAAAW35eZFQ:APA91bE_XMb9-lQNc2lZzlGav-R18sT6WYSlRQX1VJZaN8k40cIEpraWbjEK6Pt87KbnKkc4mjEQ2gDVAQV8WxRS6QFGXJt5xwPy0fQND9felHtZrGvcksOZe4MoJy5tQ6P8CjsYi7Wk';
    $headers = array(
        'Authorization:key=' . $serverkey,
        'Content-Type:application/json'
    );

    //curl을 통해 전송작업

    //CURL 초기화
    $ch = curl_init();

    //옵션들 설정
    //1. 요청 URL
    curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send"); //정해진 주소!!

    //2. 요청 결과 돌려받겠다는 설정
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //FCM에서는 실패시 false만 날라온다.

    //3. 위에서 설정했던 header 정보 설정
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    //4. POST METHOD 로 보낼 JSON 데이터를 설정
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);

    //실행
    $result = curl_exec($ch);
    //echo "aaa" . $result;
    if($result === false) {
        echo "실패 : " . curl_error($ch);
    }

    //close
    curl_close($ch);

?>