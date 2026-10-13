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
            $this->db->table('products')->insertBatch([
                [
                    'name'         => 'Cortes de Cerdo',
                    'description'  => 'Costeleta, bondiola, paleta, carré y más. Cortes frescos y a pedido para asados y cocina.',
                    'price'        => 8500.00,
                    'tag'          => 'Fresco',
                    'image'        => 'img 2.jpg',
                    'whatsapp_msg' => 'Hola! Quisiera hacer un pedido de cortes de cerdo (costeleta, bondiola, paleta, carré, etc).',
                    'active'       => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ],
                [
                    'name'         => 'Chorizos y Salchichas',
                    'description'  => 'Elaborados con recetas propias. Chorizos parrilleros y salchichas artesanales de máxima calidad.',
                    'price'        => 6900.00,
                    'tag'          => 'Artesanal',
                    'image'        => 'img 3.webp',
                    'whatsapp_msg' => 'Hola! Quisiera pedir chorizos y salchichas artesanales.',
                    'active'       => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ],
                [
                    'name'         => 'Fiambres y Embutidos',
                    'description'  => 'Salame de primera / de picado fino y chorizos curados. Ideales para picadas familiares y reuniones.',
                    'price'        => 9200.00,
                    'tag'          => 'Selección',
                    'image'        => 'salames.gif',
                    'whatsapp_msg' => 'Hola! Quisiera pedir fiambres y embutidos (salame, etc).',
                    'active'       => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ],
                [
                    'name'         => 'Elaborados Propios',
                    'description'  => 'Morcillas, queso de cerdo, chicharrones, brochettes y pecetos rellenos de producción propia.',
                    'price'        => 7800.00,
                    'tag'          => 'De la casa',
                    'image'        => 'morcilla.jpg',
                    'whatsapp_msg' => 'Hola! Quisiera pedir elaborados propios (morcillas, queso de cerdo, chicharrones, etc).',
                    'active'       => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ],
                [
                    'name'         => 'Para el Asado',
                    'description'  => 'Todo para tu parrillada: chorizos, morcillas, matambres tiernos, bondiola y muchos más cortes seleccionados.',
                    'price'        => 10500.00,
                    'tag'          => 'Parrilla',
                    'image'        => 'costillas.jpg',
                    'whatsapp_msg' => 'Hola! Quisiera hacer un pedido para el asado (chorizos, morcillas, matambre, bondiola, etc).',
                    'active'       => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ],
                [
                    'name'         => 'Pedidos Especiales',
                    'description'  => 'Chivo, cordero, lechón y porciones grandes para eventos, cumpleaños y fiestas. Consultanos.',
                    'price'        => 14000.00,
                    'tag'          => 'A pedido',
                    'image'        => 'mayot.jpg',
                    'whatsapp_msg' => 'Hola! Quisiera consultar por un pedido especial (chivo, cordero, lechón, etc) para un evento.',
                    'active'       => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ],
                [
                    'name'         => 'Picadas y Reuniones',
                    'description'  => 'Albóndigas, medallones caseros y milanesas preparadas, listos para cocinar en casa de forma práctica.',
                    'price'        => 6200.00,
                    'tag'          => 'Listo para cocinar',
                    'image'        => 'milanesas.jpg',
                    'whatsapp_msg' => 'Hola! Quisiera pedir albóndigas, hamburguesas y milanesas.',
                    'active'       => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ],
            ]);
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
