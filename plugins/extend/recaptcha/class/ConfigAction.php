<?php

namespace SunlightExtend\Recaptcha;

use Sunlight\Plugin\Action\ConfigAction as BaseConfigAction;
use Sunlight\Util\ConfigurationFile;
use Sunlight\Util\Form;

class ConfigAction extends BaseConfigAction
{
    protected function getFields(): array
    {
        $config = $this->plugin->getConfig();

        return [
            'site_key' => [
                'label' => _lang('recaptcha.site_key'),
                'input' => '<input type="text" name="config[site_key]" value="' . Form::restorePostValue('site_key', $config['site_key'], false) . '">',
                'type' => 'text',
            ],
            'secret_key' => [
                'label' => _lang('recaptcha.secret_key'),
                'input' => '<input type="text" name="config[secret_key]" value="' . Form::restorePostValue('secret_key', $config['secret_key'], false) . '">',
                'type' => 'text',
            ],
            'use_curl' => [
                'label' => _lang('recaptcha.use_curl'),
                'input' => '<input type="checkbox" name="config[use_curl]" value="1"' . Form::activateCheckbox($config['use_curl']) . '>',
                'type' => 'checkbox'
            ],
            'use_recaptcha_v3' => [
                'label' => _lang('recaptcha.use_recaptcha_v3'),
                'input' => '<input type="checkbox" name="config[use_recaptcha_v3]" value="1"' . Form::activateCheckbox($config['use_recaptcha_v3']) . '>',
                'type' => 'checkbox'
            ],
            'score_treshold' => [
                'label' => _lang('recaptcha.score_treshold'),
                'input' => '<input type="number" name="config[score_treshold]" min="0" max="1" step="0.1" value="' . Form::restorePostValue('score_treshold', $config['score_treshold'], false) . '" class="inputsmall">',
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
