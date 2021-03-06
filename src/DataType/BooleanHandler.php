<?php

namespace Zdrojowa\AuthenticationLink\DataType;

/**
 * Handle serialization of booleans.
 */
class BooleanHandler extends ScalarHandler
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'boolean';
}
