<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Brand;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private static $products = [
        ['name' => 'Áo thun trắng cơ bản', 'description' => 'Áo thun trắng làm từ cotton, đơn giản và dễ phối đồ hằng ngày.'],
        ['name' => 'Quần jeans dáng ôm', 'description' => 'Quần jeans co giãn nhẹ, ôm dáng, thích hợp cho mọi hoạt động.'],
        ['name' => 'Áo hoodie đen cổ điển', 'description' => 'Áo hoodie đen chất nỉ, ấm áp và thời trang.'],
        ['name' => 'Áo sơ mi xanh lịch sự', 'description' => 'Áo sơ mi xanh navy cổ điển, thích hợp cho công sở và sự kiện.'],
        ['name' => 'Quần jogger thể thao', 'description' => 'Quần jogger nhẹ, thoáng khí, phù hợp luyện tập và mặc thường ngày.'],
        ['name' => 'Áo nỉ form rộng', 'description' => 'Áo nỉ oversize, trẻ trung và thoải mái.'],
        ['name' => 'Áo khoác jeans', 'description' => 'Áo khoác denim phong cách vintage, cá tính.'],
        ['name' => 'Áo polo kẻ sọc', 'description' => 'Áo polo cotton, thiết kế sọc ngang cổ điển.'],
        ['name' => 'Quần short vải lanh', 'description' => 'Quần short nhẹ, làm từ vải lanh, mát mẻ cho mùa hè.'],
        ['name' => 'Áo thun in hình', 'description' => 'Áo thun có in họa tiết độc đáo, cá tính.'],
        ['name' => 'Áo sơ mi flannel caro', 'description' => 'Áo flannel họa tiết caro đỏ đen, phù hợp mùa lạnh.'],
        ['name' => 'Quần cargo đa túi', 'description' => 'Quần cargo kaki nhiều túi, phong cách và tiện lợi.'],
        ['name' => 'Áo cardigan len', 'description' => 'Áo cardigan dệt kim mềm mại, ấm áp.'],
        ['name' => 'Bộ đồ thể thao', 'description' => 'Bộ tracksuit 2 mảnh thoáng mát, phù hợp tập luyện.'],
        ['name' => 'Áo tank top cotton', 'description' => 'Áo ba lỗ cotton cơ bản, thoải mái cho mùa hè.'],
        ['name' => 'Áo khoác da giả', 'description' => 'Áo khoác biker làm từ da PU, thời thượng.'],
        ['name' => 'Áo gile phao', 'description' => 'Áo gile giữ nhiệt, tiện lợi khi di chuyển.'],
        ['name' => 'Áo thun Henley dài tay', 'description' => 'Áo Henley cổ tròn có nút, mềm mại và đơn giản.'],
        ['name' => 'Quần legging tập gym', 'description' => 'Legging co giãn cao, ôm sát cơ thể, thích hợp tập luyện.'],
        ['name' => 'Quần skinny rách', 'description' => 'Quần jeans skinny có chi tiết rách nhẹ, trẻ trung.'],
        ['name' => 'Áo thun loang màu', 'description' => 'Áo thun nhuộm loang, năng động và cá tính.'],
        ['name' => 'Áo khoác gió mỏng', 'description' => 'Áo khoác gió nhẹ, có mũ trùm và chống nước nhẹ.'],
        ['name' => 'Áo dạ dài', 'description' => 'Áo khoác dạ dài thanh lịch, giữ ấm tốt.'],
        ['name' => 'Áo croptop nữ tính', 'description' => 'Áo croptop form ngắn, tôn dáng, phù hợp mùa hè.'],
        ['name' => 'Quần short thể thao', 'description' => 'Quần short thể thao vải lưới, thấm hút mồ hôi tốt.'],
        ['name' => 'Áo thun cổ tim', 'description' => 'Áo thun cổ chữ V, dễ phối đồ.'],
        ['name' => 'Áo hoodie không tay', 'description' => 'Hoodie không tay, thích hợp mặc khi thời tiết mát.'],
        ['name' => 'Áo blazer hai hàng nút', 'description' => 'Blazer dáng dài, lịch sự và sang trọng.'],
        ['name' => 'Áo len cổ lọ', 'description' => 'Áo cổ lọ giữ ấm tốt, phù hợp thời tiết lạnh.'],
        ['name' => 'Quần ống loe', 'description' => 'Quần dài ống loe, phong cách retro.'],
    ]
    ;

    public function definition(): array
    {
        $product = fake()->unique()->randomElement(self::$products);

        return [
            'name' => $product['name'],
            'price' => fake()->randomFloat(2, 10, 100),
            'quantity' => fake()->numberBetween(1, 100),
            'description' => $product['description'],
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'brand_id' => Brand::inRandomOrder()->first()?->id ?? Brand::factory(),
        ];
    }
}
