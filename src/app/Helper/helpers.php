<?php

use Carbon\Carbon;

function verTime(): string
{
    return Carbon::now()->timestamp;
}
