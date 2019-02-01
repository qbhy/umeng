<?php

namespace Qbhy\Umeng\Notifications\Android;

use Qbhy\Umeng\Notifications\AndroidNotification;

class AndroidUnicast extends AndroidNotification
{
    function __construct()
    {
        parent::__construct();
        $this->data["type"]          = "unicast";
        $this->data["device_tokens"] = null;
    }

}