<?php
namespace App\Tests\Controller;

use App\Exception\User\UserAlreadyExistsException;
use App\Exception\User\UserNotFoundException;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testCreateUserSuccessfully(): void
    {
        $client = static::createClient();
        $this->loginUserByLogin($client, 'first_user');

        $params = 
        [
            'login' => 'third_user',
            'password' => '1111111777qqw',
            'email' => 'thirduser@somemail.com',
            'first_name' => 'Dave',
            'second_name' => 'Robertson',
        ];


        $client->request('POST', "/api/users/create", [], [], [], json_encode($params));

        $this->assertResponseIsSuccessful();
    }


    public function testChangeUserSuccessfully(): void
    {
        $client = static::createClient();
        $this->loginUserByLogin($client, 'first_user');

        $userRepository = static::getContainer()->get(UserRepository::class);
        $target_user_id = $userRepository->findOneBy(['login' => 'third_user'])->getId();
        $target_user_id = (string)$target_user_id;

        $params = 
        [
            'first_name' => 'Chris',
            'second_name' => 'Redfield',
        ];

        $client->request('PATCH', "/api/users/{$target_user_id}/change", [], [], [], json_encode($params));

        $this->assertResponseIsSuccessful();
    }


    public function testDeleteUserSuccesfully(): void
    {
        $client = static::createClient();
        $this->loginUserByLogin($client, 'first_user');

        $userRepository = static::getContainer()->get(UserRepository::class);
        $target_user_id = $userRepository->findOneBy(['login' => 'third_user'])->getId();
        $target_user_id = (string)$target_user_id;

        $client->request('DELETE', "/api/users/{$target_user_id}/delete");

        $this->assertResponseIsSuccessful();
    }

    public function testCreateUserUserAlreadyExistsByLogin(): void
    {
        $this->expectException(UserAlreadyExistsException::class);
        $this->expectExceptionMessage("Пользователь с данным логином уже существует в системе");

        $client = static::createClient();
        $client->catchExceptions(false);

        $this->loginUserByLogin($client, 'first_user');
        

        $params = 
        [
            'login' => 'second_user',
            'password' => '11112231231qeqw',
            'email' => 'seconduser@somemail.com',
            'first_name' => 'Dave',
            'second_name' => 'Batista',
        ];

        $client->request("POST", "/api/users/create", [], [], [], json_encode($params));
    }

    public function testCreateUserUserAlreadyExistsByEmail(): void
    {
        $this->expectException(UserAlreadyExistsException::class);
        $this->expectExceptionMessage("Пользователь с данным email уже существует в системе");

        $client = static::createClient();
        $client->catchExceptions(false);

        $this->loginUserByLogin($client, 'first_user');

        $params =
        [
            'login' => 'four_user',
            'password' => 'qqweqweqwew2222',
            'email' => 'seconduser@somemail.com',
            'first_name' => 'Jonathan',
            'second_name' => 'Miller',
        ];

        $client->request("POST", "/api/users/create", [], [], [], json_encode($params));

    }

    public function testChangeUserNotFound(): void
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage("Пользователь не найден");

        $client = static::createClient();
        $client->catchExceptions(false);

        $this->loginUserByLogin($client, 'first_user');

        $userRepository = static::getContainer()->get(UserRepository::class);
        $target_user_id = $userRepository->getMaxUserId() + 1;
        $target_user_id = (string)$target_user_id;

        $params = 
        [
            'first_name' => 'some first name',
            'second_name' => 'some second name',
            
        ];

        $client->request('PATCH', "/api/users/{$target_user_id}/change", [], [], [], json_encode($params));

    }

    public function testDeleteUserNotFound(): void
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage("Пользователь не найден");

        $client = static::createClient();
        $client->catchExceptions(false);

        $this->loginUserByLogin($client, 'first_user');

        $userRepository = static::getContainer()->get(UserRepository::class);
        $target_user_id = $userRepository->getMaxUserId() + 1;
        $target_user_id = (string)$target_user_id;

        $client->request('DELETE', "/api/users/{$target_user_id}/delete");

    }




    private function loginUserByLogin(KernelBrowser $client, string $user_login): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneBy(['login' => $user_login]);

        $client->loginUser($user);
    }

}