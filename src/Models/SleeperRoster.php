<?php
namespace DanAbrey\SleeperApi\Models;

final class SleeperRoster
{
    public string $roster_id;
    public string $owner_id;
    /**
     * @var array|string[]
     */
    public array $players;
}
