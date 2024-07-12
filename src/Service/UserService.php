<?php
namespace App\Service;
use App\Entity\User;
use App\Repository\UserRepository;
use App\DTO\UserRequestDTO;
use App\Exception\User\UserAlreadyExistsException;
use App\Exception\User\UserNotFoundException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class UserService
{
    
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    public function getUserInfo(int $user_id): array
    {
        $user = $this->userRepository->getUserById($user_id);

        if (!$user) {
            throw new UserNotFoundException("Пользователь не найден");
        }

        $user_data = [];

        $user_data['login'] = $user->getLogin();
        $user_data['email'] = $user->getEmail();
        $user_data['first_name'] = $user->getFirstName();
        $user_data['last_name'] = $user->getLastName();

        return $user_data;

    }

    public function createUser(UserRequestDTO $userRequestDTO): array
    {
        $login = $userRequestDTO->getLogin();
        $email = $userRequestDTO->getEmail();
        $password = $userRequestDTO->getPassword();

        $first_name = $userRequestDTO->getFirstName();
        $last_name = $userRequestDTO->getLastName();

        $first_name = ($first_name) ? $first_name : '';
        $last_name = ($last_name) ? $last_name : '';

        if ($this->userRepository->checkUserByLogin($login)) {
            throw new UserAlreadyExistsException("Пользователь с данным логином уже существует в системе");
        }

        if ($this->userRepository->checkUserByEmail($email)) {
            throw new UserAlreadyExistsException("Пользователь с данным email уже существует в системе");
        }



        $user = new User();
        $hashed_password = $this->passwordHasher->hashPassword($user, $password);

        $user->setLogin($login)
            ->setPassword($hashed_password)
            ->setEmail($email)
            ->setFirstName($first_name)
            ->setLastName($last_name);

        $this->userRepository->saveUser($user);

        return ['message' => 'Пользователь успешно создан', 'success' => true];

    }

    public function changeUser(int $user_id, UserRequestDTO $userRequestDTO): array
    {
        $user = $this->userRepository->getUserById($user_id);

        if (!$user) {
            throw new UserNotFoundException("Пользователь не найден");
        }

        $first_name = $userRequestDTO->getFirstName();
        $last_name = $userRequestDTO->getLastName();

        if ($first_name && $user->getFirstName() !== $first_name) {
            $user->setFirstName($first_name);
        }

        if ($last_name && $user->getLastName() !== $last_name) {
            $user->setLastName($last_name);
        }

        $this->userRepository->saveUser($user);

        return ['message' => 'Пользователь успешно изменен', 'success' => true];

    }


    public function deleteUser(int $user_id): array
    {
        $user = $this->userRepository->getUserById($user_id);

        if (!$user) {
            throw new UserNotFoundException("Пользователь не найден");
        }

        $this->userRepository->removeUser($user);

        return ['message' => 'Пользователь успешно удален', 'success' => true];

    }


}