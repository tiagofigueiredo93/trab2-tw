<?php

//class user vai extender a class model


class User extends Model
{

    protected static $tableName = 'users';
    protected static $columns = [
        'id',
        'name',
        'password',
        'email',
        'start_date',
        'end_date',
        'is_admin',
    ];

    //metodo estático para todos os utilizadores -> Quantos funcionários estão registados no sistema
    public static function getActiveUsersCount()
    {
        //RETORNAR A CONTAGEM DE quantos utilizadores tem a data final is NULL (UTILIZADORES ATIVOS NA EMPRESA)
        return static::getCount(['raw' => 'end_date IS NULL']);
    }

    //Metodo responsável por inserir funcionários
    public function insert()
    {
        $this->validate();
        $this->is_admin = $this->is_admin ? 1 : 0;
        if (!$this->end_date) $this->end_date = null;
        //inserir a password de forma criptografada
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        //retornar o insert do Model
        return parent::insert();
    }
    public function update()
    {
        $this->validate();
        $this->is_admin = $this->is_admin ? 1 : 0;
        if (!$this->end_date) $this->end_date = null;
        //inserir a password de forma criptografada
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        //retornar o update do Model
        
        return parent::update();
    }

    public function validate()
    {
        $errors = [];

        //Não preencher o nome
        if (!$this->name) {
            $errors['name'] = 'Nome é um campo obrigatório!';
        }

        //Não preencher email
        if (!$this->email) {
            $errors['email'] = 'Email é um campo obrigatório!';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email inválido!';
        }

        //start_date
        if (!$this->start_date) {
            $errors['start_date'] = 'Data de admissão do funcionário é um campo obrigatório!';
        } elseif (!DateTime::createFromFormat('Y-m-d', $this->start_date)) {
            $errors['start_date'] = 'Data de admissão deve seguir o padrão dd/mm/aaaa!';
        }

        //end_date
        if ($this->end_date && !DateTime::createFromFormat('Y-m-d', $this->end_date)) {
            $errors['end_date'] = 'Data da saída do funcionário deve seguir o padrão dd/mm/aaaa!';
        }

        //password
        if (!$this->password) {
            $errors['password'] = 'Password é um campo obrigatório!';
        }

        //confirmar password
        if (!$this->confirm_password) {
            $errors['confirm_password'] = 'A confirmação da Password é um campo obrigatório!';
        }

        //verificar se passoword e confirm password são iguais
        if ($this->password && $this->confirm_password & $this->password !== $this->confirm_password) {
            $errors['password'] = 'As passwords não são iguais!';
            $errors['confirm_password'] = 'As passwords não são iguais!';
        }

        if (count($errors) > 0) {
            throw new ValidationException($errors);
        }
    }
}
