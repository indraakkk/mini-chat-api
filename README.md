# mini-chat-api

This mini-chat-api project created on top of Laravel 8.0 store data to MySql

##### Login or create new user

```json
"request": {
    "url": "{{url}}/api/v1/login",
    "method": "POST",
    "body": {
        "mode": "raw",
        "raw": {
            "name": "ardni",
            "email": "ardni@mail.com"
        }
    }
}

"return": {
    "success": true,
    "message": "success",
    "data": [
        {
            "id": 2,
            "uuid": "829fe4fe-28a7-4824-9416-3a66de6d8f27",
            "name": "ardni",
            "email": "ardni@mail.com",
            "created_at": "2021-11-24T09:36:50.000000Z",
            "updated_at": "2021-11-24T09:36:50.000000Z",
            "rooms": [
                {
                    "id": 1,
                    "uuid": "c602cc56-e5d1-4403-b759-00faa81e58db",
                    "room_id": "3009246677",
                    "unread": 0,
                    "user_uuid": "829fe4fe-28a7-4824-9416-3a66de6d8f27",
                    "created_at": "2021-11-25T02:32:41.000000Z",
                    "updated_at": "2021-11-25T02:32:41.000000Z"
                },
                {
                    "id": 3,
                    "uuid": "15823771-be02-4fc4-b519-38ba2e9a7433",
                    "room_id": "9604483840",
                    "unread": 0,
                    "user_uuid": "829fe4fe-28a7-4824-9416-3a66de6d8f27",
                    "created_at": "2021-11-25T02:37:32.000000Z",
                    "updated_at": "2021-11-25T02:37:32.000000Z"
                }
            ]
        }
    ],
    "code": 200,
    "version": "1.0"
}
```

##### Create room


```json
"request": {
    "url": "{{url}}/api/v1/create",
    "method": "POST",
    "body": {
        "mode": "raw",
        "raw": {
            "from_user_uuid": "829fe4fe-28a7-4824-9416-3a66de6d8f27",
            "to_user_uuid": "39ecd35c-c0b4-4c33-892e-cd07b00bc9a5"
        }
    }
}

"return": {
    "success": true,
    "message": "success",
    "data": [
        {
            "id": 3,
            "uuid": "39ecd35c-c0b4-4c33-892e-cd07b00bc9a5",
            "name": "artup",
            "email": "artup@mail.com",
            "created_at": "2021-11-24T09:37:01.000000Z",
            "updated_at": "2021-11-24T09:37:01.000000Z",
            "rooms": [
                {
                    "id": 2,
                    "uuid": "443576a0-2123-4a52-aa1a-e16032898a2f",
                    "room_id": "3009246677",
                    "unread": 0,
                    "user_uuid": "39ecd35c-c0b4-4c33-892e-cd07b00bc9a5",
                    "created_at": "2021-11-25T02:32:41.000000Z",
                    "updated_at": "2021-11-25T02:32:41.000000Z"
                }
            ]
        }
    ],
    "code": 200,
    "version": "1.0"
}
```

#### Send chat

```json
"request": {
    "url": "{{url}}/api/v1/send",
    "method": "POST",
    "body": {
        "mode": "raw",
        "raw": {
            "user_uuid": "39ecd35c-c0b4-4c33-892e-cd07b00bc9a5",
            "to_user_uuid": "829fe4fe-28a7-4824-9416-3a66de6d8f27",
            "room_id": "3009246677",
            "message": "hi ardni test 1"
        }
    }
}

"return" : {
    "success": true,
    "message": "success",
    "data": [
        {
            "id": 3,
            "uuid": "5edd144d-bce7-44c4-9951-d965b82afef6",
            "message": "hi artup",
            "user_uuid": "829fe4fe-28a7-4824-9416-3a66de6d8f27",
            "room_id": "3009246677",
            "created_at": "2021-11-25T03:14:16.000000Z",
            "updated_at": "2021-11-25T03:14:16.000000Z"
        },
        {
            "id": 4,
            "uuid": "09b756fb-d409-47eb-a2cd-935f458aebb1",
            "message": "hi ardni",
            "user_uuid": "39ecd35c-c0b4-4c33-892e-cd07b00bc9a5",
            "room_id": "3009246677",
            "created_at": "2021-11-25T03:14:26.000000Z",
            "updated_at": "2021-11-25T03:14:26.000000Z"
        }
    ],
    "code": 200,
    "version": "1.0"
}
```

