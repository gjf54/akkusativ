# AKKUSATIV (AKK.)

Akkusativ - это pet-проект, направленный на эксперементирование (с хорошим и не очень результатом) и параллельное изучение отдельных принципов и технологий используемого ПО.

Akkusativ - это минималистичный мессенджер, позволяющий пользователям обмениваться простыми текстовыми сообщениями.

Стек: php (Laravel), js (Vue3 (Composition + Options)), Docker, Nginx и прочее.

# Общая архитектура 

Архитектура представляет из себя монолит с явным (достоверным) разеделением серверной и клиентской части (посредством API). 

Серверная часть характеризуется использованием:

- Моделей
- Контроллеров
- Маршрутов (API)
- Миграций (Да.)
- Сервисов (Кастомный класс + stub-шаблон)

```
php artisan make:service Path/To/<Name>
```

- Middleware
- Service-контейнеров
- Ивентов 
- Jobs
- Каналов
- Ресурсов и запросов
- Наблюдателей 
- Docker (php-fpm, mysql, worker, nginx+ssl)
- Доктрины поверх ORM (Практика использования костылей и не только.)

Клинетская часть характеризуется использованием:

- JS (Да.)
- Vue3 (В текущем проекте много Options API, переписывается по мере надобности)
- Axios
- Vue Router

# Серверная составляющая

## Аутентификация (Sanctum)
Реализована на основе http-only куках (bearer). Запрос перехватывается промежуточным слоем, где модифицируются его заголовки (Authorization, Accept).

## Сокеты

Драйвер - база данных, в планах внедрение RabbitMQ. Обеспечение каналов реализует Pusher.

## Маршрутизация

Одна ключевая особенность: если маршрут не перехватывается клинетской частью, идет переадрессация на базовый blade-шаблон.

## Концептуальный слой данных

Сущности: 

- Пользователь
- Чат
- Сообщение

Отношения:

- Пользователь -> Чат (n:n)
- Чат -> Сообщение (1:n)
- Пользователь -> Сообщение (1:n)

## Общая информация

Разработка велась согласно принципам SOLID: во всех сущностях однозначно прослеживается инверсия зависимости, нет "объектов бога" (упрощенная логика обеспечиваетя сервисами). В реализации выдержаны принципы REST API.

# Клиентская составляющая 

## Компоненты

В проекте поддерживалась идея переиспользуемости компонентов. Из-за небольшой вложенности в основе используется prop drilling. Данные обеспечиваются функциональностью axios.

## Сокеты

Тут Laravel Echo.

## Общая информация

В проекте пока что JS, в планах переход на что-то более типизированное. Работа построена через vite посредством плагина для vue (plugin-vue). 

# Докментация API

## Аутентификация

Для входа и регистрации предусмотрен возврат токена в куке вместе с ответом.

#### Вход

```http
  POST /api/auth/login
```

```
Тело запроса

{
    "login": "test",
    "password": "123123"
}
```

```
Тело ответа

{
    "token": "token",
    "login": "test",
    "ttl": 34560000 
}
```

#### Регистрация

```http
  POST /api/auth/login
```

```
Тело запроса

{
    "login": "test111",
    "password": "123123",
    "password_repeat": "123123"
}
```

```
Тело ответа

{
    "token": "token",
    "login": "test111",
    "ttl": 34560000 
}
```

#### Выход

```http
  GET /api/auth/logout
```

# Пользователи

#### Аутентифицированный пользователь

```http
  GET /api/user
```

```
Тело ответа

{
    "id": 1,
    "login": "test",
    "name": "Test User",
    "email": "qcrona@example.org",
    "email_verified_at": "2026-01-28T13:58:55.000000Z",
    "two_factor_secret": null,
    "two_factor_recovery_codes": null,
    "two_factor_confirmed_at": null,
    "created_at": "2026-01-28T13:58:55.000000Z",
    "updated_at": "2026-01-28T13:58:55.000000Z"
}
```

#### Пользователь по логину

```http
  GET /api/user/{login}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `login`      | `string` | **Required**. Логин пользователя.         |

```
Тело ответа

