### 1. PHPUnit: Secure the Park

Вместо `composer require --dev phpunit/phpunit`

лучше устанавливать `composer require --dev symfony/phpunit-bridge`


### 2. Tests, Assertions & Coding

TDD - test first


### 3. TDD & Unit, Integration & Functional Tests

Немного теории.

Unit - изолированные. Один тест тестирует только 1 класс

Integration - почти как Unit но используют реально подключение к базе, например.

Functional - в браузере

Когда тестировать? Когда меня пугает этот функционал.

TDD:
1. Create the test
2. Write just enough code for the test pass
3. Refactor

Вообщем, когда добавляешь новую функцию, лучше это делать по TDD.


### 4. TDD in Practice

Начинаем прям с хардкода.
Потом добавляем новый функционал с test first.