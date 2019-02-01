<?php

namespace Qbhy\Umeng\Notifications;

use InvalidArgumentException;

abstract class AndroidNotification extends UmengNotification
{
    // The array for payload, please see API doc for more information
    protected $androidPayload = array(
        "display_type" => "notification",
        "body"         => array(
            "ticker"       => NULL,
            "title"        => NULL,
            "text"         => NULL,
            //"icon"       => "xx",
            //largeIcon    => "xx",
            "play_vibrate" => "true",
            "play_lights"  => "true",
            "play_sound"   => "true",
            "after_open"   => NULL,
            //"url"        => "xx",
            //"activity"   => "xx",
            //custom       => "xx"
        ),
        //"extra"       => array("key1" => "value1", "key2" => "value2")
    );
    // Keys can be set in the payload level
    protected $PAYLOAD_KEYS = array("display_type");

    // Keys can be set in the body level
    protected $BODY_KEYS = array("ticker", "title", "text", "builder_id", "icon", "largeIcon", "img", "play_vibrate", "play_lights", "play_sound", "after_open", "url",
                                 "activity", "custom");

    function __construct()
    {
        $this->data["payload"] = $this->androidPayload;
    }

    function setPredefinedKeyValue(string $key, $value)
    {
        if (in_array($key, $this->DATA_KEYS)) {
            $this->data[$key] = $value;
        } else if (in_array($key, $this->PAYLOAD_KEYS)) {
            $this->data["payload"][$key] = $value;
            if ($key == "display_type" && $value == "message") {
                $this->data["payload"]["body"]["ticker"]     = "";
                $this->data["payload"]["body"]["title"]      = "";
                $this->data["payload"]["body"]["text"]       = "";
                $this->data["payload"]["body"]["after_open"] = "";
                if (!array_key_exists("custom", $this->data["payload"]["body"])) {
                    $this->data["payload"]["body"]["custom"] = NULL;
                }
            }
        } else if (in_array($key, $this->BODY_KEYS)) {
            $this->data["payload"]["body"][$key] = $value;
            if ($key == "after_open" && $value == "go_custom" && !array_key_exists("custom", $this->data["payload"]["body"])) {
                $this->data["payload"]["body"]["custom"] = NULL;
            }
        } else if (in_array($key, $this->POLICY_KEYS)) {
            $this->data["policy"][$key] = $value;
        } else {
            if ($key == "payload" || $key == "body" || $key == "policy" || $key == "extra") {
                throw new InvalidArgumentException("You don't need to set value for ${key} , just set values for the sub keys in it.");
            } else {
                throw new InvalidArgumentException("Unknown key: ${key}");
            }
        }
    }

    /**
     * @param array $extra
     *
     * @return $this
     */
    function setExtraField(array $extra)
    {
        $this->data["payload"]["extra"] = $extra;
        return $this;
    }
}