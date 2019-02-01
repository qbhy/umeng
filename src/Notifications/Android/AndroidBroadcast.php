<?php

namespace Qbhy\Umeng\Notifications\Android;

use Qbhy\Umeng\Notifications\AndroidNotification;

class AndroidBroadcast extends AndroidNotification
{
    public function __construct()
    {
        parent::__construct();
        $this->data["type"] = "broadcast";
    }
}