#### List room of user

```json
"request": {
    "url": "{{url}}/api/v1/list/829fe4fe-28a7-4824-9416-3a66de6d8f27",
    "method": "GET"
}

"return": {
    "success": true,
    "message": "success",
    "data": [
        {
            "id": 2,
            "uuid": "829fe4fe-28a7-4824-9416-3a66de6d8f27",
            "name": "ardni",
            "email": "ardni@mail.com",
            "created_at": "2021-11-24T09:36:50.000000Z",
            "updated_at": "2021-11-24T09:36:50.000000Z",
            "rooms": [
                {
                    "id": 1,
                    "uuid": "c602cc56-e5d1-4403-b759-00faa81e58db",
                    "room_id": "3009246677",
                    "unread": 0,
                    "user_uuid": "829fe4fe-28a7-4824-9416-3a66de6d8f27",
                    "created_at": "2021-11-25T02:32:41.000000Z",
                    "updated_at": "2021-11-25T03:42:55.000000Z"
                },
                {
                    "id": 3,
                    "uuid": "15823771-be02-4fc4-b519-38ba2e9a7433",
                    "room_id": "9604483840",
                    "unread": 0,
                    "user_uuid": "829fe4fe-28a7-4824-9416-3a66de6d8f27",
                    "created_at": "2021-11-25T02:37:32.000000Z",
                    "updated_at": "2021-11-25T02:37:32.000000Z"
                }
            ]
        }
    ],
    "code": 200,
    "version": "1.0"
}
```

#### List chat of user

```json
"request": {
    "url": "{{url}}/api/v1/chats",
    "method": "POST",
    "body": {
        "mode": "raw",
        "raw": {
            "user_uuid": "829fe4fe-28a7-4824-9416-3a66de6d8f27",
            "room_id": "3009246677"
        }
    }
}

"return": {
    "success": true,
    "message": "success",
    "data": [
        {
            "id": 3,
            "uuid": "5edd144d-bce7-44c4-9951-d965b82afef6",
            "message": "hi artup",
            "user_uuid": "829fe4fe-28a7-4824-9416-3a66de6d8f27",
            "room_id": "3009246677",
            "created_at": "2021-11-25T03:14:16.000000Z",
            "updated_at": "2021-11-25T03:14:16.000000Z"
        },
        {
            "id": 4,
            "uuid": "09b756fb-d409-47eb-a2cd-935f458aebb1",
            "message": "hi ardni",
            "user_uuid": "39ecd35c-c0b4-4c33-892e-cd07b00bc9a5",
            "room_id": "3009246677",
            "created_at": "2021-11-25T03:14:26.000000Z",
            "updated_at": "2021-11-25T03:14:26.000000Z"
        },
        {
            "id": 5,
            "uuid": "ed1139ab-abea-460b-a245-ecac285a8a0f",
            "message": "hi artup test 1",
            "user_uuid": "829fe4fe-28a7-4824-9416-3a66de6d8f27",
            "room_id": "3009246677",
            "created_at": "2021-11-25T03:21:25.000000Z",
            "updated_at": "2021-11-25T03:21:25.000000Z"
        },
        {
            "id": 6,
            "uuid": "cf5af60f-6b64-4a06-a097-8429618936fe",
            "message": "hi ardni test 1",
            "user_uuid": "39ecd35c-c0b4-4c33-892e-cd07b00bc9a5",
            "room_id": "3009246677",
            "created_at": "2021-11-25T03:21:49.000000Z",
            "updated_at": "2021-11-25T03:21:49.000000Z"
        }
    ],
    "code": 200,
    "version": "1.0"
}
```
##### Route List

```
+----------+---------------------+------+------------------------------------------------------------+
| Method   | URI                 | Name | Action                                                     |
+----------+---------------------+------+------------------------------------------------------------+
| POST     | api/v1/chats        |      | App\Http\Controllers\Api\ChatController@listUserChat       |
| POST     | api/v1/create       |      | App\Http\Controllers\Api\ChatController@createChat         |
| GET|HEAD | api/v1/list/{uuid}  |      | App\Http\Controllers\Api\ChatController@listUserRooms      |
| POST     | api/v1/login        |      | App\Http\Controllers\Api\ChatController@loginOrCreate      |
| POST     | api/v1/send         |      | App\Http\Controllers\Api\ChatController@sendChat           |
+----------+---------------------+------+------------------------------------------------------------+
```
