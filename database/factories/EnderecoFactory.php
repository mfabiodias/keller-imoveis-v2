<?php

namespace Database\Factories;

use App\Models\Endereco;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnderecoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Endereco::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $estado   = ["SP", "BA", "PR", "PE", "MG"];
        $rel_id   = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
        $rel_type = ['cliente', 'imovel'];

        return [
            'rel_id'      => $rel_id[rand(0,(count($rel_id)-1))],
            'rel_type'    => $rel_type[rand(0,(count($rel_type)-1))],
            'cep'         => rand(11111111,99999999),
            'rua'         => $this->faker->address,
            'numero'      => rand(230,9999),
            'complemento' => "",
            'bairro'      => $this->faker->name,
            'cidade'      => $this->faker->city,
            'estado'      => $estado[rand(0,(count($estado)-1))],
        ];
    }
}
