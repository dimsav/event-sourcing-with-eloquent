<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @return \Faker\Generator
     */
    protected function faker()
    {
        return \Faker\Factory::create();
    }

    protected function newUserId()
    {
        return factory(User::class)->create()->id;
    }

}
