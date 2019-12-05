<?php

namespace Zdrojowa\AuthenticationLink\DataType;

/**
 * Handle serialization of integers.
 */
class IntegerHandler extends ScalarHandler
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'integer';
}
