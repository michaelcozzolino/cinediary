<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movie::class;

    private static int $id = 1;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => self::$id++,
            'title' => $this->faker->name(),
            'originalTitle' => $this->faker->name(),
            'genre' => $this->faker->word(),
            'posterPath' => $this->faker->imageUrl(),
            'backdropPath' => $this->faker->imageUrl(2000, 1000),
            'overview' => $this->faker->text(),
            'releaseDate' => $this->faker->date(),
            'runtime' => $this->faker->randomNumber(3),
        ];
    }
}
