<?php
/**
 * User: qbhy
 * Date: 2019-01-31
 * Time: 22:57
 */

namespace Qbhy\Umeng;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['push'] = function (Umeng $umeng) {
            return new Push($umeng);
        };



    }

}