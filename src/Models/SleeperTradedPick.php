<?php
namespace DanAbrey\SleeperApi\Models;

final class SleeperTradedPick
{
    public int $season;
    public int $round;
    public int $roster_id;
    public int $previous_owner_id;
    public int $owner_id;
}