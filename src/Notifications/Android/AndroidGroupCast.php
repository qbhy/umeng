<?php

namespace Qbhy\Umeng\Notifications\Android;

use Qbhy\Umeng\Notifications\AndroidNotification;

class AndroidGroupCast extends AndroidNotification
{
    function __construct()
    {
        parent::__construct();
        $this->data["type"]   = "groupcast";
        $this->data["filter"] = null;
    }
}