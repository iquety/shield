<?php

declare(strict_types=1);

namespace Iquety\Shield\Assertion;

use Iquety\Shield\Assertion;
use Iquety\Shield\Message;

class IsUrl extends Assertion
{
    public function __construct(mixed $value)
    {
        $this->setValue($value);
    }

    /**
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function isValid(): bool
    {
        $value = $this->getValue();

        if (
            is_bool($value) === true
            || is_object($value) === true
            || is_array($value) === true
            || is_null($value) === true
        ) {
            return false;
        }

        $value = trim($value);

        // é vazio
        if ($value === '') {
            return false;
        }

        // espaços não são permitidos
        if (strpos($value, ' ') !== false) {
            return false;
        }

        // pontos seguidos não são permitidos
        if (strpos($value, '..') !== false) {
            return false;
        }

        // scheme - e.g. http
        // host
        // port
        // user
        // pass
        // path
        // query - after the question mark ?
        // fragment - after the hashmark #
        $urlInfo = (array)parse_url($value);

        // protocolo e domínio são obrigatórios
        if (
            isset($urlInfo['scheme']) === false
            || isset($urlInfo['host']) === false
        ) {
            return false;
        }

        if (filter_var($this->getValue(), FILTER_VALIDATE_URL) === false) {
            return false;
        }

        return true;
    }

    public function getDefaultMessage(): Message
    {
        return new Message("Value must be a valid URL");
    }

    public function getDefaultNamedMessage(): Message
    {
        return new Message(
            "Value of the field '{{ field }}' must be a valid URL",
        );
    }
}
