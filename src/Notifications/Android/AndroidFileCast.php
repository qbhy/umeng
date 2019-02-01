<?php

namespace Qbhy\Umeng\Notifications\Android;

use Qbhy\Umeng\Notifications\AndroidNotification;

class AndroidFileCast extends AndroidNotification
{
    function __construct()
    {
        parent::__construct();
        $this->data["type"]    = "filecast";
        $this->data["file_id"] = null;
    }

}