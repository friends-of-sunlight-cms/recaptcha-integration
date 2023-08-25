<?php

use Sunlight\User;

return function (array $args): void {
    if (User::isLoggedIn()) {
        return;
    }

    $this->enableEventGroup('recaptcha');

    $config = $this->getConfig();
    $content = (!$config['use_recaptcha_v3']
        // reCaptcha v2
        ? "<div class='g-recaptcha' data-sitekey='" . $config['site_key'] . "'></div>"
        // reCaptcha v3
        : "<span class='hint'>This site is protected by reCAPTCHA and the Google <a href='https://policies.google.com/privacy' target='_blank'>Privacy Policy</a> and <a href='https://policies.google.com/terms' target='_blank'>Terms of Service</a> apply.</span>"
    );

    $args['value'] = [
        'label' => _lang('captcha.input'),
        'content' => $content,
        'top' => true,
        'class' => ''
    ];
};
