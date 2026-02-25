<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contacts')->insert([
            [
                'id_contact' => 'office',
                'detail' => json_encode([
                    'alamat' => 'Jl. Dago, Bandung Barat',
                    'telpon' => '0123',
                    'email' => 'test@email.com',
                    'jam_pelayanan' => '<p>Senin - Jumat</p><p>09:00AM - 05:00PM</p>'
                ]),
                'location' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126757.2319022395!2d107.55669202021456!3d-6.8710040725830694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e0151b39c079%3A0x9f5ab4972d82e5b2!2sRumah%20Sakit%20Hewan%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1757980581739!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'created_at' => now(),
                'updated_at' => now()
        
            ],
            [
                'id_contact' => 'lab_cikole',
                'detail' => json_encode([
                    'alamat' => 'Jl. Tangkuban Parahu Cikole, Bandung Barat',
                    'telpon' => '0123',
                    'email' => 'test@email.com',
                    'jam_pelayanan' => '<p>Senin - Jumat</p><p>09:00AM - 05:00PM</p>'
                ]),
                'location' => '-',
                'created_at' => now(),
                'updated_at' => now()
        
            ],
            [
                'id_contact' => 'lab_losari',
                'detail' => json_encode([
                    'alamat' => 'Jl. Losari, Bandung Barat',
                    'telpon' => '0123',
                    'email' => 'test@email.com',
                    'jam_pelayanan' => '<p>Senin - Jumat</p><p>09:00AM - 05:00PM</p>'
                ]),
                'location' => '-',
                'created_at' => now(),
                'updated_at' => now()
        
            ],
            [
                'id_contact' => 'satpel_losari',
                'detail' => json_encode([
                    'alamat' => 'Jl. Lab Losari, Bandung Barat',
                    'telpon' => '0123',
                    'email' => 'test@email.com',
                    'jam_pelayanan' => '<p>Senin - Jumat</p><p>09:00AM - 05:00PM</p>'
                ]),
                'location' => '-',
                'created_at' => now(),
                'updated_at' => now()
        
            ],
            [
                'id_contact' => 'satpel_banjar',
                'detail' => json_encode([
                    'alamat' => 'Jl. Banjar, Bandung Barat',
                    'telpon' => '0123',
                    'email' => 'test@email.com',
                    'jam_pelayanan' => '<p>Senin - Jumat</p><p>09:00AM - 05:00PM</p>'
                ]),
                'location' => '-',
                'created_at' => now(),
                'updated_at' => now()
        
            ],
            [
                'id_contact' => 'satpel_gs',
                'detail' => json_encode([
                    'alamat' => 'Jl. Gunung Sindur, Bandung Barat',
                    'telpon' => '0123',
                    'email' => 'test@email.com',
                    'jam_pelayanan' => '<p>Senin - Jumat</p><p>09:00AM - 05:00PM</p>'
                ]),
                'location' => '-',
                'created_at' => now(),
                'updated_at' => now()
        
            ]
            ]
        );
    }
}
