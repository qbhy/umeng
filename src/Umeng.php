<?php
/**
 * User: qbhy
 * Date: 2019-01-31
 * Time: 22:56
 */

namespace Qbhy\Umeng;

use Hanson\Foundation\Foundation;

/**
 * Class Umeng
 *
 * @property Push $push
 * @package Qbhy\Umeng
 */
class Umeng extends Foundation
{
    protected $providers = [
        ServiceProvider::class,
    ];


    public function getAppKey()
    {
        return $this->getConfig('app_key');
    }

    public function getMsgSecret()
    {
        return $this->getConfig('msg_secret');
    }

    public function getMasterSecret()
    {
        return $this->getConfig('master_secret');
    }

    public function getDescription()
    {
        return $this->getConfig('description');
    }

    public function isDebug()
    {
        return $this->getConfig('debug');
    }
}