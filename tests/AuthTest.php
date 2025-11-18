<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class AuthTest extends WebTestCase
{
    public function testLogin(): void
    {
        $credentials = [
            'email' => 'test@mail.ru',
            'password' => 'password',
        ];

        $this->client->jsonRequest('POST', '/api/login', $credentials);

        $responseData = $this->decodeResponse($this->client);

        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('token', $responseData);
        $this->assertIsString($responseData['token']);
        $this->assertNotEmpty($responseData['token']);
    }

    public function testRegister(): void
    {
        $credentials = [
            'email' => 'test123@mail.ru',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->client->jsonRequest('POST', '/api/register', $credentials);

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $registeredUser = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $credentials['email']]);

        $this->assertNotNull($registeredUser);

        $responseData = $this->decodeResponse($this->client);

        $this->assertArrayHasKey('token', $responseData);
        $this->assertIsString($responseData['token']);
        $this->assertNotEmpty($responseData['token']);

        $this->assertArrayHasKey('user', $responseData);
        $this->assertIsArray($responseData['user']);
        $this->assertNotEmpty($responseData['user']);
    }
}
