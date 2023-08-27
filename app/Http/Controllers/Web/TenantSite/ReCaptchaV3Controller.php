<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;

class ReCaptchaV3Controller extends Controller
{
    /**
     * @return array
     */
    public function validateV3(): array
    {
        $site = session()->get('tenant')->site;
        if ($site->isDomain) {
            recaptcha()->setApiSecretKey($site->recaptcha_secret_key);
        }

        $token = request()->input(config('recaptcha.default_token_parameter_name', 'token'), '');

        return recaptcha()->validate($token);
    }
}
