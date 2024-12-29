<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use MarcoGermani87\FilamentCaptcha\Forms\Components\CaptchaField;

class LoginPage extends BaseLogin
{

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                CaptchaField::make('captcha'),
                $this->getRememberFormComponent(),
            ]);
    }
}
