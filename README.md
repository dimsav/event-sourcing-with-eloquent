# Event Sourcing with Laravel's Eloquent

This is an app demonstrationg how to implement event sourcing with eloquent.

### How to setup

- Clone
- Setup .env 
- Run composer install
- Run migrations

### How to use

To understand how to execute event sourcing, see the [test file](https://github.com/dimsav/event-sourcing-with-eloquent/blob/master/tests/Feature/OrderTest.php).

### Basic classes

- [Order root model](https://github.com/dimsav/event-sourcing-with-eloquent/blob/master/app/Order/Order.php)
- [Events](https://github.com/dimsav/event-sourcing-with-eloquent/tree/master/app/Order/Events)
- [Event listener](https://github.com/dimsav/event-sourcing-with-eloquent/blob/master/app/Observers/OrderEventObserver.php)

### Eloquent classes

- [OrderEventModel](https://github.com/dimsav/event-sourcing-with-eloquent/blob/master/app/Models/OrderEventModel.php)
- [MvOrder](https://github.com/dimsav/event-sourcing-with-eloquent/blob/master/app/Models/MvOrder.php) aka Projector
- [UpdateMvOrder job](https://github.com/dimsav/event-sourcing-with-eloquent/blob/master/app/Jobs/UpdateMvOrder.php) is responsible for updating MvOrder models.
