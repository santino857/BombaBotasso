<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\InquiryModel;
use App\Models\CommentModel;

class Orders extends BaseController
{
    protected OrderModel $orderModel;
    protected OrderItemModel $orderItemModel;
    protected InquiryModel $inquiryModel;
    protected CommentModel $commentModel;

    public function __construct()
    {
        $this->orderModel      = new OrderModel();
        $this->orderItemModel  = new OrderItemModel();
        $this->inquiryModel    = new InquiryModel();
        $this->commentModel    = new CommentModel();
    }

    /**
     * Vista de "Mis Pedidos" para el cliente autenticado
     * Protegida por AuthFilter
     */
    public function myOrders()
    {
        $userId = (int) session()->get('id');

        $orders = $this->orderModel->getOrdersByUser($userId);

        foreach ($orders as &$order) {
            $order['items'] = $this->orderItemModel->getItemsByOrder((int) $order['id']);
        }
        unset($order);

        $myInquiries = $this->inquiryModel->getInquiriesByUser($userId);
        $myComments  = $this->commentModel->getCommentsByUser($userId);

        return view('client/orders', [
            'orders'      => $orders,
            'myInquiries' => $myInquiries,
            'myComments'  => $myComments,
            'userName'    => session()->get('name'),
            'userEmail'   => session()->get('email'),
        ]);
    }

    /**
     * Detalle específico de un pedido (API / Modal)
     */
    public function orderDetails(int $orderId)
    {
        $order = $this->orderModel->find($orderId);

        if (!$order) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'El pedido solicitado no existe.'
            ])->setStatusCode(404);
        }

        $userId = (int) session()->get('id');
        $role   = session()->get('role');

        // Control de permisos: solo el dueño o un admin pueden ver el detalle
        if ($order['user_id'] != $userId && $role !== 'admin') {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Acceso denegado: no tenés permisos para visualizar este pedido.'
            ])->setStatusCode(403);
        }

        $order['items'] = $this->orderItemModel->getItemsByOrder($orderId);

        return $this->response->setJSON([
            'status' => 'success',
            'order'  => $order
        ]);
    }
}
