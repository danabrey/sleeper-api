<?php
namespace DanAbrey\SleeperApi\Models;

final class SleeperLeague
{
    public string $league_id;
    public ?string $previous_league_id;
    public string $name;
    public array $roster_positions;
    public string $season;
    public SleeperLeagueSettings $settings;
}
