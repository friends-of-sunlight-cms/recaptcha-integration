<?php

use ReCaptcha\ReCaptcha;
use ReCaptcha\RequestMethod\CurlPost;
use ReCaptcha\RequestMethod\SocketPost;
use Sunlight\Core;
use Sunlight\User;

return function (array $args) {
    if (User::isLoggedIn()) {
        return;
    }

    if (empty($_POST['g-recaptcha-response'])) {
        $args['value'] = false;
        return;
    }

    $config = $this->getConfig();
    $requestMethod = null;
    if (!ini_get('allow_url_fopen')) {
        if ($config['use_curl']) {
            $requestMethod = new CurlPost();
        } else {
            $requestMethod = new SocketPost();
        }
    }
    $recaptcha = new ReCaptcha($config['secret_key'], $requestMethod);
    $recaptcha->setExpectedHostname(Core::getBaseUrl()->getHost());
    // reCaptcha v3
    if ($config['use_recaptcha_v3']) {
        $recaptcha->setScoreThreshold($config['score_treshold']);
    }

    $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
    $args['value'] = $resp->isSuccess();
};
