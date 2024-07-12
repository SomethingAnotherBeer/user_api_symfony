<?php
namespace App\Factory;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\DTO\UserRequestDTO;

use App\Exception\Validation\ValidationException;

class DTOFactory
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }


    public function makeUserCreateDTO(array $params): UserRequestDTO
    {
        $data = [];
        $groups = ['login', 'password', 'email'];

        if (array_key_exists('login', $params)) {
            $data['login'] = $params['login'];
        }

        if (array_key_exists('password', $params)) {
            $data['password'] = $params['password'];
        }

        if (array_key_exists('email', $params)) {
            $data['email'] = $params['email'];
        }

        if (array_key_exists('first_name', $params)) {
            $data['first_name'] = $params['first_name'];
        }

        if (array_key_exists('last_name', $params)) {
            $data['last_name'] = $params['last_name'];
        }

        $userRequestDTO = new UserRequestDTO($data);

        $errors = $this->validator->validate($userRequestDTO, null, $groups);

        if (count($errors) > 0) {
            throw new ValidationException((string)$errors);
        }

        return $userRequestDTO;

    }


    public function makeUserChangeDTO(array $params): UserRequestDTO
    {
        $data = [];
        $groups = [];

        if (array_key_exists('login', $params)) {
            $data['login'] = $params['login'];
            $groups[] = 'login';
        }

        if (array_key_exists('password', $params)) {
            $data['password'] = $params['password'];
            $groups[] = 'password';
        }

        if (array_key_exists('email', $params)) {
            $data['email'] = $params['email'];
            $groups[] = 'email';
        }

        if (array_key_exists('first_name', $params)) {
            $data['first_name'] = $params['first_name'];
        }

        if (array_key_exists('last_name', $params)) {
            $data['last_name'] = $params['last_name'];
        }

        $userRequestDTO = new UserRequestDTO($data);

        $errors = $this->validator->validate($userRequestDTO, null, $groups);

        if (count($errors) > 0) {
            throw new ValidationException((string)$errors);
        }

        return $userRequestDTO;
    }



}