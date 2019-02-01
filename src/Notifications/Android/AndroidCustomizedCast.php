<?php

namespace Qbhy\Umeng\Notifications\Android;

use Qbhy\Umeng\Notifications\AndroidNotification;

class AndroidCustomizedCast extends AndroidNotification
{
    function __construct()
    {
        parent::__construct();
        $this->data["type"]       = "customizedcast";
        $this->data["alias_type"] = null;
    }

}