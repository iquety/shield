<?php

declare(strict_types=1);

namespace Tests\Assertions;

use InvalidArgumentException;
use Iquety\Shield\Assertion\NotMatches;
use stdClass;

class NotMatchesTest extends AssertionSearchCase
{
    public function invalidValueProvider(): array
    {
        $list = [];

        $list['null is invalid value']    = [null];
        $list['integer is invalid value'] = [123];
        $list['float is invalid value']   = [12.3];
        $list['true is invalid value']    = [true];
        $list['false is invalid value']   = [false];
        
        return $list;
    }

    /**
     * @test
     * @dataProvider invalidValueProvider
     */
    public function valueIsInvalid(mixed $value): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value is not valid');

        $assertion = new NotMatches($value, 'string');

        $assertion->isValid();
    }

    public function invalidNeedleProvider(): array
    {
        $list = [];

        $list['null is invalid needle for string']    = [null];
        $list['integer is invalid needle for string'] = [123];
        $list['float is invalid needle for string']   = [12.3];
        $list['true is invalid needle for string']    = [true];
        $list['false is invalid needle for string']   = [false];
        $list['array is invalid needle for string']   = [['x']];
        $list['object is invalid needle for string']  = [new stdClass()];
        
        return $list;
    }

    /**
     * @test
     * @dataProvider invalidNeedleProvider
     */
    public function needleForStringIsInvalid(mixed $needle): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value needle is not a valid search value for a string');

        $assertion = new NotMatches('string', $needle);

        $assertion->isValid();
    }

    /** @test */
    public function needleForListIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Null is not a valid search value for a list');

        $assertion = new NotMatches(['x'], null);

        $assertion->isValid();
    }

    public function invalidPatternProvider(): array
    {
        $list = [];

        $list['integer is invalid pattern'] = [123];
        $list['float is invalid pattern']   = [12.3];
        $list['true is invalid pattern']    = [true];
        $list['false is invalid pattern']   = [false];
        $list['array is invalid pattern']   = [['x']];
        $list['object is invalid pattern']  = [new stdClass()];
        
        return $list;
    }

    /**
     * @test
     * @dataProvider invalidPatternProvider
     */
    public function patternIsInvalid(mixed $pattern): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Regular expressions must be string');

        $assertion = new NotMatches(['x'], $pattern);

        $assertion->isValid();
    }
    
    /** @return array<string,array<int,mixed>> */
    public function validProvider(): array
    {
        // | Tipo completo                        |
        // |:--                                   |
        // | string                               |
        // | Stringable                           |
        // | array com valores string             |
        // | ArrayAccess com valores string       |
        // | Iterator com valores string          |
        // | IteratorAggregate com valores string |
        // | stdClass com valores string          |

        $list = [];

        $list['string @Coração!# matches @Co']       = ['@Coração!#', '/life/'];
        $list['string 123456 matches 123']           = ['123456', '/000/'];
        $list['stringable @Coração!# matches @Co']   = [$this->makeStringableObject('@Coração!#'), '/life/'];

        // arrays são permitidos apenas com valores string
        // os valores não-string são ignorados na busca
        $arrayValue = [
            'iterator'           => $this->makeIteratorObject(['@Coração!#']),
            'iterator aggregate' => $this->makeIteratorAggregateObject(['@Coração!#']),
            'stdObject'          => $this->makeStdObject(['@Coração!#'])
        ];

        foreach ($arrayValue as $label => $value) {
            $list["invalid value of type $label"] = [$arrayValue, '/a/'];
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider validProvider
     * @param array<mixed>|string $value
     */
    public function valueNotMatchesPattern(mixed $value, string $pattern): void
    {
        $assertion = new NotMatches($value, $pattern);

        $this->assertTrue($assertion->isValid());
    }

    /** @return array<int,mixed> */
    private function makeIncorrectItem(mixed $value, string $pattern): array
    {
        $messageValue = $this->makeMessageValue($value);

        return [
            $value,
            $pattern,
            "O valor $messageValue está errado" // mensagem personalizada
        ];
    }

    /** @return array<string,array<int,string>> */
    public function invalidProvider(): array
    {
        // | Tipo completo                        |
        // |:--                                   |
        // | string                               |
        // | Stringable                           |
        // | array com valores string             |
        // | ArrayAccess com valores string       |
        // | Iterator com valores string          |
        // | IteratorAggregate com valores string |
        // | stdClass com valores string          |

        $list = [];

        $list['string @Coração!# matches @Co']       = $this->makeIncorrectItem('@Coração!#', '/@Co/');
        $list['string @Coração!# matches ra']        = $this->makeIncorrectItem('@Coração!#', '/ra/');
        $list['string @Coração!# matches ção!#']     = $this->makeIncorrectItem('@Coração!#', '/ção!#/');
        $list['string 123456 matches 123']           = $this->makeIncorrectItem('123456', '/123/');
        $list['string 123456 matches 345']           = $this->makeIncorrectItem('123456', '/345/');
        $list['string 123456 matches 456']           = $this->makeIncorrectItem('123456', '/456/');
        $list['stringable @Coração!# matches @Co']   = $this->makeIncorrectItem($this->makeStringableObject('@Coração!#'), '/@Co/');
        $list['stringable @Coração!# matches ra']    = $this->makeIncorrectItem($this->makeStringableObject('@Coração!#'), '/ra/');
        $list['stringable @Coração!# matches ção!#'] = $this->makeIncorrectItem($this->makeStringableObject('@Coração!#'), '/ção!#/');

        // arrays são permitidos apenas com valores string
        $arrayValue = [
            '@Coração!#',
            '@Coração!#',
            '@Coração!#',
            '123456',
            '123456',
            '123456',
            $this->makeStringableObject('@Coração!#'),
            $this->makeStringableObject('@Coração!#'),
            $this->makeStringableObject('@Coração!#'),
        ];

        $arrayPatterns = [
            '/@Co/',
            '/ra/',
            '/ção!#/',
            '/123/',
            '/345/',
            '/456/',
            '/@Co/',
            '/ra/',
            '/ção!#/'
        ];

        foreach ($arrayValue as $index => $value) {
            $pattern = $arrayPatterns[$index];

            $label = is_object($value) === true
                ? "stringable @Coração!# matches $pattern"
                : "string $value matches $pattern";

            $list[$label] = $this->makeIncorrectItem($arrayValue, $pattern);
        }

        return $list;
    }

    /**
     * @test
     * @dataProvider invalidProvider
     * @param array<mixed>|string $value
     */
    public function valueMatchesPattern(mixed $value, string $pattern): void
    {
        $assertion = new NotMatches($value, $pattern);

        $this->assertFalse($assertion->isValid());

        $this->assertEquals(
            $assertion->makeMessage(),
            "Value must not match $pattern",
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     * @param array<mixed>|string $value
     */
    public function namedValueMatchesPattern(mixed $value, string $pattern): void
    {
        $assertion = new NotMatches($value, $pattern);

        $assertion->setFieldName('name');

        $this->assertFalse($assertion->isValid());
        $this->assertEquals(
            $assertion->makeMessage(),
            "Value of the field 'name' must not match $pattern"
        );
    }

    /**
     * @test
     * @dataProvider invalidProvider
     * @param array<mixed>|string $value
     */
    public function namedValueMatchesPatternAndCustomMessage(
        mixed $value,
        string $pattern,
        string $message
    ): void {
        $assertion = new NotMatches($value, $pattern);

        $assertion->setFieldName('name');

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }

    /**
     * @test
     * @dataProvider invalidProvider
     * @param array<mixed>|string $value
     */
    public function valueMatchesPatternWithCustomMessage(
        mixed $value,
        string $pattern,
        string $message
    ): void {
        $assertion = new NotMatches($value, $pattern);

        $assertion->message('O valor {{ value }} está errado');

        $this->assertFalse($assertion->isValid());

        $this->assertEquals($assertion->makeMessage(), $message);
    }
}
