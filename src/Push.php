<?php
/**
 * User: xiejianlai
 * Date: 2019-01-31
 * Time: 22:57
 */

namespace Qbhy\Umeng;

use Hanson\Foundation\AbstractAPI;
use Qbhy\Umeng\Notifications\Android\AndroidBroadcast;
use Qbhy\Umeng\Notifications\Android\AndroidCustomizedCast;
use Qbhy\Umeng\Notifications\Android\AndroidFileCast;
use Qbhy\Umeng\Notifications\Android\AndroidGroupCast;
use Qbhy\Umeng\Notifications\Android\AndroidUnicast;
use Qbhy\Umeng\Notifications\UmengNotification;

class Push extends AbstractAPI
{

    const AFTER_OPEN_GO_APP = 'go_app';

    protected $app;

    public function __construct(Umeng $umeng)
    {
        $this->app = $umeng;
    }

    const POST_URL = 'https://msgapi.umeng.com/api/send';
    const UPLOAD_URL = 'https://msgapi.umeng.com/upload';

    /**
     * @param UmengNotification|array $notification
     * @param string                  $url
     *
     * @return array
     */
    public function send(string $url, $notification)
    {
        $data = array_merge([
            'timestamp'       => time(),
            'appkey'          => $this->app->getAppKey(),
            'production_mode' => $this->app->isDebug() ? 'false' : 'true',
            'description'     => $this->app->getDescription(),
        ], $notification instanceof UmengNotification ? $notification->getData() : $notification);

        // request
        $postBody = json_encode($data);

        //加密
        $sign = md5('POST' . $url . $postBody . $this->app->getMasterSecret());

        return @json_decode(
            $this->getHttp()
                 ->request('POST', $url, ['json' => $data, 'query' => compact('sign')])
                 ->getBody()
                 ->__toString(),
            true);
    }

    public function sendAndroidBroadcast(string $ticker, string $title, string $text, string $afterOpen = Push::AFTER_OPEN_GO_APP, array $extra = [])
    {
        $broadcast = new AndroidBroadcast();
        $broadcast->setPredefinedKeyValue("ticker", $ticker);
        $broadcast->setPredefinedKeyValue("title", $title);
        $broadcast->setPredefinedKeyValue("text", $text);
        $broadcast->setPredefinedKeyValue("after_open", $afterOpen);
        $broadcast->setExtraField($extra);

        return $this->send(Push::POST_URL, $broadcast);
    }

    /**
     * @param array|string $deviceTokens
     * @param string       $ticker
     * @param string       $title
     * @param string       $text
     * @param string       $afterOpen
     * @param array        $extra
     *
     * @return array
     */
    public function sendAndroidUnicast($deviceTokens, string $ticker, string $title, string $text, string $afterOpen = Push::AFTER_OPEN_GO_APP, array $extra = [])
    {
        $unicast = new AndroidUnicast();
        $unicast->setPredefinedKeyValue("device_tokens", $deviceTokens);
        $unicast->setPredefinedKeyValue("ticker", $ticker);
        $unicast->setPredefinedKeyValue("title", $title);
        $unicast->setPredefinedKeyValue("text", $text);
        $unicast->setPredefinedKeyValue("after_open", $afterOpen);
        $unicast->setExtraField($extra);

        return $this->send(Push::POST_URL, $unicast);
    }

    /**
     * @param string $ticker
     * @param string $title
     * @param string $text
     * @param string $afterOpen
     * @param array  $extra
     *
     * @return array
     */
    public function sendAndroidFileCast(string $ticker, string $title, string $text, string $afterOpen = Push::AFTER_OPEN_GO_APP, array $extra = [])
    {
        $cast = new AndroidFileCast();
        $cast->setPredefinedKeyValue("ticker", $ticker);
        $cast->setPredefinedKeyValue("title", $title);
        $cast->setPredefinedKeyValue("text", $text);
        $cast->setPredefinedKeyValue("after_open", $afterOpen);
        $cast->setExtraField($extra);

        return $this->send(Push::POST_URL, $cast);
    }

    /**
     * @param array  $filter
     * @param string $ticker
     * @param string $title
     * @param string $text
     * @param string $afterOpen
     * @param array  $extra
     *
     * @return array
     */
    public function sendAndroidGroupCast(array $filter, string $ticker, string $title, string $text, string $afterOpen = Push::AFTER_OPEN_GO_APP, array $extra = [])
    {
        $cast = new AndroidGroupCast();
        $cast->setPredefinedKeyValue("filter", $filter);
        $cast->setPredefinedKeyValue("ticker", $ticker);
        $cast->setPredefinedKeyValue("title", $title);
        $cast->setPredefinedKeyValue("text", $text);
        $cast->setPredefinedKeyValue("after_open", $afterOpen);
        $cast->setExtraField($extra);

        return $this->send(Push::POST_URL, $cast);
    }

    /**
     * @param string $alias
     * @param string $aliasType
     * @param string $ticker
     * @param string $title
     * @param string $text
     * @param string $afterOpen
     * @param array  $extra
     *
     * @return array
     */
    public function sendAndroidCustomizedCast(string $alias, string $aliasType, string $ticker, string $title, string $text, string $afterOpen = Push::AFTER_OPEN_GO_APP, array $extra = [])
    {
        $cast = new AndroidCustomizedCast();
        $cast->setPredefinedKeyValue("alias", $alias);
        $cast->setPredefinedKeyValue("alias_type", $aliasType);
        $cast->setPredefinedKeyValue("ticker", $ticker);
        $cast->setPredefinedKeyValue("title", $title);
        $cast->setPredefinedKeyValue("text", $text);
        $cast->setPredefinedKeyValue("after_open", $afterOpen);
        $cast->setExtraField($extra);

        return $this->send(Push::POST_URL, $cast);
    }

    /**
     * @param string $content
     *
     * @return array
     */
    public function uploadContent(string $content)
    {
        return $this->send(Push::UPLOAD_URL, compact('content'));
    }

}