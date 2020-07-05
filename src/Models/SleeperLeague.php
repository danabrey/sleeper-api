<?php
namespace DanAbrey\SleeperApi\Models;

final class SleeperLeague
{
    public string $league_id;
    public string $name;
    public array $roster_positions;
    public SleeperLeagueSettings $settings;
}
