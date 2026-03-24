<?php

namespace App\Concerns;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use TallStackUi\Traits\Interactions;

trait ErrorHandler
{
    use Interactions;
    public function exception($e, $stopPropagation)
    {
        if ($e instanceof ModelNotFoundException) {
            $this->dialog()->error('Error', 'Order not found')->send();
            $stopPropagation();
        }
    }
}
