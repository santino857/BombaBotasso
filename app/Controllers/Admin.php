<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CommentModel;
use App\Models\InquiryModel;
use App\Models\OrderModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected ProductModel $productModel;
    protected CommentModel $commentModel;
    protected InquiryModel $inquiryModel;
    protected OrderModel $orderModel;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->commentModel = new CommentModel();
        $this->inquiryModel = new InquiryModel();
        $this->orderModel   = new OrderModel();
        $this->userModel    = new UserModel();
    }

    public function index()
    {
        $data = [
            'products'      => $this->productModel->orderBy('id', 'DESC')->findAll(),
            'comments'      => $this->commentModel->orderBy('id', 'DESC')->findAll(),
            'inquiries'     => $this->inquiryModel->orderBy('id', 'DESC')->findAll(),
            'orders'        => $this->orderModel->orderBy('id', 'DESC')->findAll(),
            'users'         => $this->userModel->orderBy('id', 'DESC')->findAll(),
            'productCount'  => $this->productModel->countAllResults(),
            'commentCount'  => $this->commentModel->countAllResults(),
            'inquiryCount'  => $this->inquiryModel->countAllResults(),
            'orderCount'    => $this->orderModel->countAllResults(),
            'userCount'     => $this->userModel->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }

    // --- PRODUCTS MANAGEMENT ---
    public function createProduct()
    {
        $rules = [
            'name'  => 'required|min_length[3]|max_length[150]',
            'price' => 'required|decimal',
            'tag'   => 'required|max_length[50]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Por favor verifica los datos del producto.');
        }

        $imageName = $this->request->getPost('image') ?: 'img 2.jpg';
        $whatsappMsg = $this->request->getPost('whatsapp_msg') ?: 'Hola! Quisiera consultar por ' . $this->request->getPost('name') . '.';

        $this->productModel->insert([
            'name'         => trim($this->request->getPost('name')),
            'description'  => trim($this->request->getPost('description') ?: ''),
            'price'        => (float) $this->request->getPost('price'),
            'tag'          => trim($this->request->getPost('tag')),
            'image'        => $imageName,
            'whatsapp_msg' => $whatsappMsg,
            'active'       => $this->request->getPost('active') !== null ? 1 : 0,
        ]);

        return redirect()->to(base_url('admin#productos'))->with('exito', '¡Producto creado exitosamente!');
    }

    public function updateProduct($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'El producto no existe.');
        }

        $this->productModel->update($id, [
            'name'         => trim($this->request->getPost('name')),
            'description'  => trim($this->request->getPost('description') ?: ''),
            'price'        => (float) $this->request->getPost('price'),
            'tag'          => trim($this->request->getPost('tag')),
            'image'        => $this->request->getPost('image') ?: $product['image'],
            'whatsapp_msg' => $this->request->getPost('whatsapp_msg') ?: $product['whatsapp_msg'],
            'active'       => $this->request->getPost('active') !== null ? 1 : 0,
        ]);

        return redirect()->to(base_url('admin#productos'))->with('exito', '¡Producto actualizado exitosamente!');
    }

    public function toggleProduct($id)
    {
        $product = $this->productModel->find($id);
        if ($product) {
            $newStatus = $product['active'] ? 0 : 1;
            $this->productModel->update($id, ['active' => $newStatus]);
            return redirect()->to(base_url('admin#productos'))->with('exito', 'Estado del producto actualizado.');
        }
        return redirect()->back()->with('error', 'Producto no encontrado.');
    }

    public function deleteProduct($id)
    {
        $this->productModel->delete($id);
        return redirect()->to(base_url('admin#productos'))->with('exito', 'Producto eliminado.');
    }

    // --- COMMENTS MANAGEMENT ---
    public function toggleComment($id)
    {
        $comment = $this->commentModel->find($id);
        if ($comment) {
            $newStatus = ($comment['status'] === 'approved') ? 'hidden' : 'approved';
            $this->commentModel->update($id, ['status' => $newStatus]);
            return redirect()->to(base_url('admin#comentarios'))->with('exito', 'Visibilidad del comentario modificada.');
        }
        return redirect()->back()->with('error', 'Comentario no encontrado.');
    }

    public function deleteComment($id)
    {
        $this->commentModel->delete($id);
        return redirect()->to(base_url('admin#comentarios'))->with('exito', 'Comentario eliminado.');
    }

    // --- INQUIRIES MANAGEMENT ---
    public function markInquiry($id)
    {
        $inquiry = $this->inquiryModel->find($id);
        if ($inquiry) {
            $newStatus = ($inquiry['status'] === 'pending') ? 'answered' : 'pending';
            $this->inquiryModel->update($id, ['status' => $newStatus]);
            return redirect()->to(base_url('admin#consultas'))->with('exito', 'Estado de la consulta actualizado.');
        }
        return redirect()->back()->with('error', 'Consulta no encontrada.');
    }

    public function deleteInquiry($id)
    {
        $this->inquiryModel->delete($id);
        return redirect()->to(base_url('admin#consultas'))->with('exito', 'Consulta eliminada.');
    }

    // --- ORDERS MANAGEMENT ---
    public function updateOrderStatus($id)
    {
        $status = $this->request->getPost('status');
        if (in_array($status, ['pending', 'confirmed', 'delivered', 'cancelled'])) {
            $this->orderModel->update($id, ['status' => $status]);
            return redirect()->to(base_url('admin#pedidos'))->with('exito', 'Estado del pedido actualizado.');
        }
        return redirect()->back()->with('error', 'Estado inválido.');
    }

    public function deleteOrder($id)
    {
        $this->orderModel->delete($id);
        return redirect()->to(base_url('admin#pedidos'))->with('exito', 'Pedido eliminado.');
    }

    // --- USERS MANAGEMENT ---
    public function changeUserRole($id)
    {
        $user = $this->userModel->find($id);
        if ($user) {
            $newRole = $this->request->getPost('role');
            if (in_array($newRole, ['client', 'admin'])) {
                // Prevent self-demotion from admin
                if ($user['id'] == session()->get('id') && $newRole !== 'admin') {
                    return redirect()->to(base_url('admin#usuarios'))->with('error', 'No podés quitarte tus propios permisos de administrador.');
                }
                $this->userModel->update($id, ['role' => $newRole]);
                return redirect()->to(base_url('admin#usuarios'))->with('exito', 'Rol del usuario modificado exitosamente.');
            }
        }
        return redirect()->back()->with('error', 'Usuario no encontrado o rol inválido.');
    }
}
