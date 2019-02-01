<?php

namespace Qbhy\Umeng\Notifications;

use InvalidArgumentException;

abstract class IOSNotification extends UmengNotification
{
    // The array for payload, please see API doc for more information
    protected $iosPayload = array(
        "aps" => array(
            "alert" => NULL
            //"badge"				=>  xx,
            //"sound"				=>	"xx",
            //"content-available"	=>	xx
        )
        //"key1"	=>	"value1",
        //"key2"	=>	"value2"
    );

    // Keys can be set in the aps level
    protected $APS_KEYS = array("alert", "badge", "sound", "content-available");

    function __construct()
    {
        $this->data["payload"] = $this->iosPayload;
    }

    function setPredefinedKeyValue(string $key, $value)
    {
        if (in_array($key, $this->DATA_KEYS)) {
            $this->data[$key] = $value;
        } else if (in_array($key, $this->APS_KEYS)) {
            $this->data["payload"]["aps"][$key] = $value;
        } else if (in_array($key, $this->POLICY_KEYS)) {
            $this->data["policy"][$key] = $value;
        } else {
            if ($key == "payload" || $key == "policy" || $key == "aps") {
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
    function setCustomizedField(array $extra)
    {
        $this->data['payload'] = array_merge($this->data['payload'], $extra);
        return $this;
    }
}