<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class DatabaseTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testInsuranceTable()
    {
		DB::insert('insert into insurances (insuranceName, notes) values (?, ?)',
					['UnitInsurance', 'InsuranceNotes']);

        $this->assertDatabaseHas('insurances', [
		        'insuranceName' => 'UnitInsurance'
		    ]);

        DB::update('update insurances set insuranceName = ? where insuranceName = ?',
        			['UnitInsuranceUpdated', 'UnitInsurance']);

		$this->assertDatabaseHas('insurances', [
		        'insuranceName' => 'UnitInsuranceUpdated'
		    ]);

		$this->assertDatabaseMissing('insurances', [
		        'insuranceName' => 'UnitInsurance'
		    ]);

		DB::delete('delete from insurances where insuranceName = ?', ['UnitInsuranceUpdated']);

		$this->assertDatabaseMissing('insurances', [
		        'insuranceName' => 'UnitInsuranceUpdated'
		    ]);
    }
}
