<?php

declare(strict_types=1);

namespace AllMyHomes\CloudFunction\Service\PDO;

use PDO;
use PDOException;
use RuntimeException;
use TypeError;

class PgsqlPDOFactory
{
    public function build(): PDO
    {
        try {
            $dbName = getenv('DB_NAME');
            $username = getenv('DB_USER');
            $password = getenv('DB_PASSWORD');
            $connectionName = getenv('CONNECTION_NAME');
            // Connect using UNIX sockets
            $socketDir = getenv('DB_SOCKET_DIR') ?: '/cloudsql';
            $dsn = sprintf(
                'pgsql:dbname=%s;host=%s/%s',
                $dbName,
                $socketDir,
                $connectionName
            );

            // Connect to the database.
            $options = [
                PDO::ATTR_TIMEOUT => 5, // in seconds
            ];

            return new PDO($dsn, $username, $password, $options);

        } catch (TypeError $e) {
            throw new RuntimeException(
                sprintf(
                    'Invalid or missing configuration! Make sure you have set ' .
                    '$username, $password, $dbName, and $dbHost (for TCP mode) ' .
                    'or $connectionName (for UNIX socket mode). ' .
                    'The PHP error was %s',
                    $e->getMessage()
                ),
                $e->getCode(),
                $e
            );
        } catch (PDOException $e) {
            throw new RuntimeException(
                sprintf(
                    'Could not connect to the Cloud SQL Database. Check that ' .
                    'your username and password are correct, that the Cloud SQL ' .
                    'proxy is running, and that the database exists and is ready ' .
                    'for use. For more assistance, refer to %s. The PDO error was %s',
                    'https://cloud.google.com/sql/docs/postgres/connect-external-app',
                    $e->getMessage()
                ),
                $e->getCode(),
                $e
            );
        }
    }
}
