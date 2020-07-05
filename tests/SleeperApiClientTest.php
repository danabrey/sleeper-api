<?php

use DanAbrey\SleeperApi\Models\SleeperLeague;
use DanAbrey\SleeperApi\Models\SleeperLeagueUser;
use DanAbrey\SleeperApi\Models\SleeperRoster;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class SleeperApiClientTest extends TestCase
{
    private \DanAbrey\SleeperApi\SleeperApiClient $client;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = new \DanAbrey\SleeperApi\SleeperApiClient();
    }

    public function testLeague()
    {
        $data = file_get_contents(__DIR__ . '/_data/league.json');
        $responses = [
            new MockResponse($data),
        ];
        $httpClient = new MockHttpClient($responses);
        $this->client->setHttpClient($httpClient);

        $league = $this->client->league('442097181638258688');

        $this->assertInstanceOf(SleeperLeague::class, $league);
        $this->assertEquals('442097181638258688', $league->league_id);
        $this->assertEquals('Freddo', $league->name);
        $this->assertCount(18, $league->roster_positions);
    }

    public function testUsers()
    {
        $data = file_get_contents(__DIR__ . '/_data/users.json');
        $responses = [
            new MockResponse($data),
        ];
        $httpClient = new MockHttpClient($responses);
        $this->client->setHttpClient($httpClient);

        $users = $this->client->users('442097181638258688');

        $this->assertIsArray($users);
        $this->assertInstanceOf(SleeperLeagueUser::class, $users[0]);
        $this->assertEquals('danabrey', $users[0]->display_name);
    }


    public function testRosters()
    {
        $data = file_get_contents(__DIR__ . '/_data/rosters.json');
        $responses = [
            new MockResponse($data),
        ];
        $httpClient = new MockHttpClient($responses);
        $this->client->setHttpClient($httpClient);

        $rosters = $this->client->rosters('442097181638258688');

        $this->assertIsArray($rosters);
        $this->assertInstanceOf(SleeperRoster::class, $rosters[0]);
        $this->assertEquals('419523462235701248', $rosters[0]->owner_id);

        $this->assertIsArray($rosters[0]->players);
        $this->assertTrue(in_array('4098', $rosters[0]->players));
    }
}
