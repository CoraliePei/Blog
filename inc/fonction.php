<?php


function debug($tableau)
{
    echo '<pre style="height:100px;overflow-y: scroll;font-size:.5rem;padding: .6rem; font-family: Consolas, Monospace;background-color: #000;color:#fff;">';
    print_r($tableau);
    echo '</pre>';
}

function dateSite($date, $format = 'd/m/Y à H:i:s')
{
    return date($format, strtotime($date));
}
