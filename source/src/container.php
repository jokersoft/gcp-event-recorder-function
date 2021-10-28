<?php

use AllMyHomes\CloudFunction\Service\PDO\PgsqlPDOFactory;
use AllMyHomes\CloudFunction\Service\Request\RecordPubSubEventRequestValidator;

# Since we do not need a lot of container functionality, let's make it as simple as associative array:
# Full\ClassName => new Instance();
# and accessible globally.
#
# In this file only instantiating or factory construction with configs allowed. No business logic. No "framework" logic.
# Apart from that - no rules. This file is small and will stay small enough to understand what is going on here.

$pdo = (new PgsqlPDOFactory())->build();

$container = [
    PDO::class => $pdo,
    RecordPubSubEventRequestValidator::class => new RecordPubSubEventRequestValidator(),
];
