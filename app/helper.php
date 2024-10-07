<?php

use App\Models\SiteSetting;

function setting($key) {
    return SiteSetting::first()->{$key};
}

?>