<?php

use Sunlight\User;

/**
 * Add the necessary javascript to the form
 * Used in reCaptcha v3
 */
return function (array $args): void {
    $config = $this->getConfig();

    if (User::isLoggedIn() || !$config['use_recaptcha_v3']) {
        return;
    }

    $args['options']['form_prepend'] = trim(preg_replace('/\s+/', ' ', "<script>
        grecaptcha.ready(function() {
            grecaptcha.execute('" . $config['site_key'] . "', {action: '" . $args['options']['name'] . "'})
                .then(function(token) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'g-recaptcha-response',
                        value: token
                    }).prependTo('." . $args['options']['class'] . "')
            });
        });</script>"));
};
