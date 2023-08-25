<?php

use Sunlight\Core;
use Sunlight\User;

return function (array $args) {
    if (User::isLoggedIn()) {
        return;
    }

    $config = $this->getConfig();
    if (!$config['use_recaptcha_v3']) {
        // reCaptcha v2
        $args['js_before'] .= "\n<script type='text/javascript' src='https://www.recaptcha.net/recaptcha/api.js?hl=" . Core::$lang . "'></script>";
    } else {
        // reCaptcha v3
        $args['js_before'] .= "\n<script src='https://www.recaptcha.net/recaptcha/api.js?render=" . $config['site_key'] . "'></script>";
        // Hiding the badge is allowed, more information: DEC2018 https://developers.google.com/recaptcha/docs/faq
        // https://developers.google.com/recaptcha/docs/faq#id-like-to-hide-the-recaptcha-badge.-what-is-allowed
        $args['css_after'] .= "<style>.grecaptcha-badge{display: none;}</style>";
    }
};
