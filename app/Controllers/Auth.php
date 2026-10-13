<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/'));
        }
        return view('auth/register');
    }

    public function processRegister()
    {
        $rules = [
            'name'             => 'required|min_length[3]|max_length[100]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'permit_empty|matches[password]'
        ];

        $messages = [
            'name' => [
                'required'   => 'El nombre completo es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            ],
            'email' => [
                'required'    => 'El correo electrónico es obligatorio.',
                'valid_email' => 'Debés ingresar un correo electrónico válido.',
                'is_unique'   => 'Ese correo ya se encuentra registrado. Podés iniciar sesión.',
            ],
            'password' => [
                'required'   => 'La contraseña es obligatoria.',
                'min_length' => 'La contraseña debe tener al menos 6 caracteres.',
            ],
            'password_confirm' => [
                'matches' => 'Las contraseñas no coinciden.',
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errores', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userModel->insert([
            'name'     => trim($this->request->getPost('name')),
            'email'    => strtolower(trim($this->request->getPost('email'))),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'client'
        ]);

        return redirect()->to(base_url('login'))->with('exito', '¡Registro completado! Ya podés iniciar sesión con tu cuenta.');
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('/'));
        }
        return view('auth/login');
    }

    public function processLogin()
    {
        $userModel = new UserModel();
        $email    = strtolower(trim($this->request->getPost('email') ?? ''));
        $password = $this->request->getPost('password') ?? '';

        if (empty($email) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Por favor completá todos los campos.');
        }

        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'id'         => $user['id'],
                'name'       => $user['name'],
                'email'      => $user['email'],
                'role'       => $user['role'],
                'isLoggedIn' => true
            ]);

            return redirect()->to(base_url('/'))->with('exito', '¡Bienvenido de nuevo, ' . esc($user['name']) . '!');
        }

        return redirect()->back()->withInput()->with('error', 'Correo electrónico o contraseña incorrectos.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'))->with('info', 'Has cerrado tu sesión.');
    }
}