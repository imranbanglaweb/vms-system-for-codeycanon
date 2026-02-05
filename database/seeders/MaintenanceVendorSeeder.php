<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceVendor;

class MaintenanceVendorSeeder extends Seeder
{
    public function run()
    {
        $vendors = [
            [
                'name' => 'AutoCare Service Center',
                'contact_person' => 'Rahul Sharma',
                'email' => 'rahul@autocare.com',
                'phone' => '+91-9876543210',
                'address' => '123, Service Road, Industrial Area, Dhaka-1208',
                'created_by' => 1,
            ],
            [
                'name' => 'Prime Motors Workshop',
                'contact_person' => 'Arif Khan',
                'email' => 'arif@primemotors.com',
                'phone' => '+91-9876543211',
                'address' => '456, Garage Galli, Motijheel, Dhaka-1000',
                'created_by' => 1,
            ],
            [
                'name' => 'Swift Auto Solutions',
                'contact_person' => 'Sanjay Patel',
                'email' => 'sanjay@swiftauto.com',
                'phone' => '+91-9876543212',
                'address' => '789, Workshop Lane, Gulshan, Dhaka-1212',
                'created_by' => 1,
            ],
            [
                'name' => 'Dhaka Car Care',
                'contact_person' => 'Mostafa Ali',
                'email' => 'mostafa@dhakacar.com',
                'phone' => '+91-9876543213',
                'address' => '321, Mechanic Bazar, Banani, Dhaka-1213',
                'created_by' => 1,
            ],
            [
                'name' => 'Elite Auto Services',
                'contact_person' => 'Imran Hossain',
                'email' => 'imran@eliteauto.com',
                'phone' => '+91-9876543214',
                'address' => '654, Service Point, Dhanmondi, Dhaka-1205',
                'created_by' => 1,
            ],
            [
                'name' => 'Professional Auto Works',
                'contact_person' => 'Kamal Uddin',
                'email' => 'kamal@professionalauto.com',
                'phone' => '+91-9876543215',
                'address' => '987, Garage Street, Mirpur, Dhaka-1216',
                'created_by' => 1,
            ],
            [
                'name' => 'Quality Auto Repair',
                'contact_person' => 'Rashid Ahmed',
                'email' => 'rashid@qualityauto.com',
                'phone' => '+91-9876543216',
                'address' => '147, Repair Road, Uttara, Dhaka-1230',
                'created_by' => 1,
            ],
            [
                'name' => 'Speedy Motors',
                'contact_person' => 'Anwar Hossain',
                'email' => 'anwar@speedymotors.com',
                'phone' => '+91-9876543217',
                'address' => '258, Fast Lane, Mohammadpur, Dhaka-1207',
                'created_by' => 1,
            ],
            [
                'name' => 'Budget Auto Garage',
                'contact_person' => 'Shahidul Islam',
                'email' => 'shahidul@budgetauto.com',
                'phone' => '+91-9876543218',
                'address' => '369, Economy Road, Badda, Dhaka-1212',
                'created_by' => 1,
            ],
            [
                'name' => 'Premium Auto Spa',
                'contact_person' => 'Mahbubur Rahman',
                'email' => 'mahbub@premiumautospa.com',
                'phone' => '+91-9876543219',
                'address' => '741, Luxury Lane, Baridhara, Dhaka-1212',
                'created_by' => 1,
            ],
            [
                'name' => 'Tire World Bangladesh',
                'contact_person' => 'Delwar Hossain',
                'email' => 'delwar@tireworld.com',
                'phone' => '+91-9876543220',
                'address' => '852, Wheel Street, Tejgaon, Dhaka-1215',
                'created_by' => 1,
            ],
            [
                'name' => 'Battery & Electrical Hub',
                'contact_person' => 'Abu Bakar',
                'email' => 'abubakar@batteryhub.com',
                'phone' => '+91-9876543221',
                'address' => '963, Power Zone, Shyamoli, Dhaka-1207',
                'created_by' => 1,
            ],
            [
                'name' => 'Body Works Studio',
                'contact_person' => 'Shafiqur Rahman',
                'email' => 'shafiq@bodyworks.com',
                'phone' => '+91-9876543222',
                'address' => '159, Paint Avenue, Cantonment, Dhaka-1206',
                'created_by' => 1,
            ],
            [
                'name' => 'AC & Heating Specialists',
                'contact_person' => 'Nazmul Haque',
                'email' => 'nazmul@acspecialists.com',
                'phone' => '+91-9876543223',
                'address' => '357, Cool Corner, Rampura, Dhaka-1219',
                'created_by' => 1,
            ],
            [
                'name' => 'Brake & Suspension Center',
                'contact_person' => 'Rayhan Uddin',
                'email' => 'rayhan@brakecenter.com',
                'phone' => '+91-9876543224',
                'address' => '753, Safety Street, Malibagh, Dhaka-1217',
                'created_by' => 1,
            ],
        ];

        foreach ($vendors as $vendor) {
            MaintenanceVendor::create($vendor);
        }

        $this->command->info('Maintenance vendors seeded successfully!');
    }
}
