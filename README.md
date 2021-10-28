Event Recorder Cloud Function
===

# TODO
- delivery (artifact build)

# Purpose of Event Recorder Cloud Function
It will append every incoming Google PubSub message to storage of your choice.
Supported PDO drivers:
- postgres

# New TOPIC
mysql:
```mysql
CREATE TABLE test_topic_table (
        message_id VARCHAR(16) UNIQUE NOT NULL,
        publish_time TIMESTAMP NOT NULL,
        body TEXT NOT NULL
    );
```
postgresql:
```postgresql
CREATE TABLE test_topic_table (
        message_id char(16) CONSTRAINT test_topic_table_pk PRIMARY KEY,
        publish_time timestamp,
        body TEXT
    );
```

# Input
On the input, Cloud Function will get a `Psr\Http\Message\ServerRequestInterface`.

# Environment variables
If these ENV vars are set (and configured in terraform module definition), all messages, published to the main topic will be persisted to according storage:
- DB_NAME
- DB_USER
- DB_PASSWORD
- CONNECTION_NAME
- TOPIC - (name of DB table, where all topic messages will be persisted for good)

# Testing

TODO

# Deployment
See `/.gitlab-ci.yml` + `infrastructure` folder.

## TODO
- explain artifact delivery
    - build some widely available artifact
- other storages support (when needed)
- refactor logger

# Logs
To increase amount of logs - send env variable
```shell
DEBUG=true
```

# terraform
Examples of Cloud Function usages can be found in the `/infrastructure/my-dev-env/main.tf` file:
- recorder
- list records from topic table
- prune (for development needs only!)
