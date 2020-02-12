<?php

function goToAuthUrl(){
    $client_id = "CLIENT_ID";
    $redirect_url = "http://github.test/callback.php";
    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        $url = 'https://github.com/login/oauth/authorize?client_id='. $client_id. "&redirect_url=". $redirect_url . "&scope=user";
        header("location: $url");
    }
}

function fetchData(){
    $client_id = "CLIENT_ID";
    $redirect_url = "http://github.test/callback.php";

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if(isset($_GET['code'])){
            $code = $_GET['code'];
            $post = http_build_query(array(
                'client_id' => $client_id,
                'redirect_url' => $redirect_url,
                'client_secret' => 'CLIENT_SECRET',
                'code' => $code,
            ));
        }
        $access_data = file_get_contents("http://github.com/login/oauth/access_token?" . $post);
        $exploded1 = explode('access_token=' , $access_data);
        $explode2 = explode('&scope=user', $exploded1[1]);
        $access_token = $explode2[0];

        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [ 'User-Agent: PHP']
            ]
        ];


        //fetch user data example (query)
        $url = "https://api.github.com/user?access_token=$access_token";
        $context = stream_context_create($opts);
        $data = file_get_contents($url, false, $context);
        $user_data = json_decode($data, true);
        $username = $user_data['login'];


        //fetch search results example (query)
        $url2 = "https://api.github.com/search/users?q=MarkasCherry";
        $search = file_get_contents($url2, false, $context);
        $search = json_decode($search, true);


        $userPayload = [
            'username' => $username,
            'search' => $search
        ];


        $_SESSION['payload'] = $userPayload;
        $_SESSION['user'] = $username;


        return $userPayload;

    }
    else{
        die('error');
    }
}