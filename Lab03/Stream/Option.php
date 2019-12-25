<?php

namespace Lab03\Stream;

class Option
{
    public const ENCRYPT = '--encrypt';
    public const DECRYPT = '--decrypt';
    public const COMPRESS = '--compress';
    public const DECOMPRESS = '--decompress';
    public const AVAILABLE_OPTIONS = [self::ENCRYPT, self::DECRYPT, self::COMPRESS, self::DECOMPRESS];
    public const WITH_PARAMETER_OPTIONS = [self::ENCRYPT, self::DECRYPT];
    public const UNIQ_OPTIONS = [self::COMPRESS, self::DECOMPRESS];
}