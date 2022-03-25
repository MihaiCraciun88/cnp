<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class CnpTest extends TestCase
{
    protected $cnp = '1880118430085';

    public function testInvalidStringLen() {
        $this->assertFalse(isCnpValid('123'));
    }

    public function testIsNotNumeric() {
        $this->assertFalse(isCnpValid('1234567890ABC'));
    }

    public function testInvalidDate() {
        $cnp = $this->cnp;

        // 1999-02-29
        $cnp[1] = '9';
        $cnp[2] = '9';
        $cnp[3] = '0';
        $cnp[4] = '2';
        $cnp[5] = '2';
        $cnp[6] = '9';
        $this->assertFalse(isCnpValid($cnp));

        // 5 1999-02-28
        $cnp[0] = '5';
        $cnp[6] = '8';
        $this->assertFalse(isCnpValid($cnp));

        // 1 2002-02-28
        $cnp[0] = '1';
        $cnp[1] = '0';
        $cnp[2] = '2';
        $this->assertFalse(isCnpValid($cnp));
    }

    public function testCheckSum() {
        $this->assertTrue(cnpCheckSum($this->cnp));
    }

    public function testValid() {
        $this->assertTrue(isCnpValid($this->cnp));
    }
}