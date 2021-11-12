<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lead::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->username(),
            'email' => $this->faker->unique()->safeEmail(),
            'nif' => Str::random(10),
            'details' => Str::random(10),
            'phone' => $this->faker->e164PhoneNumber(),
            'mobile_phone' => $this->faker->e164PhoneNumber(),
            'company_id' => $this->obtainCompanyId(),
            'deleted_at' => NULL
        ];
    }

    public function obtainCompanyId(): ?Company
    {
        $company = Company::orderBy('id')->take(400)->get()->random(1);

        return $company[0];
    }
}
