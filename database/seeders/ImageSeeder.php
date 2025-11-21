<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $image1 = new Image();
        $image1->url = "https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.qiscus.com%2Fid%2Fblog%2Fperbedaan-customer-care-dan-customer-service%2F&psig=AOvVaw1BTahbTr9YKHzmYf0xViOy&ust=1763362551107000&source=images&cd=vfe&opi=89978449&ved=0CBUQjRxqFwoTCLDcyMWL9pADFQAAAAAdAAAAABAE";
        $image1->imageable_id = "SYIFA";
        // $image1->imageable_type = Customer::class;
        $image1->imageable_type = 'customer';
        $image1->save();

        $image2 = new Image();
        $image2->url = "https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.smartsurvey.co.uk%2Fblog%2Fproduct-concept-what-is-it-how-to-use-it&psig=AOvVaw3eHRWLzmJy2R2hJ79HoaT6&ust=1763362692286000&source=images&cd=vfe&opi=89978449&ved=0CBcQjRxqFwoTCIDA3oiM9pADFQAAAAAdAAAAABAE";
        $image2->imageable_id = "1";
        // $image2->imageable_type = Product::class;
        $image2->imageable_type = 'product';
        $image2->save();
    }
}
