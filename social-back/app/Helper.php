<?php
function getTooltip(String $textPath, String $placement='top'){

    $text = config('tooltip.' . $textPath);
    if($text){
        return <<<T
<small data-bs-toggle="tooltip" data-bs-placement="top" title="$text">
    <i class="bi bi-question-circle-fill"></i>
</small>
T;
    }

}