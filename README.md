# Sleeper API

PHP library for interacting with the read-only [Sleeper fantasy football API](https://docs.sleeper.app/).
## Installation

`composer require danabrey/sleeper-api`

## Usage

Create an instance of the client

`$client = new DanAbrey\SleeperApi\SleeperApiClient();`

No API key is required for the Sleeper API, as it is read-only and they do not track requests in this way.

`$client->league('xxxxx')` where xxxxx is the league ID, for basic league info
`$client->rosters('xxxxx')` where xxxxx is the league ID, for all rosters
`$client->users('xxxxx')` where xxxxx is the league ID, for all users in a league

All methods return either a single instance or an array of plain PHP objects that represent the data returned. e.g. `SleeperRoster` 

## Note

It is your responsibility to abide by the [terms of the Sleeper API](https://docs.sleeper.app/).

### Running tests

`./vendor/bin/phpunit`