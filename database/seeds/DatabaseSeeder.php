<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Unit;
use App\Supplier;
use App\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        User::create([
            'name'           => 'Administrator',
            'email'       => 'admin@aporio.com',
            'password'       => bcrypt('123456'),
            'remember_token' => str_random(10),
        ]);

        Category::create([
            'name' => 'INJEKSI'
        ]);
        Category::create([
            'name' => 'KULIT'
        ]);
        Category::create([
            'name' => 'KUMUR'
        ]);
        Category::create([
            'name' => 'LUAR'
        ]);
        Category::create([
            'name' => 'MATA'
        ]);

        Unit::create([
            'name' => 'BOX'
        ]);
        Unit::create([
            'name' => 'BOTOL'
        ]);
        Unit::create([
            'name' => 'CAPSUL'
        ]);
        Unit::create([
            'name' => 'KG'
        ]);
        Unit::create([
            'name' => 'MG'
        ]);

        Supplier::create([
            'code' => '00000001',
            'name' => 'Lukman Abubakar',
            'address' => 'JL.Veteran Utara Lr.124 No.1',
            'mobile' => '081243431015',
            'cp' => 'Lukman Abubakar',
            'rekening' => '1090014091987',
            'npwp' => '111111111111111',
        ]);

        Product::create([
            'name' => 'AMARYL -M 2 TAB',
            'user_id' => '1',
            'category_id' => '2',
            'unit_id' => '1',
            'harga_pokok' => '170000',
            'harga_beli' => '170000',
            'harga_jual' => '171000',
            'supplier_id' => '1',
            'perInPrice' => 0,
            'diskonPer' => 0,
            'diskonNom' => 0,
            'diskonUnit' => 0,
            'minStok' => 10,
            'stok' => 0,
            'deskripsi' => 'Antidiabetik Oral',
            'komposisi' => 'Glimepride 2 mg/Metformin 500 mg',
            'indikasi' => 'Dm tipe 2 yang tidak dapat dikendalikan secara adekuat melalui diet, olahraga dan penurunan BB saja. Dapat digunakan dalam kombinasi dengan metformin atau insulin',
            'dosis' => 'Dosis bersifat individual. Berikan 1 atau 2 x/hr',
            'penyajian' => 'Segera sebelum makan',
            'perhatian' => 'Hopertensi terhadap sulfonilurea, sulfonamid atau biguanid. IDDM (DM tipe 1), ketonemia diabetik dan koma/prekoma diabetes, asidosis metabolik. Hamil, laktasi. Gangguan fungsi paru berat, hipoksemia, alkoholisme, gangguan gagal jantung. Hemodialisis.',
            'efeksamping' => 'Hipoglikemia, gangguan penglihatan sementara, gangguan GI, gangguan fungsi hati. Rasa logam pada pengecapan, ruam kulit',
            'kemasan' => '1 Dos isi 3 Blister x 10 Tablet',
            'produsen' => 'Sanofi aventis',
            'resepdokter' => true,
            'narkotika' => true,
            'expireDate' => '18-09-2018'
        ]);
    }
}
