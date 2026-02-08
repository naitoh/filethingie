<?php

use PHPUnit\Framework\TestCase;

class FtAuthTest extends TestCase
{
    protected function setUp(): void
    {
        global $ft;
        $ft = array(
            'settings' => array(),
            'groups' => array(),
            'users' => array(),
            'plugins' => array(),
        );
    }

    // --- ft_check_cookie ---

    public function testCheckCookieValidPrimaryUser(): void
    {
        $validCookie = md5(USERNAME . PASSWORD);
        $this->assertEquals(USERNAME, ft_check_cookie($validCookie));
    }

    public function testCheckCookieInvalidCookie(): void
    {
        $this->assertFalse(ft_check_cookie('invalidcookievalue'));
        $this->assertFalse(ft_check_cookie(''));
    }

    public function testCheckCookieValidAdditionalUser(): void
    {
        global $ft;
        $ft['users']['admin'] = array('password' => 'secret123');
        $validCookie = md5('admin' . 'secret123');

        $this->assertEquals('admin', ft_check_cookie($validCookie));

        // Clean up.
        unset($ft['users']['admin']);
    }

    public function testCheckCookieWrongPasswordForAdditionalUser(): void
    {
        global $ft;
        $ft['users']['admin'] = array('password' => 'secret123');
        $wrongCookie = md5('admin' . 'wrongpassword');

        $this->assertFalse(ft_check_cookie($wrongCookie));

        // Clean up.
        unset($ft['users']['admin']);
    }

    // --- ft_check_user ---

    public function testCheckUserPrimaryUser(): void
    {
        $this->assertTrue(ft_check_user(USERNAME));
    }

    public function testCheckUserNonExistentUser(): void
    {
        $this->assertFalse(ft_check_user('nobody'));
        $this->assertFalse(ft_check_user(''));
    }

    public function testCheckUserAdditionalUser(): void
    {
        global $ft;
        $ft['users']['editor'] = array('password' => 'pass');

        $this->assertTrue(ft_check_user('editor'));

        // Clean up.
        unset($ft['users']['editor']);
    }

    public function testCheckUserAdditionalUserRemovedAfterCleanup(): void
    {
        global $ft;
        $ft['users']['temp'] = array('password' => 'temp');
        unset($ft['users']['temp']);

        $this->assertFalse(ft_check_user('temp'));
    }
}
