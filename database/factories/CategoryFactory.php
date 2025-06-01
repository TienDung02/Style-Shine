<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'parent_id' => null,
        ];
    }

    /**
     * Trạng thái cho danh mục cha (parent_id = 0)
     */
    public function root(): static // (B) Đổi tên hàm thành "root"
    {
        return $this->state(fn () => ['parent_id' => null]); // (C) Đặt parent_id thành NULL
    }

    /**
     * Trạng thái cho danh mục con (parent_id ngẫu nhiên từ danh mục cha)
     */
    public function child(): static
    {
        return $this->state(function () {
            // (D) Tùy chọn: Thêm điều kiện để chỉ chọn danh mục gốc có parent_id là NULL làm cha
            $parent = Category::whereNull('parent_id')->inRandomOrder()->first();
            return [
                'parent_id' => $parent ? $parent->id : null,
            ];
        });
    }
}
