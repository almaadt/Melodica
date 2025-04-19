<?php
require_once 'vendor/autoload.php';
require_once 'RegistrationProcessorMysqli.php';
require_once 'MockMysqli.php';

use PHPUnit\Framework\TestCase;

class ProcessRegisterMysqliTest extends TestCase
{
    private $mockMysqli;
    
    protected function setUp(): void
    {
        $this->mockMysqli = new MockMysqli();
    }
    
    /**
     * Test registrazione con dati validi
     */
    public function testRegistrationSuccess()
    {
        $registrationProcessor = new RegistrationProcessorMysqli($this->mockMysqli);
        
        $result = $registrationProcessor->processRegistration([
            'email' => 'test@example.com',
            'username' => 'testuser',
            'password' => 'password123',
            'password1' => 'password123'
        ]);
        
        $this->assertEquals('success', $result['status']);
        $this->assertStringContainsString('completata con successo', $result['message']);
    }
    
    /**
     * Test email non valida
     */
    public function testInvalidEmail()
    {
        $registrationProcessor = new RegistrationProcessorMysqli($this->mockMysqli);
        
        $result = $registrationProcessor->processRegistration([
            'email' => 'invalid-email',
            'username' => 'testuser',
            'password' => 'password123',
            'password1' => 'password123'
        ]);
        
        $this->assertEquals('error', $result['status']);
        $this->assertStringContainsString('email non valido', $result['message']);
    }
    
    /**
     * Test username troppo corto
     */
    public function testShortUsername()
    {
        $registrationProcessor = new RegistrationProcessorMysqli($this->mockMysqli);
        
        $result = $registrationProcessor->processRegistration([
            'email' => 'test@example.com',
            'username' => 'te',  // meno di 3 caratteri
            'password' => 'password123',
            'password1' => 'password123'
        ]);
        
        $this->assertEquals('error', $result['status']);
        $this->assertStringContainsString('almeno 3 caratteri', $result['message']);
    }
    
    /**
     * Test password troppo corta
     */
    public function testShortPassword()
    {
        $registrationProcessor = new RegistrationProcessorMysqli($this->mockMysqli);
        
        $result = $registrationProcessor->processRegistration([
            'email' => 'test@example.com',
            'username' => 'testuser',
            'password' => '12345',  // meno di 6 caratteri
            'password1' => '12345'
        ]);
        
        $this->assertEquals('error', $result['status']);
        $this->assertStringContainsString('almeno 6 caratteri', $result['message']);
    }
    
    /**
     * Test password non corrispondenti
     */
    public function testPasswordMismatch()
    {
        $registrationProcessor = new RegistrationProcessorMysqli($this->mockMysqli);
        
        $result = $registrationProcessor->processRegistration([
            'email' => 'test@example.com',
            'username' => 'testuser',
            'password' => 'password123',
            'password1' => 'differentpassword'
        ]);
        
        $this->assertEquals('error', $result['status']);
        $this->assertStringContainsString('password digitate devono corrispondere', $result['message']);
    }
    
    /**
     * Test username già esistente
     */
    public function testDuplicateUser()
    {
        $this->mockMysqli->setDuplicateErrorMode(true);
        $registrationProcessor = new RegistrationProcessorMysqli($this->mockMysqli);
        
        $result = $registrationProcessor->processRegistration([
            'email' => 'existing@example.com',
            'username' => 'existinguser',
            'password' => 'password123',
            'password1' => 'password123'
        ]);
        
        $this->assertEquals('error', $result['status']);
        $this->assertStringContainsString('esistono già', $result['message']);
    }
}
