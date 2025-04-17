<?php

declare(strict_types=1);

namespace Tests\Assertions;

use ArrayObject;
use Iquety\Shield\Assertion\IsUrl;
use stdClass;

class IsUrlTest extends AssertionCase
{
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        return [
            'Valid URL - http'          => ['http://www.example.com'],
            'Valid URL - https'         => ['https://www.example.com'],
            'Valid URL - with path'     => ['http://www.example.com/path'],
            'Valid URL - with query'    => ['http://www.example.com/path?query=123'],
            'Valid URL - with fragment' => ['http://www.example.com/path#fragment'],
            'Valid URL - IP address'    => ['http://192.168.1.1'],
            'Valid URL - localhost'     => ['http://localhost'],
            'Valid URL - subdomain'     => ['http://subdomain.example.com'],
            'Valid URL - port'          => ['http://www.example.com:8080'],
            'Valid URL - long TLD'      => ['http://www.example.museum'],
        ];
    }

    /**
     * @test
     * @dataProvider validProvider
     */
    public function valueIsUrl(mixed $url): void
    {
        $assertion = new IsUrl($url);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(mixed $value): array
    {
        $messageValue = $this->makeMessageValue($value);

        return [
            $value,
            "O valor $messageValue está errado" // mensagem personalizada
        ];
    }

    /** @return array<string,array<int,mixed>> */
    public function invalidProvider(): array
    {
        $list = [];

        $list['Invalid URL - no scheme'] = $this->makeIncorrectItem('www.example.com');
        $list['Invalid URL - no domain'] = $this->makeIncorrectItem('http://');
        $list['Invalid URL - spaces'] = $this->makeIncorrectItem('http://example .com');
        // $list['Invalid URL - special characters'] = $this->makeIncorrectItem('http://example.com/<>');
        // $list['Invalid URL - incomplete TLD'] = $this->makeIncorrectItem('http://example.c');
        // $list['Invalid URL - no TLD'] = $this->makeIncorrectItem('http://example');
        $list['Invalid URL - IP without scheme'] = $this->makeIncorrectItem('192.168.1.1');
        $list['Invalid URL - missing slashes'] = $this->makeIncorrectItem('http:example.com');
        $list['Invalid URL - double dots'] = $this->makeIncorrectItem('http://example..com');
        $list['Invalid URL - empty string'] = $this->makeIncorrectItem('');
        $list['Invalid URL chars 1'] = $this->makeIncorrectItem('http://&example.com/捦挺挎/bar');
        $list['Invalid URL chars 2'] = $this->makeIncorrectItem([
            'www.hti.umich.edu/cgi/t/text/pageviewer-idx'
            . '?c=umhistmath;cc=umhistmath;rgn=full%20text;'
            . 'idno=ABS3153.0001.001;didno=ABS3153.0001.001;view=image;seq=00000140'
        ]);
        $list['empty array'] = $this->makeIncorrectItem([]);
        $list['object']      = $this->makeIncorrectItem(new stdClass());
        $list['countable']   = $this->makeIncorrectItem(new ArrayObject());
        $list['null']        = $this->makeIncorrectItem(null);
        $list['integer']     = $this->makeIncorrectItem(1234);

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNotUrl(mixed $url): void
    {
        $assertion = new IsUrl($url);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must be a valid URL"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotUrl(mixed $url): void
    {
        $assertion = new IsUrl($url);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must be a valid URL"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function namedValueIsNotUrlWithAndCustomMessage(
        mixed $value,
        string $message
    ): void {
        $assertion = new IsUrl($value);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     */
    public function valueIsNoturlWithCustomMessage(
        mixed $url,
        string $message
    ): void {
        $assertion = new IsUrl($url);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
