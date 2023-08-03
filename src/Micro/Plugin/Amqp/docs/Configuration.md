# Configuration variables

### AMQP_CONNECTION_LIST

Comma-separated list of connection names.
###### Example
```dotenv
AMQP_CONNECTION_LIST="default,other_connection"
```
###### Default value "default"


### AMQP_QUEUE_LIST
Comma-separated list of queues names.
###### Example
```dotenv
AMQP_QUEUE_LIST="default,sms,email"
```
###### Default value "default"


### AMQP_EXCHANGE_LIST
Comma-separated list of exchanges names.
###### Example
```dotenv
AMQP_EXCHANGE_LIST="default,sms,email"
```
###### Default value "default"


### AMQP_CHANNEL_LIST
Comma-separated list of channel names.
```dotenv
AMQP_CHANNEL_LIST="default,sms,email"
```
###### Default value "default"



### AMQP_PUBLISHER_LIST
Comma-separated list of publishers names.
###### Example
```dotenv
AMQP_CHANNEL_LIST="default,sms_sender,email_sender"
```
###### Default value "default"




### AMQP_CONSUMER_LIST
Comma-separated list of consumers names.
```dotenv
AMQP_CHANNEL_LIST="default,sms_consumer,email_consumer"
```
###### Default value "default"






## Publisher configuration

### AMQP_PUBLISHER_\<publisher name>_CONNECTION
Connection alias
###### Example
```dotenv
AMQP_PUBLISHER_SMS_SENDER_CONNECTION="other_connection"
```
###### Default value: "default"




### AMQP_PUBLISHER_\<publisher name>_CHANNEL
Channel alias
###### Example
```dotenv
AMQP_PUBLISHER_SMS_SENDER_CHANNEL="sms_channel"
```
###### Default value: "default"


### AMQP_PUBLISHER_\<publisher name>_EXCHANGE
Exchange alias
###### Example
```dotenv
AMQP_PUBLISHER_SMS_SENDER_EXCHANGE="sms_exchange"
```
###### Default value: "default"


### AMQP_PUBLISHER_\<publisher name>_CONTENT_TYPE
Publisher content type
```dotenv
AMQP_PUBLISHER_SMS_SENDER_CONTENT_TYPE="application/json"
```
###### Default value: "plaint/text"

### AMQP_PUBLISHER_\<publisher name>_DELIVERY_MODE
Messages marked as 'persistent' that are delivered to 'durable' queues will be logged to disk. Durable queues are recovered in the event of a crash, along with any persistent messages they stored prior to the crash.

Available values:
##### DELIVERY_MODE_PERSISTENT
##### DELIVERY_MODE_NON_PERSISTENT

###### Example:
```dotenv
AMQP_PUBLISHER_SMS_SENDER_DELIVERY_MODE="DELIVERY_MODE_PERSISTENT"
```
###### Default value: "DELIVERY_MODE_PERSISTENT"
###### Default configuration
```dotenv
AMQP_PUBLISHER_DEFAULT_DELIVERY_MODE="DELIVERY_MODE_PERSISTENT"
```


## Consumer configuration

### AMQP_CONSUMER_\<consumer name>_TAG
### AMQP_CONSUMER_\<consumer name>_CHANNEL
### AMQP_CONSUMER_\<consumer name>_CONNECTION
### AMQP_CONSUMER_\<consumer name>_QUEUE
### AMQP_CONSUMER_\<consumer name>_NO_WAIT
### AMQP_CONSUMER_\<consumer name>_EXCLUSIVE
### AMQP_CONSUMER_\<consumer name>_NO_ACK
### AMQP_CONSUMER_\<consumer name>_NO_LOCAL


## Channel configuration

### AMQP_CHANNEL_\<channel name>_BINDINGS

Bind queue to exchange.

###### Example bindings: 
```dotenv
AMQP_CHANNEL_EXAMPLE_BINDINGS="<queue_1>:<exchange_1>,<queue_2>:<exchange_2>:<connection_2>"
```

###### Default config
```dotenv
AMQP_CHANNEL_DEFAULT_BINDINGS="default:default:default"
```
