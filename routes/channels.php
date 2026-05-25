<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('cage.{cageId}', function ($user, $cageId) {
    return $user !== null;
});
