<?php

//Login depende do user
loadModel('User');
class Login extends Model
{

    public function validate()
    {
        $errors = [];

        if (!$this->email) {
            $errors['email'] = 'Informe o seu e-mail';
        }
        if (!$this->password) {
            $errors['password'] = 'Insira o seu e-mail.';
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }

    public function checkLogin()
    {
        $this->validate();
        $user = User::getOne(['email' => $this->email]);

        if ($user) {
            if ($user->end_date) {
                throw new AppException('Utilizador já não pertence á empresa.');
            }
            if (password_verify($this->password, $user->password)) {
                return $user;
            }
        }
        throw new AppException('Utilizador e password inválidos.');
    }
}
