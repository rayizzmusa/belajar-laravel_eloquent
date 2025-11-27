<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeFactoryTest extends TestCase
{
    public function testFactory()
    {
        $employe1 = Employee::factory()->programmer()->create([ //atau bisa menggunakan make 
            "id" => "1",
            "name" => "Employee 2"
        ]);
        self::assertNotNull($employe1);

        $employe2 = Employee::factory()->seniorProgrammer()->make();
        $employe2->id = "2";
        $employe2->name = "Employee 2";
        $employe2->save();

        self::assertNotNull(Employee::where("id", "2")->first());
    }
}
