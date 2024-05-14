<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testSomething(): void
    {
        // créer un faux client qui pointe vers url
        $client = static::createClient();
        $client->request('GET', '/inscription');

        // remplir les champs d'inscription

        $client->submitForm('Envoyer', [
            'register_user[email]' => "test@exemple.fr ",
            'register_user[plainPassword][first]' => "123456",
            'register_user[plainPassword][second]' => "123456",
            'register_user[firstname]' => "testFirstName",
            'register_user[lastname]' => "testLastName",
        ]);
        $this->assertResponseRedirects('/connexion');
        $client->followRedirect();


        // est ce qu je reçois le flasMessage de succès ?

        $this->assertSelectorExists('div:contains("Compte créé ! Vous pouvez vous connecter !")');


    }
}