{
    "id": 1,
    "login": "test111",
    "name": "Test User",
    "email": "qcrona@example.org",
    "email_verified_at": "2026-01-28T13:58:55.000000Z",
    "two_factor_secret": null,
    "two_factor_recovery_codes": null,
    "two_factor_confirmed_at": null,
    "created_at": "2026-01-28T13:58:55.000000Z",
    "updated_at": "2026-01-28T13:58:55.000000Z"
}
```

## Чаты 

В реализации не предусмотрена высокая нагрузка (> 100 чатов). В планах разработка динамичной подгрузки.

#### Чаты пользователя

```http
  GET /api/chats
```

```
Тело ответа

{
        "chat": {
            "id": 2,
            "name": null,
            "created_at": "2026-01-28T14:01:46.000000Z",
            "updated_at": "2026-01-28T14:01:50.000000Z",
            "pivot": {
                "user_id": 1,
                "chat_id": 2
            },
            "users": [
                {
                    "id": 1,
                    "login": "test",
                    "name": "Test User",
                    "email": "qcrona@example.org",
                    "email_verified_at": "2026-01-28T13:58:55.000000Z",
                    "two_factor_secret": null,
                    "two_factor_recovery_codes": null,
                    "two_factor_confirmed_at": null,
                    "created_at": "2026-01-28T13:58:55.000000Z",
                    "updated_at": "2026-01-28T13:58:55.000000Z",
                    "pivot": {
                        "chat_id": 2,
                        "user_id": 1
                    }
                },
                {
                    "id": 3,
                    "login": "test2",
                    "name": "Test User",
                    "email": "kariane93@example.org",
                    "email_verified_at": "2026-01-28T13:58:55.000000Z",
                    "two_factor_secret": null,
                    "two_factor_recovery_codes": null,
                    "two_factor_confirmed_at": null,
                    "created_at": "2026-01-28T13:58:56.000000Z",
                    "updated_at": "2026-01-28T13:58:56.000000Z",
                    "pivot": {
                        "chat_id": 2,
                        "user_id": 3
                    }
                }
            ]
        },
        "last_message": {
            "id": 9,
            "message": "a",
            "user_login": "test",
            "created_at": "05:01, 28.01.2026"
        },
        "users": [
            {
                "login": "test2",
                "name": "Test User"
            }
        ]
    },
    {
        "chat": {
            "id": 1,
            "name": null,
            "created_at": "2026-01-28T13:58:56.000000Z",
            "updated_at": "2026-01-28T14:01:37.000000Z",
            "pivot": {
                "user_id": 1,
                "chat_id": 1
            },
            "users": [
                {
                    "id": 1,
                    "login": "test",
                    "name": "Test User",
                    "email": "qcrona@example.org",
                    "email_verified_at": "2026-01-28T13:58:55.000000Z",
                    "two_factor_secret": null,
                    "two_factor_recovery_codes": null,
                    "two_factor_confirmed_at": null,
                    "created_at": "2026-01-28T13:58:55.000000Z",
                    "updated_at": "2026-01-28T13:58:55.000000Z",
                    "pivot": {
                        "chat_id": 1,
                        "user_id": 1
                    }
                },
                {
                    "id": 2,
                    "login": "test1",
                    "name": "Test User",
                    "email": "dangelo.rodriguez@example.net",
                    "email_verified_at": "2026-01-28T13:58:55.000000Z",
                    "two_factor_secret": null,
                    "two_factor_recovery_codes": null,
                    "two_factor_confirmed_at": null,
                    "created_at": "2026-01-28T13:58:55.000000Z",
                    "updated_at": "2026-01-28T13:58:55.000000Z",
                    "pivot": {
                        "chat_id": 1,
                        "user_id": 2
                    }
                }
            ]
        },
        "last_message": {
            "id": 8,
            "message": "a",
            "user_login": "test",
            "created_at": "05:01, 28.01.2026"
        },
        "users": [
            {
                "login": "test1",
                "name": "Test User"
            }
        ]
    }
```

# Полезные ссылки

Моё резюме: https://clck.ru/3RXzMj














