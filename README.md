
````markdown

## 1. Предварительные настройки

```bash
# Запуск Docker
docker-compose up --build -d

# Миграции
php yii migrate --migrationPath=@yii/rbac/migrations
php yii migrate up

# Настройка RBAC
php yii rbac/init

# Синхронизация товаров
php yii sync/products
````

* Веб-логин: [`/site/login`](http://localhost:8000/site/login)
* Веб-сайнап: [`/site/signup`](http://localhost:8000/site/login)
* REST API: Bearer токен

```bash
curl -H "Authorization: Bearer YOUR_ACCESS_TOKEN" http://localhost:8000/api/order/1
```

---

## 2. CRUD и RBAC

### Сущности и URL

* **Product**: `/product/index`, `/product/view/1`, `/product/create`, `/product/update/1`, `/product/delete/1`
* **Order**: `/order/index`, `/order/view/1`, `/order/create`, `/order/update/1`, `/order/delete/1`
* **User**: `/user/index`, `/user/view/1`, `/user/create`, `/user/update/1`, `/user/delete/1`

### Роли

* `admin` — полный доступ

* `manager` — просмотр заказов, изменение статуса

* `customer` — создание заказов

* Валидации и автообработка в моделях (`rules()`, `beforeSave()`, `afterFind()`)

---

## 3. REST API (ЧПУ)

| Метод  | URL            | Действие          |
| ------ | -------------- | ----------------- |
| GET    | `/api/order`   | Список заказов    |
| GET    | `/api/order/1` | Просмотр заказа   |
| POST   | `/api/order`   | Создание заказа   |
| PUT    | `/api/order/1` | Обновление заказа |
| DELETE | `/api/order/1` | Удаление заказа   |

ЧПУ-примеры: `/order/123/view`, `/product/45/edit`
Авторизация через JWT/Bearer токен, проверка прав через RBAC.

---

## 4. Сервис с DI

* `ProductServiceInterface` → `ProductService`
* Внедрение через конструктор или `Yii::$container`
* Unit-тесты: `tests/unit/services/ProductServiceTest.php`

---

## 5. Роутинг

```php
'order/<id:\d+>/view' => 'order/view',
'product/<id:\d+>/edit' => 'product/update',
'admin/product/<id:\d+>/edit' => 'admin/product/update',
```

* Все контроллеры защищены `AccessControl` с проверкой ролей.

---

## 6. Запуск тестов

```

vendor/bin/phpunit tests/unit/components/services/DummyJsonSyncParserTest.php

```

## 6. Структура проекта

```
/controllers: ProductController, OrderController, UserController, AdminController
/models: Product, Order, User
/services: ProductServiceInterface, ProductService
/views: /product, /order, /user
/config: web.php
/tests/unit: ProductServiceTest.php
```
