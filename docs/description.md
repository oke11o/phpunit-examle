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


### 5. Factory Testing

Все то же TDD на практике


### 6. Hooks: setUp, tearDown & Skipping Tests

setUp() and tearDown() before/after each test

setUpBeforeClass() and tearDownAfterClass before/after testClass

onNotSuccessfulTest() !

Замечание: markTestSkipped - в собственном коде обычно не используют, но юзают в библиотеках, например, в ядре симфони


### 7. Data Providers!

В ключах @dataProvider можно указывать название data_set'a.


### 8. Coding, Adding Features, Refactoring

Второй пункт TDD. Чтобы проходили тесты.
Третий пункт уже по пройденным тестам - рефакторинг.


### 9. Handling Object Dependencies

Для сервисов нужны моки.
Для моделей - нет.


### 10. Testing Exceptions

TestCase::expectException() надо вызывать до того как будет выкинуто само исключение.

Но проще использовать аннотацию @expectException.


### 11. Exceptions Part 2: Adding Fence Security

vendor/bin/simple-phpunit --filter testItDoesNotAllowToAddDinosToUnsecureEnclosures

Все по шагам TDD


### 12. Refactoring & Dependency Injection

Сделали сервис, в который вынесли часть функционала фабрики. Фабрика сломалась. Изменился конструктор. Хорошо, что в тестах фабрику инициируем в одном месте setUp()


### 13. Mocks & Test Doubles

В UnitTest надо тестировать только логику класса, не надо в них тестировать логику других классов. Сейчас фабрика некак не считает длину. Поэтому надо удалить тесты связанные с длинной.


### 14. Mocks: Control the Return Value

Тут мы заюзали просто willReturn() на моке. То есть он всегда будет отдавать одно значение.
 
Если надо сымитировать зависимость от входных параметров можно заюзать willReturnValueMap().


### 15. Mocks: expects() Assert Method is Called Correctly

Добавили ожидаемые параметры вызова метода мока.

Так же у тестов есть методы anything(), atLeastOne(), callback()


### 16. Full Mock Example

Используем моки в конструкторах сервисов.


### 17. Full Mock Example: the Sequel

Если проверить dump'ом возвращаемое значение, то окажется Mock_Dinosaur_d0cb0669. Это благодаря хинтам.

Подведем итоги. Если нужен сервис - мокаем. Если модель - new().


### 18. Mocking with Prophecy

Для Prophecy есть отличные плагины PhpStorm "PHP Toolbox" and "PHPUnit Enhancement".


### 19. The Important CLI Options & phpunit.xml.dist

phpunit можно запускать с различными флагами. Как мы делали --filter. 
Так же интересный флаг - --debug.

Или даже например, запуск конкретного set'a из dataProvider'a.
```
./vendor/bin/phpunit --filter 'testItGrowsADinosaurFromASpecification #1' --debug
```

Можно добавить testsuite в phpunit.xml, а потом запускать только его
`./vendor/bin/phpunit --testsuite entities --debug`


### 20. Integration Tests

Моки это хорошо, пока это не плохо. Они тестируют изолированную логику. Но, например, подключение к базе - нет. А класс репозитория от этого сильно зависит.

Создадим базу и таблицы (схему)

`KernelTestCase extends TestCase` 

Для тест окружения делаем все сервисы публичными
```
services:
    _defaults:
        public: true
```

И делаем публичные алиасы для приватных сервисов. Добавляем префикс test.

Инжектим EntityManager и проверяем кол-во в репозитории.


### 21. Clearing the Database

Переопределяем `doctrine.dbal`. В данном случае на sqlite.

В setUp() добавим метод для truncate. Для начала напишем его вручную.

Но лучше поставить `composer require doctrine/data-fixtures --dev` и использовать `Doctrine\Common\DataFixtures\Purger\ORMPurger::purge()`


### 22. Partial Mocking

Типа частичные моки. То есть мы часть сервисов берем из контейнера. А часть можно замокать.

Тут пример того, как можно использовать willReturnCallback();

Когда пишу интеграционные тесты:
- Если логика пугает меня. Если логика простая - я не тестирую.
- Могу я оттестить логику Юнитами? 

Для меня вопрос еще остается открытым.


### 23. Functional Tests

По сути - это тест контролеров.

`composer require --dev liip/functional-test-bundle`

Наследуемся от этого бандла для WebTestCase.

В чем отличему BrowserKit vs Mink?
Второй делает настоящие http запросы. Но поэтому не нужно конфигурировать сервак. Ну и нельзя затестить js.