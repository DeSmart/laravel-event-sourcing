# Laravel Event Sourcing example

Here you can find some simple example of events and projection usage.
_Note, this is purely abstract and some enhancements should be applied in order to have fully working example._

Contents:
- `config` directory contains configuration files,
- `database/migrations` directory contains example migrations for event store and projection,
- `Domain` directory contains domain part of this example, so aggregate, events, commands and command handlers and repository interface classes,
- `WebPlugin` directory contains simple controller, implementation of repository as well as simple projection.

For handling commands [`desmart/laravel-commandbus`](https://github.com/DeSmart/laravel-commandbus) package is (can be) used.