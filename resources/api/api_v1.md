FORMAT: 1A
HOST: https://announcementsapp.herokuapp.com/api/v1

# Announcements API

Announcements API Documentation v1.0

# Group API

## About [/]

Rest API Documentation v1.0 for the Announcements App

# Group Message

## Messages [/messages]

### Create a Message [POST]
Create Messages

+ Request (application/json)

+ Attributes (Message Base)

+ Response 201 (application/json)
    + Attributes (Message)

### List Messages [GET]
List Messages

+ Response 200 (application/json)

    + Attributes (Messages)

## Message [/messages/{id}]

+ Parameters
    + id: `1` (number, required) - Message ID

### View Message [GET]
View Message

+ Response 200 (application/json)

    + Attributes (Message Updated)

### Update Message [PUT]
Update Message.

+ Request (application/json)

+ Attributes (Message Update)

+ Response 200 (application/json)

    + Attributes (Message Updated)

### Delete Message [DELETE]
Delete Message.

+ Response 200 (application/json)

# Data Structures

## Message Base (object)
+ subject: `Subject` (string) - Subject (required)
+ content: `Content` (string) - Content (required)
+ start_date: `2019-01-01 00:00:00` (string) - Start Date (required)
+ expiration_date: `2019-01-31 23:59:59` (string) - Expiration Date (required)

## Message Update (object)
+ id: `1` (number) - Message Id
+ subject: `Subject` (string) - Subject (required)
+ content: `Content` (string) - Content (required)
+ start_date: `2019-01-01 00:00:00` (string) - Start Date (required)
+ expiration_date: `2019-01-31 23:59:59` (string) - Expiration Date (required)

## Message Updated
+ data (Message, required)

## Messages
+ data (array[Message], required)

## Message (object)
+ id (number) - Message Id
+ subject: `Subject` (string) - Subject
+ content: `Content` (string) - Content
+ start_date: `2019-01-01 00:00:00`  (string) - Start Date
+ expiration_date: `2019-01-31 23:59:59` (string) - Expiration Date
+ created_at: `2019-01-01 12:00:00` (string) - Created At
+ updated_at: `2019-01-01 12:00:00` (string) - Updated At