<?php

use Carbon\Carbon;

function tglIndo($tanggal)
{
    return Carbon::parse($tanggal)
        ->locale('id')
        ->translatedFormat('d F Y');
}
