<?php

namespace App\ATDW;

class Utf16LeParser
{
    public function __construct(private readonly string $str) { }

    /**
     * Attempt to convert the encoding of the saved string into utf8
     */
    public function getUtf8String(): ?string
    {
        $output = mb_convert_encoding($this->str, 'UTF-8', 'UTF-16LE');
        return is_string($output) ? $output : null;
    }

    /**
     * Parse the input string and output the corresponding array
     */
    public function getArray(): ?array
    {
        $utf = $this->getUtf8String();
        try {
            $output = json_decode($utf, true, 512, JSON_THROW_ON_ERROR);
            if (is_array($output)) {
                return $output;
            }
        } catch (\JsonException $e) {
        }
        return null;
    }
}
