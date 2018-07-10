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