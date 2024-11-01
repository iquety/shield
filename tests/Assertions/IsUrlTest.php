<?php

declare(strict_types=1);

namespace Tests\Assertions;

use Iquety\Shield\Assertion\IsUrl;
use Tests\TestCase;

class IsUrlTest extends TestCase
{
    /** @return array<string,array<int,mixed>> */
    public function correctValueProvider(): array
    {
        return [
            'Valid URL - http' => ['http://www.example.com'],
            'Valid URL - https' => ['https://www.example.com'],
            'Valid URL - with path' => ['http://www.example.com/path'],
            'Valid URL - with query' => ['http://www.example.com/path?query=123'],
            'Valid URL - with fragment' => ['http://www.example.com/path#fragment'],
            'Valid URL - IP address' => ['http://192.168.1.1'],
            'Valid URL - localhost' => ['http://localhost'],
            'Valid URL - subdomain' => ['http://subdomain.example.com'],
            'Valid URL - port' => ['http://www.example.com:8080'],
            'Valid URL - long TLD' => ['http://www.example.museum'],
        ];
    }

    /**
     * @test
     * @dataProvider correctValueProvider
     */
    public function assertedCase(string $url): void
    {
        $assertion = new IsUrl($url);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<string,array<int,mixed>> */
    public function incorrectValueProvider(): array
    {
        $list = [];

        $list['Invalid URL - no scheme'] = ['www.example.com'];
        $list['Invalid URL - no domain'] = ['http://'];
        $list['Invalid URL - spaces'] = ['http://example .com'];
        // $list['Invalid URL - special characters'] = ['http://example.com/<>'];
        // $list['Invalid URL - incomplete TLD'] = ['http://example.c'];
        // $list['Invalid URL - no TLD'] = ['http://example'];
        $list['Invalid URL - IP without scheme'] = ['192.168.1.1'];
        $list['Invalid URL - missing slashes'] = ['http:example.com'];
        $list['Invalid URL - double dots'] = ['http://example..com'];
        $list['Invalid URL - empty string'] = [''];
        $list['Invalid URL chars 1'] = ['http://&example.com/捦挺挎/bar'];
        $list['Invalid URL chars 2'] = [
            'www.hti.umich.edu/cgi/t/text/pageviewer-idx'
            . '?c=umhistmath;cc=umhistmath;rgn=full%20text;'
            . 'idno=ABS3153.0001.001;didno=ABS3153.0001.001;view=image;seq=00000140'
        ];


        return $list;
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCase(string $url): void
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
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertion(string $url): void
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
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithNamedAssertionAndCustomMessage(string $url): void
    {
        $assertion = new IsUrl($url);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $url está errado");
    }

    /**
     * @test
     * @dataProvider incorrectValueProvider
     */
    public function notAssertedCaseWithCustomMessage(string $url): void
    {
        $assertion = new IsUrl($url);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals($assertion->makeMessage(), "O valor $url está errado");
    }
}
