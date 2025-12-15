<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = $this->getProducts();

        foreach ($products as $product) {
            Product::create($product);
        }
    }

    private function getProducts(): array
    {
        return [
            [
                'name' => 'Premium Dried Mangoes',
                'price' => 499,
                'image' => '/dried-mangoes.jpg',
                'rating' => 4.8,
                'reviews' => 124,
                'category' => 'Dried Fruits',
                'description' => 'Delicious, naturally sweet dried mangoes sourced from the finest orchards. No added sugar or preservatives.',
                'nutritional_info' => ['calories' => 320, 'protein' => '2g', 'fiber' => '3g', 'vitaminC' => '67%', 'servingSize' => '100g'],
                'stock' => 100
            ],
            [
                'name' => 'Organic Dried Cranberries',
                'price' => 599,
                'image' => '/dried-cranberries.png',
                'rating' => 4.9,
                'reviews' => 89,
                'category' => 'Dried Fruits',
                'description' => 'Tart, antioxidant-rich cranberries perfect for snacking or adding to recipes.',
                'nutritional_info' => ['calories' => 308, 'protein' => '0.1g', 'fiber' => '5.3g', 'vitaminC' => '24%', 'servingSize' => '100g'],
                'stock' => 150
            ],
            [
                'name' => 'Dried Apricots',
                'price' => 449,
                'image' => '/dried-apricots.png',
                'rating' => 4.7,
                'reviews' => 156,
                'category' => 'Dried Fruits',
                'description' => 'Naturally sweet apricots rich in beta-carotene and fiber.',
                'nutritional_info' => ['calories' => 241, 'protein' => '3.4g', 'fiber' => '7g', 'vitaminA' => '64%', 'servingSize' => '100g'],
                'stock' => 120
            ],
            [
                'name' => 'Mixed Berries Blend',
                'price' => 699,
                'image' => '/mixed-dried-berries.jpg',
                'rating' => 4.9,
                'reviews' => 203,
                'category' => 'Dried Fruits',
                'description' => 'Antioxidant powerhouse blend of blueberries, strawberries, and more.',
                'nutritional_info' => ['calories' => 325, 'protein' => '1g', 'fiber' => '7g', 'vitaminC' => '15%', 'servingSize' => '100g'],
                'stock' => 90
            ],
            [
                'name' => 'Dried Figs',
                'price' => 549,
                'image' => '/dried-figs.png',
                'rating' => 4.6,
                'reviews' => 98,
                'category' => 'Dried Fruits',
                'description' => 'Sweet, chewy figs packed with calcium and fiber.',
                'nutritional_info' => ['calories' => 249, 'protein' => '3.3g', 'fiber' => '9.8g', 'calcium' => '16%', 'servingSize' => '100g'],
                'stock' => 110
            ],
            [
                'name' => 'Dried Dates',
                'price' => 399,
                'image' => '/dried-dates.jpg',
                'rating' => 4.8,
                'reviews' => 187,
                'category' => 'Dried Fruits',
                'description' => 'Natural energy boosters with a caramel-like sweetness.',
                'nutritional_info' => ['calories' => 282, 'protein' => '2.5g', 'fiber' => '8g', 'potassium' => '20%', 'servingSize' => '100g'],
                'stock' => 200
            ],
            [
                'name' => 'Raw Almonds',
                'price' => 799,
                'image' => '/raw-almonds-nuts.jpg',
                'rating' => 4.7,
                'reviews' => 156,
                'category' => 'Nuts',
                'description' => 'Premium raw almonds rich in healthy fats and protein.',
                'nutritional_info' => ['calories' => 579, 'protein' => '21g', 'fiber' => '12g', 'vitaminE' => '37%', 'servingSize' => '100g'],
                'stock' => 180
            ],
            [
                'name' => 'Cashew Nuts',
                'price' => 899,
                'image' => '/cashew-nuts.jpg',
                'rating' => 4.8,
                'reviews' => 145,
                'category' => 'Nuts',
                'description' => 'Creamy cashews packed with magnesium and zinc.',
                'nutritional_info' => ['calories' => 553, 'protein' => '18g', 'fiber' => '3.3g', 'magnesium' => '73%', 'servingSize' => '100g'],
                'stock' => 160
            ],
            [
                'name' => 'Walnuts',
                'price' => 849,
                'image' => '/walnuts-pile.png',
                'rating' => 4.9,
                'reviews' => 167,
                'category' => 'Nuts',
                'description' => 'Brain-boosting walnuts rich in omega-3 fatty acids.',
                'nutritional_info' => ['calories' => 654, 'protein' => '15g', 'fiber' => '7g', 'omega3' => '2.5g', 'servingSize' => '100g'],
                'stock' => 140
            ],
            [
                'name' => 'Pistachios',
                'price' => 999,
                'image' => '/pistachios.png',
                'rating' => 4.7,
                'reviews' => 134,
                'category' => 'Nuts',
                'description' => 'Delicious pistachios with a satisfying crunch.',
                'nutritional_info' => ['calories' => 560, 'protein' => '20g', 'fiber' => '10g', 'vitaminB6' => '85%', 'servingSize' => '100g'],
                'stock' => 130
            ],
            [
                'name' => 'Brazil Nuts',
                'price' => 949,
                'image' => '/brazil-nuts.jpg',
                'rating' => 4.6,
                'reviews' => 89,
                'category' => 'Nuts',
                'description' => 'Selenium-rich Brazil nuts for immune support.',
                'nutritional_info' => ['calories' => 656, 'protein' => '14g', 'fiber' => '7.5g', 'selenium' => '1917%', 'servingSize' => '100g'],
                'stock' => 80
            ],
            [
                'name' => 'Macadamia Nuts',
                'price' => 1199,
                'image' => '/macadamia-nuts.jpg',
                'rating' => 4.9,
                'reviews' => 112,
                'category' => 'Nuts',
                'description' => 'Buttery macadamia nuts with heart-healthy fats.',
                'nutritional_info' => ['calories' => 718, 'protein' => '8g', 'fiber' => '9g', 'monounsaturatedFat' => '59g', 'servingSize' => '100g'],
                'stock' => 70
            ],
            [
                'name' => 'Pumpkin Seeds',
                'price' => 349,
                'image' => '/roasted-pumpkin-seeds.png',
                'rating' => 4.8,
                'reviews' => 134,
                'category' => 'Seeds',
                'description' => 'Zinc-rich pumpkin seeds for immune support.',
                'nutritional_info' => ['calories' => 446, 'protein' => '19g', 'fiber' => '6g', 'zinc' => '45%', 'servingSize' => '100g'],
                'stock' => 150
            ],
            [
                'name' => 'Sunflower Seeds',
                'price' => 299,
                'image' => '/sunflower-seeds.jpg',
                'rating' => 4.7,
                'reviews' => 156,
                'category' => 'Seeds',
                'description' => 'Vitamin E-rich sunflower seeds for healthy skin.',
                'nutritional_info' => ['calories' => 584, 'protein' => '21g', 'fiber' => '9g', 'vitaminE' => '234%', 'servingSize' => '100g'],
                'stock' => 180
            ],
            [
                'name' => 'Chia Seeds',
                'price' => 449,
                'image' => '/chia-seeds.png',
                'rating' => 4.9,
                'reviews' => 201,
                'category' => 'Seeds',
                'description' => 'Superfood chia seeds with omega-3 and fiber.',
                'nutritional_info' => ['calories' => 486, 'protein' => '17g', 'fiber' => '34g', 'omega3' => '18g', 'servingSize' => '100g'],
                'stock' => 200
            ],
            [
                'name' => 'Flax Seeds',
                'price' => 349,
                'image' => '/flax-seeds.jpg',
                'rating' => 4.8,
                'reviews' => 178,
                'category' => 'Seeds',
                'description' => 'Omega-3 rich flax seeds for heart health.',
                'nutritional_info' => ['calories' => 534, 'protein' => '18g', 'fiber' => '27g', 'omega3' => '23g', 'servingSize' => '100g'],
                'stock' => 170
            ],
            [
                'name' => 'Hemp Seeds',
                'price' => 549,
                'image' => '/hemp-seeds.jpg',
                'rating' => 4.7,
                'reviews' => 145,
                'category' => 'Seeds',
                'description' => 'Complete protein hemp seeds with all essential amino acids.',
                'nutritional_info' => ['calories' => 553, 'protein' => '32g', 'fiber' => '4g', 'omega3' => '9g', 'servingSize' => '100g'],
                'stock' => 120
            ],
            [
                'name' => 'Sesame Seeds',
                'price' => 299,
                'image' => '/sesame-seeds.jpg',
                'rating' => 4.6,
                'reviews' => 123,
                'category' => 'Seeds',
                'description' => 'Calcium-rich sesame seeds for bone health.',
                'nutritional_info' => ['calories' => 573, 'protein' => '18g', 'fiber' => '12g', 'calcium' => '97%', 'servingSize' => '100g'],
                'stock' => 160
            ],
            [
                'name' => 'Goji Berries',
                'price' => 799,
                'image' => '/goji-berries.jpg',
                'rating' => 4.9,
                'reviews' => 189,
                'category' => 'Superfoods',
                'description' => 'Antioxidant-rich goji berries for immune support.',
                'nutritional_info' => ['calories' => 349, 'protein' => '14g', 'fiber' => '13g', 'vitaminA' => '501%', 'servingSize' => '100g'],
                'stock' => 100
            ],
            [
                'name' => 'Acai Berries',
                'price' => 899,
                'image' => '/acai-berries.jpg',
                'rating' => 4.8,
                'reviews' => 167,
                'category' => 'Superfoods',
                'description' => 'Superfood acai berries packed with antioxidants.',
                'nutritional_info' => ['calories' => 70, 'protein' => '2g', 'fiber' => '2g', 'antioxidants' => 'High', 'servingSize' => '100g'],
                'stock' => 90
            ],
            [
                'name' => 'Mulberries',
                'price' => 649,
                'image' => '/mulberries.jpg',
                'rating' => 4.7,
                'reviews' => 134,
                'category' => 'Superfoods',
                'description' => 'Sweet mulberries rich in vitamin C and iron.',
                'nutritional_info' => ['calories' => 43, 'protein' => '1.4g', 'fiber' => '1.7g', 'vitaminC' => '61%', 'servingSize' => '100g'],
                'stock' => 110
            ],
            [
                'name' => 'Cacao Nibs',
                'price' => 749,
                'image' => '/cacao-nibs.jpg',
                'rating' => 4.9,
                'reviews' => 198,
                'category' => 'Superfoods',
                'description' => 'Raw cacao nibs for a healthy chocolate fix.',
                'nutritional_info' => ['calories' => 600, 'protein' => '14g', 'fiber' => '9g', 'magnesium' => '64%', 'servingSize' => '100g'],
                'stock' => 130
            ],
            [
                'name' => 'Dried Pineapple',
                'price' => 529,
                'image' => 'https://images.unsplash.com/photo-1550828520-4cb496926fc9?w=400',
                'rating' => 4.8,
                'reviews' => 142,
                'category' => 'Dried Fruits',
                'description' => 'Tropical dried pineapple rings with natural sweetness.',
                'nutritional_info' => ['calories' => 357, 'protein' => '2.4g', 'fiber' => '9g', 'vitaminC' => '131%', 'servingSize' => '100g'],
                'stock' => 100
            ],
            [
                'name' => 'Dried Papaya',
                'price' => 479,
                'image' => 'https://images.unsplash.com/photo-1617112848923-cc2234396a8d?w=400',
                'rating' => 4.7,
                'reviews' => 118,
                'category' => 'Dried Fruits',
                'description' => 'Sweet papaya chunks rich in digestive enzymes.',
                'nutritional_info' => ['calories' => 339, 'protein' => '5.3g', 'fiber' => '13g', 'vitaminA' => '47%', 'servingSize' => '100g'],
                'stock' => 95
            ],
            [
                'name' => 'Dried Banana Chips',
                'price' => 349,
                'image' => 'https://images.unsplash.com/photo-1603833665858-e61d17a86224?w=400',
                'rating' => 4.6,
                'reviews' => 167,
                'category' => 'Dried Fruits',
                'description' => 'Crispy banana chips perfect for snacking.',
                'nutritional_info' => ['calories' => 519, 'protein' => '2.3g', 'fiber' => '7.7g', 'potassium' => '15%', 'servingSize' => '100g'],
                'stock' => 150
            ],
            [
                'name' => 'Dried Coconut Flakes',
                'price' => 399,
                'image' => 'https://images.unsplash.com/photo-1471943311424-646960669fbc?w=400',
                'rating' => 4.9,
                'reviews' => 203,
                'category' => 'Dried Fruits',
                'description' => 'Unsweetened coconut flakes for baking and snacking.',
                'nutritional_info' => ['calories' => 660, 'protein' => '6.9g', 'fiber' => '16g', 'iron' => '18%', 'servingSize' => '100g'],
                'stock' => 140
            ],
            [
                'name' => 'Dried Prunes',
                'price' => 429,
                'image' => 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=400',
                'rating' => 4.7,
                'reviews' => 156,
                'category' => 'Dried Fruits',
                'description' => 'Fiber-rich prunes for digestive health.',
                'nutritional_info' => ['calories' => 240, 'protein' => '2.2g', 'fiber' => '7.1g', 'vitaminK' => '57%', 'servingSize' => '100g'],
                'stock' => 130
            ],
            [
                'name' => 'Dried Raisins',
                'price' => 299,
                'image' => 'https://images.unsplash.com/photo-1572383672419-ab35444a6934?w=400',
                'rating' => 4.8,
                'reviews' => 234,
                'category' => 'Dried Fruits',
                'description' => 'Classic raisins packed with natural energy.',
                'nutritional_info' => ['calories' => 299, 'protein' => '3.1g', 'fiber' => '3.7g', 'iron' => '10%', 'servingSize' => '100g'],
                'stock' => 200
            ],
            [
                'name' => 'Pecans',
                'price' => 1049,
                'image' => 'https://images.unsplash.com/photo-1448043552756-e747b7a2b2b8?w=400',
                'rating' => 4.8,
                'reviews' => 145,
                'category' => 'Nuts',
                'description' => 'Buttery pecans rich in antioxidants.',
                'nutritional_info' => ['calories' => 691, 'protein' => '9g', 'fiber' => '10g', 'manganese' => '214%', 'servingSize' => '100g'],
                'stock' => 85
            ],
            [
                'name' => 'Hazelnuts',
                'price' => 949,
                'image' => 'https://images.unsplash.com/photo-1618897996318-5a901fa6ca71?w=400',
                'rating' => 4.7,
                'reviews' => 128,
                'category' => 'Nuts',
                'description' => 'Crunchy hazelnuts with a sweet, nutty flavor.',
                'nutritional_info' => ['calories' => 628, 'protein' => '15g', 'fiber' => '10g', 'vitaminE' => '96%', 'servingSize' => '100g'],
                'stock' => 95
            ],
            [
                'name' => 'Pine Nuts',
                'price' => 1299,
                'image' => 'https://images.unsplash.com/photo-1608797178974-15b35a64ede9?w=400',
                'rating' => 4.9,
                'reviews' => 98,
                'category' => 'Nuts',
                'description' => 'Premium pine nuts for gourmet cooking.',
                'nutritional_info' => ['calories' => 673, 'protein' => '14g', 'fiber' => '3.7g', 'magnesium' => '63%', 'servingSize' => '100g'],
                'stock' => 60
            ],
            [
                'name' => 'Mixed Nuts Deluxe',
                'price' => 899,
                'image' => 'https://images.unsplash.com/photo-1595475207225-428b62bda831?w=400',
                'rating' => 4.9,
                'reviews' => 267,
                'category' => 'Nuts',
                'description' => 'Premium blend of almonds, cashews, walnuts, and more.',
                'nutritional_info' => ['calories' => 607, 'protein' => '20g', 'fiber' => '7g', 'vitaminE' => '45%', 'servingSize' => '100g'],
                'stock' => 150
            ],
            [
                'name' => 'Quinoa Seeds',
                'price' => 449,
                'image' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=400',
                'rating' => 4.8,
                'reviews' => 189,
                'category' => 'Seeds',
                'description' => 'Complete protein quinoa seeds for healthy meals.',
                'nutritional_info' => ['calories' => 368, 'protein' => '14g', 'fiber' => '7g', 'iron' => '25%', 'servingSize' => '100g'],
                'stock' => 140
            ],
            [
                'name' => 'Poppy Seeds',
                'price' => 329,
                'image' => 'https://images.unsplash.com/photo-1609501676725-7186f017a4b7?w=400',
                'rating' => 4.6,
                'reviews' => 112,
                'category' => 'Seeds',
                'description' => 'Tiny poppy seeds with a nutty flavor.',
                'nutritional_info' => ['calories' => 525, 'protein' => '18g', 'fiber' => '20g', 'calcium' => '143%', 'servingSize' => '100g'],
                'stock' => 100
            ],
            [
                'name' => 'Spirulina Powder',
                'price' => 899,
                'image' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=400',
                'rating' => 4.9,
                'reviews' => 234,
                'category' => 'Superfoods',
                'description' => 'Nutrient-dense spirulina powder for smoothies.',
                'nutritional_info' => ['calories' => 290, 'protein' => '57g', 'fiber' => '4g', 'iron' => '158%', 'servingSize' => '100g'],
                'stock' => 110
            ],
            [
                'name' => 'Maca Powder',
                'price' => 749,
                'image' => 'https://images.unsplash.com/photo-1505576399279-565b52d4ac71?w=400',
                'rating' => 4.8,
                'reviews' => 178,
                'category' => 'Superfoods',
                'description' => 'Energy-boosting maca root powder.',
                'nutritional_info' => ['calories' => 325, 'protein' => '14g', 'fiber' => '7g', 'iron' => '128%', 'servingSize' => '100g'],
                'stock' => 100
            ],
            [
                'name' => 'Matcha Green Tea Powder',
                'price' => 999,
                'image' => 'https://images.unsplash.com/photo-1515823064-d6e0c04616a7?w=400',
                'rating' => 4.9,
                'reviews' => 312,
                'category' => 'Superfoods',
                'description' => 'Premium ceremonial grade matcha powder.',
                'nutritional_info' => ['calories' => 324, 'protein' => '29g', 'fiber' => '39g', 'antioxidants' => 'Very High', 'servingSize' => '100g'],
                'stock' => 120
            ],
            [
                'name' => 'Turmeric Powder',
                'price' => 549,
                'image' => 'https://images.unsplash.com/photo-1615485500834-bc10199bc727?w=400',
                'rating' => 4.7,
                'reviews' => 198,
                'category' => 'Superfoods',
                'description' => 'Anti-inflammatory turmeric powder with curcumin.',
                'nutritional_info' => ['calories' => 312, 'protein' => '10g', 'fiber' => '22g', 'iron' => '232%', 'servingSize' => '100g'],
                'stock' => 150
            ],
            [
                'name' => 'Wheatgrass Powder',
                'price' => 649,
                'image' => 'https://images.unsplash.com/photo-1628771065518-0d82f1938462?w=400',
                'rating' => 4.6,
                'reviews' => 145,
                'category' => 'Superfoods',
                'description' => 'Detoxifying wheatgrass powder for wellness.',
                'nutritional_info' => ['calories' => 198, 'protein' => '8g', 'fiber' => '4g', 'vitaminA' => '120%', 'servingSize' => '100g'],
                'stock' => 90
            ],
            [
                'name' => 'Moringa Powder',
                'price' => 799,
                'image' => 'https://images.unsplash.com/photo-1609501676725-7186f017a4b7?w=400',
                'rating' => 4.8,
                'reviews' => 167,
                'category' => 'Superfoods',
                'description' => 'Nutrient-rich moringa leaf powder.',
                'nutritional_info' => ['calories' => 205, 'protein' => '27g', 'fiber' => '19g', 'vitaminA' => '378%', 'servingSize' => '100g'],
                'stock' => 100
            ],
            [
                'name' => 'Dried Blueberries',
                'price' => 649,
                'image' => 'https://images.unsplash.com/photo-1498557850523-fd3d118b962e?w=400',
                'rating' => 4.9,
                'reviews' => 223,
                'category' => 'Dried Fruits',
                'description' => 'Antioxidant-rich dried blueberries for brain health.',
                'nutritional_info' => ['calories' => 317, 'protein' => '2g', 'fiber' => '5g', 'vitaminK' => '18%', 'servingSize' => '100g'],
                'stock' => 120
            ],
            [
                'name' => 'Dried Strawberries',
                'price' => 599,
                'image' => 'https://images.unsplash.com/photo-1464965911861-746a04b4bca6?w=400',
                'rating' => 4.8,
                'reviews' => 198,
                'category' => 'Dried Fruits',
                'description' => 'Sweet dried strawberries packed with vitamin C.',
                'nutritional_info' => ['calories' => 286, 'protein' => '3.3g', 'fiber' => '12g', 'vitaminC' => '97%', 'servingSize' => '100g'],
                'stock' => 110
            ],
            [
                'name' => 'Dried Cherries',
                'price' => 729,
                'image' => 'https://images.unsplash.com/photo-1528821128474-27f963b062bf?w=400',
                'rating' => 4.7,
                'reviews' => 176,
                'category' => 'Dried Fruits',
                'description' => 'Tart dried cherries for recovery and sleep support.',
                'nutritional_info' => ['calories' => 333, 'protein' => '1.5g', 'fiber' => '2.1g', 'potassium' => '11%', 'servingSize' => '100g'],
                'stock' => 95
            ],
            [
                'name' => 'Dried Kiwi Slices',
                'price' => 679,
                'image' => 'https://images.unsplash.com/photo-1585059895524-72359e06133a?w=400',
                'rating' => 4.8,
                'reviews' => 145,
                'category' => 'Dried Fruits',
                'description' => 'Tangy dried kiwi slices rich in vitamin C.',
                'nutritional_info' => ['calories' => 341, 'protein' => '4g', 'fiber' => '11g', 'vitaminC' => '154%', 'servingSize' => '100g'],
                'stock' => 85
            ],
            [
                'name' => 'Dried Peaches',
                'price' => 529,
                'image' => 'https://images.unsplash.com/photo-1528821128474-27f963b062bf?w=400',
                'rating' => 4.7,
                'reviews' => 167,
                'category' => 'Dried Fruits',
                'description' => 'Sweet dried peaches with natural fiber.',
                'nutritional_info' => ['calories' => 239, 'protein' => '3.6g', 'fiber' => '8.2g', 'vitaminA' => '54%', 'servingSize' => '100g'],
                'stock' => 100
            ],
            [
                'name' => 'Dried Pears',
                'price' => 549,
                'image' => 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=400',
                'rating' => 4.6,
                'reviews' => 134,
                'category' => 'Dried Fruits',
                'description' => 'Naturally sweet dried pears with dietary fiber.',
                'nutritional_info' => ['calories' => 262, 'protein' => '2.6g', 'fiber' => '11g', 'copper' => '29%', 'servingSize' => '100g'],
                'stock' => 90
            ],
            [
                'name' => 'Dried Plums',
                'price' => 479,
                'image' => 'https://images.unsplash.com/photo-1600271886742-f049cd451bba?w=400',
                'rating' => 4.8,
                'reviews' => 189,
                'category' => 'Dried Fruits',
                'description' => 'Fiber-rich dried plums for digestive wellness.',
                'nutritional_info' => ['calories' => 240, 'protein' => '2.2g', 'fiber' => '7.1g', 'vitaminK' => '57%', 'servingSize' => '100g'],
                'stock' => 110
            ],
            [
                'name' => 'Tiger Nuts',
                'price' => 649,
                'image' => 'https://images.unsplash.com/photo-1608797178974-15b35a64ede9?w=400',
                'rating' => 4.7,
                'reviews' => 112,
                'category' => 'Nuts',
                'description' => 'Prebiotic-rich tiger nuts for gut health.',
                'nutritional_info' => ['calories' => 496, 'protein' => '7g', 'fiber' => '33g', 'iron' => '28%', 'servingSize' => '100g'],
                'stock' => 75
            ],
            [
                'name' => 'Roasted Almonds',
                'price' => 849,
                'image' => 'https://images.unsplash.com/photo-1508747703725-719777637510?w=400',
                'rating' => 4.8,
                'reviews' => 234,
                'category' => 'Nuts',
                'description' => 'Crunchy roasted almonds with sea salt.',
                'nutritional_info' => ['calories' => 607, 'protein' => '21g', 'fiber' => '12g', 'vitaminE' => '37%', 'servingSize' => '100g'],
                'stock' => 180
            ],
            [
                'name' => 'Honey Roasted Cashews',
                'price' => 949,
                'image' => 'https://images.unsplash.com/photo-1585704032915-c3400ca199e7?w=400',
                'rating' => 4.9,
                'reviews' => 267,
                'category' => 'Nuts',
                'description' => 'Sweet honey-glazed cashews for a delicious treat.',
                'nutritional_info' => ['calories' => 574, 'protein' => '17g', 'fiber' => '3g', 'magnesium' => '70%', 'servingSize' => '100g'],
                'stock' => 140
            ],
            [
                'name' => 'Spicy Mixed Nuts',
                'price' => 899,
                'image' => 'https://images.unsplash.com/photo-1520013817300-1f4c1cb245ef?w=400',
                'rating' => 4.7,
                'reviews' => 178,
                'category' => 'Nuts',
                'description' => 'Zesty spiced nut blend with a kick.',
                'nutritional_info' => ['calories' => 612, 'protein' => '19g', 'fiber' => '8g', 'vitaminE' => '42%', 'servingSize' => '100g'],
                'stock' => 120
            ],
            [
                'name' => 'Candied Walnuts',
                'price' => 949,
                'image' => 'https://images.unsplash.com/photo-1590779033100-9f60a05a013d?w=400',
                'rating' => 4.8,
                'reviews' => 156,
                'category' => 'Nuts',
                'description' => 'Sweet candied walnuts perfect for salads.',
                'nutritional_info' => ['calories' => 698, 'protein' => '14g', 'fiber' => '6g', 'omega3' => '2.2g', 'servingSize' => '100g'],
                'stock' => 100
            ],
            [
                'name' => 'Roasted Pistachios',
                'price' => 1099,
                'image' => 'https://images.unsplash.com/photo-1618897996318-5a901fa6ca71?w=400',
                'rating' => 4.9,
                'reviews' => 201,
                'category' => 'Nuts',
                'description' => 'Lightly salted roasted pistachios.',
                'nutritional_info' => ['calories' => 571, 'protein' => '21g', 'fiber' => '10g', 'vitaminB6' => '87%', 'servingSize' => '100g'],
                'stock' => 130
            ],
            [
                'name' => 'Trail Mix Supreme',
                'price' => 749,
                'image' => 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400',
                'rating' => 4.8,
                'reviews' => 289,
                'category' => 'Mixed',
                'description' => 'Energy-packed trail mix with nuts, seeds, and dried fruits.',
                'nutritional_info' => ['calories' => 462, 'protein' => '13g', 'fiber' => '7g', 'iron' => '18%', 'servingSize' => '100g'],
                'stock' => 160
            ],
            [
                'name' => 'Protein Power Mix',
                'price' => 849,
                'image' => 'https://images.unsplash.com/photo-1607623814075-e51df1bdc82f?w=400',
                'rating' => 4.9,
                'reviews' => 234,
                'category' => 'Mixed',
                'description' => 'High-protein blend of nuts and seeds.',
                'nutritional_info' => ['calories' => 589, 'protein' => '25g', 'fiber' => '9g', 'iron' => '32%', 'servingSize' => '100g'],
                'stock' => 140
            ],
            [
                'name' => 'Antioxidant Berry Mix',
                'price' => 799,
                'image' => 'https://images.unsplash.com/photo-1464965911861-746a04b4bca6?w=400',
                'rating' => 4.8,
                'reviews' => 198,
                'category' => 'Mixed',
                'description' => 'Superfood berry blend with goji, acai, and more.',
                'nutritional_info' => ['calories' => 345, 'protein' => '8g', 'fiber' => '12g', 'antioxidants' => 'Very High', 'servingSize' => '100g'],
                'stock' => 110
            ],
            [
                'name' => 'Omega-3 Seed Mix',
                'price' => 549,
                'image' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=400',
                'rating' => 4.9,
                'reviews' => 176,
                'category' => 'Seeds',
                'description' => 'Heart-healthy blend of chia, flax, and hemp seeds.',
                'nutritional_info' => ['calories' => 524, 'protein' => '22g', 'fiber' => '21g', 'omega3' => '15g', 'servingSize' => '100g'],
                'stock' => 130
            ],
            [
                'name' => 'Bee Pollen Granules',
                'price' => 899,
                'image' => 'https://images.unsplash.com/photo-1587735243615-c03f25aaff15?w=400',
                'rating' => 4.7,
                'reviews' => 145,
                'category' => 'Superfoods',
                'description' => 'Nutrient-dense bee pollen for energy and immunity.',
                'nutritional_info' => ['calories' => 240, 'protein' => '24g', 'fiber' => '2g', 'vitaminB' => 'High', 'servingSize' => '100g'],
                'stock' => 80
            ],
            [
                'name' => 'Chlorella Powder',
                'price' => 949,
                'image' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=400',
                'rating' => 4.8,
                'reviews' => 167,
                'category' => 'Superfoods',
                'description' => 'Detoxifying chlorella algae powder.',
                'nutritional_info' => ['calories' => 290, 'protein' => '58g', 'fiber' => '0g', 'iron' => '202%', 'servingSize' => '100g'],
                'stock' => 90
            ],
            [
                'name' => 'Ashwagandha Powder',
                'price' => 849,
                'image' => 'https://images.unsplash.com/photo-1505576399279-565b52d4ac71?w=400',
                'rating' => 4.9,
                'reviews' => 223,
                'category' => 'Superfoods',
                'description' => 'Adaptogenic ashwagandha for stress relief.',
                'nutritional_info' => ['calories' => 245, 'protein' => '3.7g', 'fiber' => '32g', 'iron' => '28%', 'servingSize' => '100g'],
                'stock' => 100
            ],
        ];
    }
}
