<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Users
        $userCount = $this->db->table('users')->countAllResults();
        if ($userCount === 0) {
            $this->db->table('users')->insertBatch([
                [
                    'name'       => 'Administrador',
                    'email'      => 'admin@boutique.com',
                    'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                    'role'       => 'admin',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name'       => 'Cliente Demo',
                    'email'      => 'cliente@boutique.com',
                    'password'   => password_hash('cliente123', PASSWORD_DEFAULT),
                    'role'       => 'client',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            ]);
        }

        // 2. Seed Products
        $productCount = $this->db->table('products')->countAllResults();
        if ($productCount === 0) {
            $listPath = __DIR__ . '/products_data.php';
            if (file_exists($listPath)) {
                $productsData = require $listPath;
                $batch = [];
                foreach ($productsData as $p) {
                    $batch[] = [
                        'code_int'     => $p['code_int'],
                        'name'         => $p['name'],
                        'description'  => $p['description'],
                        'price'        => $p['price'],
                        'tag'          => $p['tag'],
                        'category'     => $p['category'],
                        'image'        => $p['image'],
                        'whatsapp_msg' => $p['whatsapp_msg'],
                        'active'       => 1,
                        'created_at'   => date('Y-m-d H:i:s'),
                        'updated_at'   => date('Y-m-d H:i:s'),
                    ];
                }
                $this->db->table('products')->insertBatch($batch);
            }
        }

        // 3. Seed Comments
        $commentCount = $this->db->table('comments')->countAllResults();
        if ($commentCount === 0) {
            $this->db->table('comments')->insertBatch([
                [
                    'name'       => 'Marcelo',
                    'subtitle'   => 'Cliente frecuente',
                    'stars'      => 5,
                    'comment'    => 'Los chorizos son los mejores de Río Tercero, sin dudas. Siempre frescos y con muy buena atención.',
                    'status'     => 'approved',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                ],
                [
                    'name'       => 'Silvana',
                    'subtitle'   => 'Cliente',
                    'stars'      => 5,
                    'comment'    => 'Pedimos chorizos para el cumpleaños y quedamos encantados. Muy buen producto y excelente precio.',
                    'status'     => 'approved',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                ],
                [
                    'name'       => 'Lucas P.',
                    'subtitle'   => 'Cliente',
                    'stars'      => 5,
                    'comment'    => 'Los chorizos y el salame son una locura. No compro en otro lado.',
                    'status'     => 'approved',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                ],
            ]);
        }
    }
}
