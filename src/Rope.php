<?php

namespace Nulltrain\Rope;

class Rope
{

    private $value = '';


    public function __construct($value)
    {
        $this->value = $value;
    }


    public function __toString()
    {
        return $this->value;
    }


    private function _apply($function, ...$parameters)
    {
        $parameters_length = count($parameters);
        if ($parameters_length === 1 && is_array($parameters[0])) {
            $parameters = $parameters[0];
        } else {
            array_unshift($parameters, $this->value);
        }

        $value = call_user_func_array($function, $parameters);

        switch (gettype($value)) {
            case 'array':
                return $this->newArray($value);

            case 'string':
                return new static($value);

            default:
                return $value;
        }
    }


    /**
     * Pass the rope into the given callback and then return it.
     *
     * @param callable $callback
     *
     * @return $this
     */
    public function tap(callable $callback)
    {
        $callback(new static($this->value));

        return $this;
    }


    /**
     * @param array $items
     *
     * @return array
     */
    public function newArray(array $items = [])
    {
        return $items;
    }


    /**
     * Quote string with slashes in a C style
     *
     * @param $charlist
     *
     * @return Rope
     */
    public function addCSlashes($charlist)
    {
        return $this->_apply('addcslashes', $charlist);
    }


    /**
     * Quote string with slashes
     *
     * @return Rope
     */
    public function addSlashes()
    {
        return $this->_apply('addslashes');
    }


    /**
     * Alias of rtrim
     *
     * @param string $character_mask
     *
     * @return Rope
     */
    public function chop($character_mask = " \t\n\r\0\x0B")
    {
        return $this->rtrim($character_mask);
    }


    /**
     * Split a string into smaller chunks
     *
     * @param int    $chunklen
     * @param string $end
     *
     * @return Rope
     */
    public function chunk_split($chunklen = 76, $end = "\r\n")
    {
        return $this->_apply('chunk_split', [$chunklen, $end]);
    }


    /**
     * Output one or more strings
     *
     * @param array ...$value
     *
     * @return $this
     */
    public function echo(...$value)
    {
        array_unshift($value, $this->value);

        $this->_apply('echo', $value);

        return $this;
    }


    /**
     * Split a string by string
     *
     * @param     $delimiter
     * @param int $limit
     *
     * @return array
     */
    public function explode($delimiter, $limit = PHP_INT_MAX)
    {
        return $this->_apply('explode', [$delimiter, $this->value, $limit]);
    }


    /**
     * Calculates the crc32 polynomial of a string
     *
     * @return int
     */
    public function crc32()
    {
        return $this->_apply('crc32');
    }


    /**
     * @param null $salt
     *
     * @return Rope
     */
    function crypt($salt = null)
    {
        return $this->_apply('crypt', $salt);
    }

    /*
    convert_cyr_string — Convert from one Cyrillic character set to another
    convert_uudecode — Decode a uuencoded string
    convert_uuencode — Uuencode a string
    count_chars — Return information about characters used in a string
    fprintf — Write a formatted string to a stream
    get_html_translation_table — Returns the translation table used by htmlspecialchars and htmlentities
    hebrev — Convert logical Hebrew text to visual text
    hebrevc — Convert logical Hebrew text to visual text with newline conversion
    hex2bin — Decodes a hexadecimally encoded binary string
    html_entity_decode — Convert all HTML entities to their applicable characters
    htmlentities — Convert all applicable characters to HTML entities
    htmlspecialchars_decode — Convert special HTML entities back to characters
    htmlspecialchars — Convert special characters to HTML entities
    implode — Join array elements with a string
    join — Alias of implode
    lcfirst — Make a string's first character lowercase
    levenshtein — Calculate Levenshtein distance between two strings
    localeconv — Get numeric formatting information
    ltrim — Strip whitespace (or other characters) from the beginning of a string
    */
// md5 — Calculate the md5 hash of a string
    public function md5()
    {
        return $this->_apply('md5');
    }
    /*
    metaphone — Calculate the metaphone key of a string
    money_format — Formats a number as a currency string
    nl_langinfo — Query language and locale information
    */
// nl2br — Inserts HTML line breaks before all newlines in a string
    public function nl2br()
    {
        return $this->_apply('nl2br');
    }
    /*
    number_format — Format a number with grouped thousands
    ord — Return ASCII value of character
    parse_str — Parses the string into variables
    print — Output a string
    printf — Output a formatted string
    quoted_printable_decode — Convert a quoted-printable string to an 8 bit string
    quoted_printable_encode — Convert a 8 bit string to a quoted-printable string
    quotemeta — Quote meta characters
    */

