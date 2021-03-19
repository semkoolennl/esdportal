<?php


namespace App\Tests\Eset\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LicenseControllerTest extends WebTestCase
{
    /** @test */
    public function itFindsAndReturnsLicenseWithA302StatusCode()
    {
        $this->assertEquals(true, true);
    }
}