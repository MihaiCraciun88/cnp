<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class CnpTest extends TestCase
{
    public function testStringLenInvalid() {
        $this->assertFalse(isCnpValid('123'));
    }

    public function testIsNotNumeric() {
        $this->assertFalse(isCnpValid('1234567890ABC'));
    }

    public function testDateInvalid() {
        // 1999-02-29
        $date = getCnpDate('1990229000000');
        $this->assertFalse(checkdate($date['month'], $date['day'], $date['year']));
    }

    public function testCheckSum() {
        $cnp = '1900228100012';
        $this->assertTrue(getCnpCheckSum($cnp) === intval($cnp[12]));
    }

    public function testValid() {
        for ($i = 1; $i <= 9; $i++) {
            $cnp = '190022810001';
            $cnp[11] = $i;
            $cnp .= getCnpCheckSum($cnp);
            $this->assertTrue(isCnpValid($cnp));
        }
    }
}