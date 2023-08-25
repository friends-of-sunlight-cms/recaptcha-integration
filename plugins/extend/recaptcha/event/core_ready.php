<?php

return function (array $args) {
    $config = $this->getConfig();
    if (!isset($config['site_key'], $config['secret_key'])) {
        return;
    }
    // reCaptcha v2 + v3
    $this->enableEventGroup('recaptcha');

    // reCaptcha v3
    if ($config['use_recaptcha_v3']) {
        $this->enableEventGroup('recaptcha-v3');
    }
};
