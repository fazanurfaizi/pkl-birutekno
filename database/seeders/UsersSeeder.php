<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Company;
use Faker\Factory;
use Illuminate\Support\Arr;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $companies = Company::all();

        $userList = [
            "Adriana C. Ocampo Uria",
            "Albert Einstein",
            "Anna K. Behrensmeyer",
            "Blaise Pascal",
            "Caroline Herschel",
            "Cecilia Payne-Gaposchkin",
            "Chien-Shiung Wu",
            "Dorothy Hodgkin",
            "Edmond Halley",
            "Edwin Powell Hubble",
            "Elizabeth Blackburn",
            "Enrico Fermi",
            "Erwin Schroedinger",
            "Flossie Wong-Staal",
            "Frieda Robscheit-Robbins",
            "Geraldine Seydoux",
            "Gertrude B. Elion",
            "Ingrid Daubechies",
            "Jacqueline K. Barton",
            "Jane Goodall",
            "Jocelyn Bell Burnell",
            "Johannes Kepler",
            "Lene Vestergaard Hau",
            "Lise Meitner",
            "Lord Kelvin",
            "Maria Mitchell",
            "Marie Curie",
            "Max Born",
            "Max Planck",
            "Melissa Franklin",
            "Michael Faraday",
            "Mildred S. Dresselhaus",
            "Nicolaus Copernicus",
            "Niels Bohr",
            "Patricia S. Goldman-Rakic",
            "Patty Jo Watson",
            "Polly Matzinger",
            "Richard Phillips Feynman",
            "Rita Levi-Montalcini",
            "Rosalind Franklin",
            "Ruzena Bajcsy",
            "Sarah Boysen",
            "Shannon W. Lucid",
            "Shirley Ann Jackson",
            "Sir Ernest Rutherford",
            "Sir Isaac Newton",
            "Stephen Hawking",
            "Werner Karl Heisenberg",
            "Wilhelm Conrad Roentgen",
            "Wolfgang Ernst Pauli",
        ];

        foreach ($userList as $fullName) {
            $name = str_replace(' ', '.', $fullName);
            $roleName = ['admin', 'client', 'employee'];
            $user = \App\Models\User::create([
                'username' => $name,
                'fullname' => $fullName,
                'role' => Arr::random($roleName),
                'company_id' => $companies->random()->id,
                'email_verified_at' => now(),
                'email' => strtolower($name) . '@gmail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]);
        }
    }
}
