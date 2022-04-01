<?php

namespace PHPSTORM_META {

    registerArgumentsSet('json5_encode_flags', \JSON_HEX_QUOT
        | \JSON_HEX_TAG | \JSON_HEX_AMP | \JSON_HEX_APOS | \JSON_NUMERIC_CHECK
        | \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES | \JSON_FORCE_OBJECT
        | \JSON_PRESERVE_ZERO_FRACTION | \JSON_UNESCAPED_UNICODE
        | \JSON_PARTIAL_OUTPUT_ON_ERROR | \JSON_UNESCAPED_LINE_TERMINATORS
        | \JSON_INVALID_UTF8_IGNORE | \JSON_INVALID_UTF8_SUBSTITUTE);

    registerArgumentsSet('json5_decode_flags', \JSON_BIGINT_AS_STRING
        | \JSON_OBJECT_AS_ARRAY | \JSON_INVALID_UTF8_IGNORE | \JSON_INVALID_UTF8_SUBSTITUTE);

    expectedArguments(\Serafim\Json5\Json5EncoderInterface::encode(), 1, argumentsSet('json5_encode_flags'));
    expectedArguments(\Serafim\Json5\Json5::encode(), 1, argumentsSet('json5_encode_flags'));
    expectedArguments(\json5_encode(), 1, argumentsSet('json5_encode_flags'));

    expectedArguments(\Serafim\Json5\Json5DecoderInterface::decode(), 1, argumentsSet('json5_decode_flags'));
    expectedArguments(\Serafim\Json5\Json5::decode(), 1, argumentsSet('json5_decode_flags'));
    expectedArguments(\json5_decode(), 3, argumentsSet('json5_decode_flags'));

}
