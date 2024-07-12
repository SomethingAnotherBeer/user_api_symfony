<?php
namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequestDTO
{

    #[Assert\NotNull(message: 'Логин пользователя не может быть null', groups: ['login'])]
    #[Assert\NotBlank(message: 'Логин пользователя не может быть пустым', groups: ['login'])]
    private ?string $login = null;

    #[Assert\NotNull(message: 'Пароль пользователя не может быть null', groups: ['password'])]
    #[Assert\NotBlank(message: 'Пароль пользователя не может быть пустым', groups: ['password'])]
    #[Assert\Length(
        min: 8,
        minMessage: 'Минимальная длина пароля должна составлять 8 символов',
        groups: ['password']
    )]
    private ?string $password = null;

    #[Assert\NotNull(message: 'email пользователя не может быть null', groups: ['email'])]
    #[Assert\NotBlank(message: 'email пользователя не может быть пустым', groups: ['email'])]
    private ?string $email = null;

    private ?string $first_name = null;

    private ?string $last_name = null;
    

    public function __construct(array $params)
    {
        $this->login = $params['login'] ?? null;
        $this->password = $params['password'] ?? null;
        $this->email = $params['email'] ?? null;
        $this->first_name = $params['first_name'] ?? null;
        $this->last_name = $params['last_name'] ?? null;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }


    public function getLastName(): ?string
    {
        return $this->last_name;
    }

}