    //    rtrim — Strip whitespace (or other characters) from the end of a string
    public function rtrim($character_mask = " \t\n\r\0\x0B")
    {
        return $this->_apply('rtrim', $character_mask);
    }
    /*
    setlocale — Set locale information
    */
// sha1 — Calculate the sha1 hash of a string
    public function sha1()
    {
        return $this->_apply('sha1');
    }

    /*
    similar_text — Calculate the similarity between two strings
    soundex — Calculate the soundex key of a string
    sprintf — Return a formatted string
    sscanf — Parses input from a string according to a format
    str_getcsv — Parse a CSV string into an array
    str_ireplace — Case-insensitive version of str_replace.
    str_pad — Pad a string to a certain length with another string
    str_repeat — Repeat a string
    */

// str_replace — Replace all occurrences of the search string with the replacement string
    public function replace($search, $replace, &$count = null)
    {
        $parameters = [$search, $replace, $this->value, &$count];

        return $this->_apply('str_replace', $parameters);
    }


// str_rot13 — Perform the rot13 transform on a string
    public function rot13()
    {
        return $this->_apply('str_rot13');
    }


// str_shuffle — Randomly shuffles a string
    public function shuffle()
    {
        return $this->_apply('str_shuffle');
    }


    //     str_split — Convert a string to an array
    public function split($length = 1)
    {
        return $this->_apply('str_split', $length);
    }
    /*
    str_split — Convert a string to an array
    str_word_count — Return information about words used in a string
    strcasecmp — Binary safe case-insensitive string comparison
    strchr — Alias of strstr
    strcmp — Binary safe string comparison
    strcoll — Locale based string comparison
    strcspn — Find length of initial segment not matching mask
    strip_tags — Strip HTML and PHP tags from a string
    stripcslashes — Un-quote string quoted with addcslashes
    stripos — Find the position of the first occurrence of a case-insensitive substring in a string
    stripslashes — Un-quotes a quoted string
    stristr — Case-insensitive strstr
    strlen — Get string length
    strnatcasecmp — Case insensitive string comparisons using a "natural order" algorithm
    strnatcmp — String comparisons using a "natural order" algorithm
    strncasecmp — Binary safe case-insensitive string comparison of the first n characters
    strncmp — Binary safe string comparison of the first n characters
    strpbrk — Search a string for any of a set of characters
    strpos — Find the position of the first occurrence of a substring in a string
    strrchr — Find the last occurrence of a character in a string
    */
// strrev — Reverse a string
    public function reverse()
    {
        return $this->_apply('strrev');
    }

    /*
    strripos — Find the position of the last occurrence of a case-insensitive substring in a string
    strrpos — Find the position of the last occurrence of a substring in a string
    strspn — Finds the length of the initial segment of a string consisting entirely of characters contained within a given mask.
    strstr — Find the first occurrence of a string
    strtok — Tokenize string
    */

// strtolower — Make a string lowercase
    public function toLower()
    {
        return $this->_apply('strtolower');
    }


// strtoupper — Make a string uppercase
    public function toUpper()
    {
        return $this->_apply('strtoupper');
    }

    /*


    strtr — Translate characters or replace substrings
    substr_compare — Binary safe comparison of two strings from an offset, up to length characters
    substr_count — Count the number of substring occurrences
    substr_replace — Replace text within a portion of a string
    substr — Return part of a string
    trim — Strip whitespace (or other characters) from the beginning and end of a string
    ucfirst — Make a string's first character uppercase
    ucwords — Uppercase the first character of each word in a string
    vfprintf — Write a formatted string to a stream
    vprintf — Output a formatted string
    vsprintf — Return a formatted string
    wordwrap — Wraps a string to a given number of characters
    */
}
