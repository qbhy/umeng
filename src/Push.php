<?php
/**
 * User: xiejianlai
 * Date: 2019-01-31
 * Time: 22:57
 */

namespace Qbhy\Umeng;

use Hanson\Foundation\AbstractAPI;

class Push extends AbstractAPI
{
    protected $app;

    public function __construct(Umeng $umeng)
    {
        $this->app = $umeng;
    }

    const HOST = 'https://msgapi.umeng.com/api/send';

    /**
     * @param string $type
     * @param string $displayType
     * @param array  $params
     * @param array  $extra
     *
     * @return array
     */
    public function request(string $type, string $displayType, array $body, array $extra = [], $deviceTokens = null)
    {
        $data = [
            'type'            => $type,
            'timestamp'       => time(),
            'appkey'          => $this->app->getAppKey(),
            'device_tokens'   => $deviceTokens, // 待处理
            'production_mode' => $this->app->isDebug(),
            'description'     => $this->app->getDescription(),
            'payload'         => [
                'display_type' => $displayType,
                'body'         => $body,
                'extra'        => $extra,
            ],
        ];

        // request
        $postBody = json_encode($data);

        //加密
        $sign = md5('POST' . Push::HOST . $postBody . $this->app->getMasterSecret());

        return @json_decode(
            $this->getHttp()
                 ->request('POST', Push::HOST, ['json' => $data, 'query' => compact('sign')])
                 ->getBody()
                 ->__toString(),
            true);
    }


}