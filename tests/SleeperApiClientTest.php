<?php

use DanAbrey\SleeperApi\Models\SleeperLeague;
use DanAbrey\SleeperApi\Models\SleeperLeagueUser;
use DanAbrey\SleeperApi\Models\SleeperRoster;
use DanAbrey\SleeperApi\Models\SleeperUser;
use DanAbrey\SleeperApi\Models\SleeperDraft;
use DanAbrey\SleeperApi\Models\SleeperDraftSettings;
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
        $this->assertEquals('2019', $league->season);
        $this->assertCount(18, $league->roster_positions);
        $this->assertInstanceOf(\DanAbrey\SleeperApi\Models\SleeperLeagueSettings::class, $league->settings);
    }

    public function testLeagues()
    {
        $data = file_get_contents(__DIR__ . '/_data/leagues.json');
        $responses = [
            new MockResponse($data),
        ];
        $httpClient = new MockHttpClient($responses);
        $this->client->setHttpClient($httpClient);

        $leagues = $this->client->leagues('442097181638258688', '2020');

        $this->assertIsArray($leagues);
        $this->assertInstanceOf(SleeperLeague::class, $leagues[0]);
        $this->assertEquals('Juggernaut', $leagues[0]->name);
    }

    public function testUser()
    {
        $data = file_get_contents(__DIR__ . '/_data/user.json');
        $responses = [
            new MockResponse($data),
        ];
        $httpClient = new MockHttpClient($responses);
        $this->client->setHttpClient($httpClient);

        $user = $this->client->user('77434934499098624');

        $this->assertInstanceOf(SleeperUser::class, $user);
        $this->assertEquals('danabrey', $user->username);
        $this->assertEquals('danabrey', $user->display_name);
        $this->assertEquals('77434934499098624', $user->user_id);
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

    public function testRostersWithEmptyRoster()
    {
        $data = file_get_contents(__DIR__ . '/_data/rosters-with-empty.json');
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
        $this->assertCount(0, $rosters[0]->players);
    }

    public function testDrafts()
    {
        $data = file_get_contents(__DIR__ . '/_data/drafts.json');
        $responses = [
            new MockResponse($data),
        ];
        $httpClient = new MockHttpClient($responses);
        $this->client->setHttpClient($httpClient);

        $drafts = $this->client->drafts('442097181638258688');

        $this->assertIsArray($drafts);
        $this->assertInstanceOf(\DanAbrey\SleeperApi\Models\SleeperDraft::class, $drafts[0]);
        $this->assertEquals('pre_draft', $drafts[0]->status);
        $this->assertEquals('784369892051832833', $drafts[0]->draft_id);
        $this->assertEquals(12, $drafts[0]->settings->teams);
        $this->assertEquals(5, $drafts[0]->settings->rounds);
    }

    public function testTradedPicks()
    {
        $data = file_get_contents(__DIR__ . '/_data/traded_picks.json');
        $responses = [
            new MockResponse($data),
        ];
        $httpClient = new MockHttpClient($responses);
        $this->client->setHttpClient($httpClient);

        $picks = $this->client->tradedPicks('442097181638258688');

        $this->assertIsArray($picks);
        $this->assertInstanceOf(\DanAbrey\SleeperApi\Models\SleeperTradedPick::class, $picks[0]);
        $this->assertEquals(2022, $picks[1]->season);
        $this->assertEquals(2, $picks[1]->round);
        $this->assertEquals(1, $picks[1]->roster_id);
        $this->assertEquals(1, $picks[1]->previous_owner_id);
        $this->assertEquals(2, $picks[1]->owner_id);
    }
}
