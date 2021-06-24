<?php


/**
 * Class Skyroom
 * Author = Sajjad Sarookhani
 */

class Skyroom
{
    protected string $api;
    private string $baseUrl;

    public function __construct($api, $url = 'https://www.skyroom.online/skyroom/api/')
    {
        $this->api = $api;
        $this->baseUrl = $url . $api;
    }

    private function curl($data)
    {
        $ch = curl_init($this->baseUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $ex = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if (!empty($error)) {
            return $error;
        } else {
            return $ex;
        }
    }

    public function getServices()
    {
        $data = ["action" => "getServices"];
        return json_decode($this->curl($data), true);
    }

    public function getRooms()
    {
        $data = ["action" => "getRooms"];
        return json_decode($this->curl($data), true);
    }

    public function countRooms()
    {
        $data = ["action" => "countRooms"];
        return json_decode($this->curl($data), true);
    }

    public function getRoomWithID(int $id)
    {
        $data = ["action" => "getRoom", "params" => array(
            "room_id" => $id,
        )];
        return json_decode($this->curl($data), true);
    }

    public function getRoomWithNAME(string $name)
    {
        $data = ["action" => "getRoom", "params" => array(
            "name" => $name,
        )];
        return json_decode($this->curl($data), true);
    }

    public function getRoomUrl($id, $lang = 'fa')
    {
        $data = ["action" => "getRoomUrl", "params" => array(
            "room_id" => $id,
            "language" => $lang,
        )];
        return json_decode($this->curl($data), true);
    }

    public function createRoom(string $name, string $title, int $max_users, bool $guestLogin = true, bool $op_login_first = true)
    {
        $data = [
            "action" => "createRoom",
            "params" => [
                "name" => $name,
                "title" => $title,
                "guest_login" => $guestLogin,
                "op_login_first" => $op_login_first,
                "max_users" => $max_users
            ]
        ];

        return json_decode($this->curl($data), true);
    }

}