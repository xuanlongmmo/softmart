<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(category_news::class);
        $this->call(category_product::class);
        $this->call(discount::class);
        $this->call(permission::class);
        $this->call(group_user::class);
        $this->call(role_pẻmission::class);
        $this->call(users::class);
        $this->call(product::class);
        $this->call(news::class);
        $this->call(review_product::class);
        $this->call(status_order::class);
        $this->call(order::class);
        $this->call(order_detail::class);
    }
}
