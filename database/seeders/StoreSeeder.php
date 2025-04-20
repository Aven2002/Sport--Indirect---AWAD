<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = [
            [
                'storeName' => 'Sport Indirect - IOI CITY MALL',
                'imgPath' => 'Store/Sport_Indirect_-_IOI_CITY_MALL.png',
                'address' => 'LG-27A, LG Flr, IOI City Mall, Lbh IRC, Ioi Resort, 62502 Sepang, Selangor',
                'operation' => 'Monday - Sunday , 10:00am - 10:00pm',
                'contactNum' => '03-5614 9757'
            ],
            [
                'storeName' => 'Sport Indirect - Pavilion Bukit Jalil',
                'imgPath' => 'Store/Sport_Indirect_-_Pavilion_Bukit_Jalil.png',
                'address' => '8, 4.88&4.93 Lvl 4 Pavilion Bkt Jalil, Jalan Bukit Jalil, Bandar Bkt Jalil, 57000 Kuala Lumpur, Federal Territory of Kuala Lumpur',
                'operation' => 'Monday - Sunday , 10:00am - 10:00pm',
                'contactNum' => '03-5614 9757'
            ],
            [
                'storeName' => 'Sport Indirect - Sunway Velocity',
                'imgPath' => 'Store/Sport_Indirect_-_Sunway_Velocity.png',
                'address' => '4-15, 4ft Flr, SUNWAY VELOCITY, Jln Cheras, Maluri, 55100 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur',
                'operation' => 'Monday - Sunday , 10:00am - 10:00pm',
                'contactNum' => '03-5614 9749'
            ],
            [
                'storeName' => 'Sport Indirect - Mid Valley Megamall',
                'imgPath' => 'Store/Sport_Indirect_-_Mid_Valley_Megamall.png',
                'address' => 'Lot S-063 2nd Floor, Mid Valley Megamall, Lingkaran Syed Putra, Mid Valley City, 59200 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur',
                'operation' => 'Monday - Sunday , 10:00am - 10:00pm',
                'contactNum' => '03-5614 9765'
            ],
            [
                'storeName' => 'Sport Indirect - Petaling Jaya',
                'imgPath' => 'Store/Sport_Indirect_-_Petaling_Jaya.png',
                'address' => '11, Jalan 219, Section 51A, Petaling Jaya, 46100 Selangor',
                'operation' => 'Monday - Sunday , 10:00am - 7:00pm',
                'contactNum' => '03-5614 9778'
            ],
        ];

        foreach ($stores as $data) {
            Store::updateOrCreate([
                'storeName' => $data['storeName'],
                'imgPath' => $data['imgPath'],
                'address' => $data['address'],
                'operation' => $data['operation'],
                'contactNum' => $data['contactNum']
            ]);
        }
    }
}
