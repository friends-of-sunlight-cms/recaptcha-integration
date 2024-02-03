<?php

namespace SunlightExtend\Recaptcha;

use Sunlight\Plugin\Action\ConfigAction as BaseConfigAction;
use Sunlight\Util\ConfigurationFile;
use Sunlight\Util\Form;
use Sunlight\Util\Request;

class ConfigAction extends BaseConfigAction
{
    protected function getFields(): array
    {
        $config = $this->plugin->getConfig();

        return [
            'site_key' => [
                'label' => _lang('recaptcha.site_key'),
                'input' => Form::input('text', 'config[site_key]', Request::post('config[site_key]', $config['site_key']), ['class' => 'inputmedium']),
                'type' => 'text',
            ],
            'secret_key' => [
                'label' => _lang('recaptcha.secret_key'),
                'input' => Form::input('text', 'config[secret_key]', Request::post('config[secret_key]', $config['secret_key']), ['class' => 'inputmedium']),
                'type' => 'text',
            ],
            'use_curl' => [
                'label' => _lang('recaptcha.use_curl'),
                'input' => Form::input('checkbox', 'config[use_curl]', '1', ['checked' => Form::loadCheckbox('config', $config['use_curl'], 'use_curl')]),
                'type' => 'checkbox'
            ],
            'use_recaptcha_v3' => [
                'label' => _lang('recaptcha.use_recaptcha_v3'),
                'input' => Form::input('checkbox', 'config[use_recaptcha_v3]', '1', ['checked' => Form::loadCheckbox('config', $config['use_recaptcha_v3'], 'use_recaptcha_v3')]),
                'type' => 'checkbox'
            ],
            'score_treshold' => [
                'label' => _lang('recaptcha.score_treshold'),
                'input' => Form::input('text', 'config[score_treshold]', Request::post('config[score_treshold]', $config['score_treshold']), ['class' => 'inputsmall', 'step' => '0.1', 'min' => '0', 'max' => '1']),
            ],
        ];
    }

    protected function mapSubmittedValue(ConfigurationFile $config, string $key, array $field, $value): ?string
    {
        if ($key === 'score_treshold') {
            $value = max($value, 0);
            $value = min($value, 1);
            $config[$key] = (float)$value;
            return null;
        }
        return parent::mapSubmittedValue($config, $key, $field, $value);
    }
}
