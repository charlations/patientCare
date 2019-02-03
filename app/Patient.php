<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
			'name', 'lastNames', 'gender', 'birthdate', 'idInsurance', 'email',
		];

		/**
     * Returns patient's age - Originally from: https://stackoverflow.com/questions/3776682/php-calculate-age
     * @param string $birthdate
     * @return int
     */
    public static function getAge(string $birthdate) {
			//explode the date to get month, day and year
			$birthdate = explode("-", $birthdate);
			$age = (date("md", date("U", mktime(0, 0, 0, $birthdate[2], $birthdate[1], $birthdate[0]))) > date("md")
				? ((date("Y") - $birthdate[0]) - 1)
				: (date("Y") - $birthdate[0]));
			return $age;
    }
}