<?php

namespace Database\Seeders;

use Illuminate\Console\View\Components\TwoColumnDetail;
use Illuminate\Database\Seeder;

abstract class BaseSeeder extends Seeder
{
    /**
     * @param string $error
     * @return void
     */
    public function error(string $error): void
    {
        with(new TwoColumnDetail($this->command->getOutput()))->render(
            '<fg=red>' . $error . '</>',
            '<fg=red;options=bold>ERROR</>'
        );
    }
}
