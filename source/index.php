<?php

# index.php contains laconic code of Cloud Function entry points.

# container.php contains implementation of a VERY simple DI
include "src/container.php";

use AllMyHomes\CloudFunction\Service\Request\RecordPubSubEventRequestValidator;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

function record(ServerRequestInterface $request): Response
{
    global $container;

    // DI simulation
    /** @var PDO $pdo */
    $pdo = $container[PDO::class];

    /** @var RecordPubSubEventRequestValidator $recordPubSubEventRequestValidator */
    $recordPubSubEventRequestValidator = $container[RecordPubSubEventRequestValidator::class];

    // configuration
    $topic = getenv('TOPIC');

    try {
        // validation of Request
        $validationErrors = $recordPubSubEventRequestValidator->getValidationErrors($request);
        if ($validationErrors) {
            logString('Validation errors');
            foreach ($validationErrors as $validationError) {
                logString($validationError);
            }

            return (new Response())->withStatus(400);
        } else {
            logString('No validation errors', true);
        }

        // decoding the payload
        // todo: serializer or factory
        logString('Decoding the payload', true);
        $requestBody = $request->getBody();
        logString('Request size: '.$requestBody->getSize(), true);
        $requestBodyContents = $requestBody->getContents();
        $body = json_decode($requestBodyContents, true);
        logString('Decoded Body has keys: '.implode(';', array_keys($body)), true);

        $subscription = $body['subscription'];
        logString('subscription: '.$subscription, true);
        $message = $body['message'];
        logString('message has keys: '.implode(';', array_keys($message)), true);
        $messageData = $message['data'];
        $originalMessageId = $message['messageId'];
        $originalPublishTime = $message['publishTime'];
        logString('extendedMessageId: ' . $originalMessageId, true);

        // persistence
        $statement = $pdo->prepare("INSERT INTO $topic(message_id, publish_time, body) VALUES (?,?,?);");
        logString('Preparing to execute', true);
        $success = $statement->execute([$originalMessageId, $originalPublishTime, $messageData]);
        if ($success === false) {
            logString('PDO query execution failed!');
            $errorInfo = $pdo->errorInfo();
            logString('PDO error: '.$errorInfo[0].' '.$errorInfo[1].' '.$errorInfo[2]);

            return (new Response())->withStatus(500);
        } else {
            logString('INSERT successful', true);
        }
    } catch (\Throwable $e) {
        logString($e->getMessage());

        return (new Response())->withStatus(500);
    }

    return (new Response())->withStatus(201);
}

function listEvents(ServerRequestInterface $request)
{
    global $container;

    // DI simulation
    /** @var PDO $responseFactory */
    $pdo = $container[PDO::class];

    $topic = getenv('TOPIC');

    $statement = $pdo->query("SELECT * FROM $topic ORDER BY publish_time DESC");
    if (!$statement) {
        $errorInfo = $pdo->errorInfo();
        echo $errorInfo[2] . PHP_EOL;
    }

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        echo sprintf("%s %s %s <br/>", $row['message_id'], $row['publish_time'], $row['body']);
    }

    return (new Response())->withStatus(200);
}

function prune(ServerRequestInterface $request)
{
    global $container;

    // DI simulation
    /** @var PDO $responseFactory */
    $pdo = $container[PDO::class];

    $topic = getenv('TOPIC');

    $statement = $pdo->query("DELETE FROM $topic");
    if (!$statement) {
        $errorInfo = $pdo->errorInfo();
        echo $errorInfo[2] . PHP_EOL;
    }

    return (new Response())->withStatus(200);
}

function logString(string $message, bool $isDebugLog = false): void
{
    if ($isDebugLog && !(getenv('DEBUG') === 'true')) {
        return;
    }

    $errorLogOutput = fopen('php://stderr', 'wb');
    fwrite($errorLogOutput, $message . PHP_EOL);
}
