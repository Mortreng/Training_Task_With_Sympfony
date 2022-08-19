<?php

namespace App\Tests\Card;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CardControllerTest extends WebTestCase
{

    /**
     * @test
     *
     */

    public function clientTest() {
        $client = static::createClient();
        $client->followRedirects();

        $client -> request('POST', '/card');

        $client -> submitForm('Verify', [
            'form[pan]' => '4929703763028940'
        ]);

        echo $client->getResponse();
        static::assertResponseIsSuccessful(); //Need to experiment more with web assertions, will do for now

        $client -> request('POST', '/card');
        $client -> submitForm('Verify', [
            'form[pan]' => '1365123512345'
        ]);

        echo $client->getResponse();
        static::assertResponseIsSuccessful();

    }
}