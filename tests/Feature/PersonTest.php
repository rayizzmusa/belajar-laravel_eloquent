<?php

namespace Tests\Feature;

use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testAccessorMutator(): void
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
    } //yang ini pasti eror karena model nya sudah dirubah

    public function testAccessorMutatorSamaDenganKolom()
    {
        $person = new Person();
        $person->first_name = "Syifa";
        $person->last_name = "Aulia";
        $person->save();

        self::assertEquals("SYIFA Aulia", $person->full_name);

        $person->full_name = "Rayhan Muhammad";
        $person->save();

        self::assertEquals("RAYHAN", $person->first_name);
        self::assertEquals("Muhammad", $person->last_name);
    }

    public function testAttributeCasting()
    {
        $person = new Person();
        $person->first_name = "Syifa";
        $person->last_name = "Aulia";
        $person->save();

        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);
    }
}
