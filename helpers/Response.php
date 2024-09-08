<?php
class Response {
    public static function send($status, $data) {
        header("HTTP/1.1 " . $status);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data);
        exit();
    }
}
