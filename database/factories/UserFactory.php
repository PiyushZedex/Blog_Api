<?php

namespace Database\Factories;

use App\Db\DbUtil;
use App\Models\Blog;
use App\Models\User;
use App\Util\Constants;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
    public static $db1;
    public static function getDb1(){
        if(self::$db1 == null){
            self::$db1 = new DbUtil(Constants::HOST, Constants::USERNAME, Constants::PASSWORD, Constants::DATABASE);
            return self::$db1;
        }
        return self::$db1;
    }


}
