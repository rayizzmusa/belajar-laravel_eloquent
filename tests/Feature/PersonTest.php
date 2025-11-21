<?php

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $person = new Person();
        $person->first_name = "Syifa";
        $person->last_name = "Aulia";
        $person->save();

        self::assertEquals("Syifa Aulia", $person->full_name);

        $person->full_name = "Rayhan Muhammad";
        $person->save();

        self::assertEquals("Rayhan", $person->first_name);
        self::assertEquals("Muhammad", $person->last_name);
    }
}
