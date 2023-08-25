<?php

namespace SunlightExtend\Recaptcha;

use Sunlight\Plugin\Action\ConfigAction as BaseConfigAction;
use Sunlight\Util\ConfigurationFile;
use Sunlight\Util\Form;

class ConfigAction extends BaseConfigAction
{
    protected function getFields(): array
    {
        return [
            'site_key' => [
                'label' => _lang('recaptcha.site_key'),
                'input' => $this->createInput('text', 'site_key'),
                'type' => 'text'
            ],
            'secret_key' => [
                'label' => _lang('recaptcha.secret_key'),
                'input' => $this->createInput('text', 'secret_key'),
                'type' => 'text'
            ],
            'use_curl' => [
                'label' => _lang('recaptcha.use_curl'),
                'input' => $this->createInput('checkbox', 'use_curl'),
                'type' => 'checkbox'
            ],
            'use_recaptcha_v3' => [
                'label' => _lang('recaptcha.use_recaptcha_v3'),
                'input' => $this->createInput('checkbox', 'use_recaptcha_v3'),
                'type' => 'checkbox'
            ],
            'score_treshold' => [
                'label' => _lang('recaptcha.score_treshold'),
                'input' => $this->createInput('number', 'score_treshold', [
                    'step' => 0.1,
                    'min' => 0,
                    'max' => 1
                ]),
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

    private function createInput(string $type, string $name, $attributes = null): string
    {
        $attr = [];
        if (is_array($attributes)) {
            foreach ($attributes as $k => $v) {
                if (is_int($k)) {
                    $attr[] = $v . '=' . $v;
                } else {
                    $attr[] = $k . '=' . $v;
                }
            }
        }
        if ($type === 'checkbox') {
            $result = '<input type="checkbox" name="config[' . $name . ']" value="1"' . implode(' ', $attr) . Form::activateCheckbox($this->plugin->getConfig()->offsetGet($name)) . '>';
        } else {
            $result = '<input type="' . $type . '" name="config[' . $name . ']" value="' . $this->plugin->getConfig()->offsetGet($name) . '"' . implode(' ', $attr) . '>';
        }
        return $result;
    }
}
