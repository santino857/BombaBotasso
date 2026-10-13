<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CommentModel;
use App\Models\InquiryModel;
use App\Models\OrderModel;

class Home extends BaseController
{
    protected ProductModel $productModel;
    protected CommentModel $commentModel;
    protected InquiryModel $inquiryModel;
    protected OrderModel $orderModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->commentModel = new CommentModel();
        $this->inquiryModel = new InquiryModel();
        $this->orderModel   = new OrderModel();
    }

    public function index(): string
    {
        $products = $this->productModel->getActiveProducts();
        $comments = $this->commentModel->getApprovedComments(12);

        // Calculate average star rating
        $avgStars = 5;
        if (!empty($comments)) {
            $totalStars = array_sum(array_column($comments, 'stars'));
            $avgStars   = round($totalStars / count($comments), 1);
        }

        return view('home', [
            'products' => $products,
            'comments' => $comments,
            'avgStars' => $avgStars,
        ]);
    }

    public function saveComment()
    {
        $rules = [
            'name'    => 'required|min_length[2]|max_length[100]',
            'comment' => 'required|min_length[5]|max_length[1000]',
            'stars'   => 'permit_empty|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        ];

        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->validator->getErrors()
                ])->setStatusCode(400);
            }
            return redirect()->back()->withInput()->with('error', 'Por favor completá los campos correctamente.');
        }

        $stars = (int) ($this->request->getPost('stars') ?: 5);
        $name  = trim($this->request->getPost('name'));
        $text  = trim($this->request->getPost('comment'));

        $this->commentModel->insert([
            'name'       => $name,
            'subtitle'   => session()->get('isLoggedIn') ? 'Cliente Registrado' : 'Cliente',
            'stars'      => $stars,
            'comment'    => $text,
            'status'     => 'approved',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => '¡Muchas gracias! Tu comentario ha sido publicado con éxito.',
                'data'    => [
                    'name'       => esc($name),
                    'stars'      => $stars,
                    'comment'    => esc($text),
                    'subtitle'   => session()->get('isLoggedIn') ? 'Cliente Registrado' : 'Cliente',
                    'created_at' => 'Ahora mismo'
                ]
            ]);
        }

        return redirect()->to(base_url('#consultas'))->with('exito', '¡Comentario publicado exitosamente!');
    }

    public function saveInquiry()
    {
        $rules = [
            'nombre'  => 'required|min_length[2]|max_length[100]',
            'mensaje' => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->validator->getErrors()
                ])->setStatusCode(400);
            }
            return redirect()->back()->withInput()->with('error', 'Por favor completá tu nombre y consulta.');
        }

        $this->inquiryModel->insert([
            'name'       => trim($this->request->getPost('nombre')),
            'contact'    => trim($this->request->getPost('contacto') ?: ''),
            'message'    => trim($this->request->getPost('mensaje')),
            'status'     => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => '¡Consulta registrada con éxito!'
            ]);
        }

        return redirect()->to(base_url('#consultas'))->with('exito', '¡Tu consulta ha sido enviada!');
    }

    public function saveOrder()
    {
        $customerName    = trim($this->request->getPost('customer_name') ?? '');
        $customerPhone   = trim($this->request->getPost('customer_phone') ?? '');
        $customerAddress = trim($this->request->getPost('customer_address') ?? '');
        $itemsSummary    = trim($this->request->getPost('items_summary') ?? '');
        $total           = (float) ($this->request->getPost('total') ?? 0);
        $notes           = trim($this->request->getPost('notes') ?? '');

        if (empty($customerName) || empty($itemsSummary)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Completá tu nombre y agregá productos al pedido.'
            ])->setStatusCode(400);
        }

        $orderId = $this->orderModel->insert([
            'customer_name'    => $customerName,
            'customer_phone'   => $customerPhone,
            'customer_address' => $customerAddress,
            'total'            => $total,
            'status'           => 'pending',
            'notes'            => $notes,
            'items_summary'    => $itemsSummary,
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON([
            'status'   => 'success',
            'order_id' => $orderId,
            'message'  => 'Pedido registrado exitosamente.'
        ]);
    }
}