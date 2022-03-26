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
        $date = getCnpDate('0990229000000');
        $this->assertFalse(checkdate($date['month'], $date['day'], $date['year']));

        // 5 1999-02-28
        $cnp = '5990228000000';
        $date = getCnpDate($cnp);
        $this->assertFalse(isSexValid($cnp, $date));

        // 1 2002-02-28
        $cnp = '1020228000000';
        $date = getCnpDate($cnp);
        $this->assertFalse(isSexValid($cnp, $date));
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