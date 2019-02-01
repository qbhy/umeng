<?php

namespace Qbhy\Umeng\Notifications;

abstract class UmengNotification
{
    // The host
    protected $host = "http://msg.umeng.com";

    // The upload path
    protected $uploadPath = "/upload";

    // The post path
    protected $postPath = "/api/send";

    /*
     * $data is designed to construct the json string for POST request. Note:
     * 1)The key/value pairs in comments are optional.
     * 2)The value for key 'payload' is set in the subclass(AndroidNotification or IOSNotification), as their payload structures are different.
     */
    protected $data = [
        "type"            => null,
        //"device_tokens"  => "xx",
        //"alias"          => "xx",
        //"file_id"        => "xx",
        //"filter"         => "xx",
        //"policy"         => array("start_time" => "xx", "expire_time" => "xx", "max_send_num" => "xx"),
        "production_mode" => "true",
        //"feedback"       => "xx",
        //"description"    => "xx",
        //"thirdparty_id"  => "xx"
    ];

    protected $DATA_KEYS = ["appkey", "timestamp", "type", "device_tokens", "alias", "alias_type", "file_id", "filter", "production_mode", "feedback", "description", "thirdparty_id"];
    protected $POLICY_KEYS = ["start_time", "expire_time", "max_send_num"];

    abstract public function setPredefinedKeyValue(string $key, $value);

    function isComplete()
    {
    }

        /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

}