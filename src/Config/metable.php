<?php

return [
    /*
     * Model class to use for Meta.
     */
    'model' => \Zdrojowa\AuthenticationLink\Models\Meta::class,

    /*
     * List of handlers for recognized data types.
     *
     * Handlers will be evaluated in order, so a value will be handled
     * by the first appropriate handler in the list.
     */
    'datatypes' => [
        \Zdrojowa\AuthenticationLink\DataType\BooleanHandler::class,
        \Zdrojowa\AuthenticationLink\DataType\NullHandler::class,
        \Zdrojowa\AuthenticationLink\DataType\IntegerHandler::class,
        \Zdrojowa\AuthenticationLink\DataType\FloatHandler::class,
        \Zdrojowa\AuthenticationLink\DataType\StringHandler::class,
        \Zdrojowa\AuthenticationLink\DataType\DateTimeHandler::class,
        \Zdrojowa\AuthenticationLink\DataType\ArrayHandler::class,
        \Zdrojowa\AuthenticationLink\DataType\ModelHandler::class,
        \Zdrojowa\AuthenticationLink\DataType\ModelCollectionHandler::class,
        \Zdrojowa\AuthenticationLink\DataType\SerializableHandler::class,
        \Zdrojowa\AuthenticationLink\DataType\ObjectHandler::class,
    ],
];
