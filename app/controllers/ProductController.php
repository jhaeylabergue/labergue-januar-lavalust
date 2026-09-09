<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller
{
    private function boot(): void
    {
        $this->call->database();
        $this->call->model('ProductModel');
        $this->call->library('session');
        $this->call->helper('url');
    }

    private function currentUser(): string
    {
        return (string) ($this->session->userdata('username') ?: 'User');
    }

    public function index()
    {
        $this->boot();

        $products = $this->ProductModel->order_by('id', 'DESC');

        $data['products'] = $products ?: [];
        $data['page_title'] = 'Products — Lab 5';
        $data['username'] = $this->currentUser();
        $data['success'] = $this->session->flashdata('success');
        $data['error'] = $this->session->flashdata('error');

        $this->call->view('products/index', $data);
    }

    public function create()
    {
        $this->boot();

        $data['page_title'] = 'Add Product';
        $data['username'] = $this->currentUser();
        $data['product'] = [
            'product_name' => '',
            'description'  => '',
            'price'        => '',
            'quantity'     => '',
        ];
        $data['form_action'] = site_url('products/create');
        $data['form_heading'] = 'Add Product';
        $data['submit_label'] = 'Save Product';
        $data['error'] = $this->session->flashdata('error');

        $this->call->view('products/form', $data);
    }

    public function store()
    {
        $this->boot();

        if (!$this->validateProduct()) {
            $this->session->set_flashdata('error', $this->form_validation->errors());
            redirect('products/create');
            exit;
        }

        $this->ProductModel->insert($this->productPayload());
        $this->session->set_flashdata('success', 'Product added successfully.');
        redirect('products');
        exit;
    }

    public function edit($id)
    {
        $this->boot();

        $product = $this->ProductModel->find((int) $id);
        if (!$product) {
            $this->session->set_flashdata('error', 'Product not found.');
            redirect('products');
            exit;
        }

        $data['page_title'] = 'Edit Product';
        $data['username'] = $this->currentUser();
        $data['product'] = $product;
        $data['form_action'] = site_url('products/edit/' . (int) $id);
        $data['form_heading'] = 'Edit Product';
        $data['submit_label'] = 'Update Product';
        $data['error'] = $this->session->flashdata('error');

        $this->call->view('products/form', $data);
    }

    public function update($id)
    {
        $this->boot();

        $product = $this->ProductModel->find((int) $id);
        if (!$product) {
            $this->session->set_flashdata('error', 'Product not found.');
            redirect('products');
            exit;
        }

        if (!$this->validateProduct()) {
            $this->session->set_flashdata('error', $this->form_validation->errors());
            redirect('products/edit/' . (int) $id);
            exit;
        }

        $this->ProductModel->update((int) $id, $this->productPayload());
        $this->session->set_flashdata('success', 'Product updated successfully.');
        redirect('products');
        exit;
    }

    public function delete($id)
    {
        $this->boot();

        $product = $this->ProductModel->find((int) $id);
        if (!$product) {
            $this->session->set_flashdata('error', 'Product not found.');
            redirect('products');
            exit;
        }

        $this->ProductModel->delete((int) $id);
        $this->session->set_flashdata('success', 'Product deleted successfully.');
        redirect('products');
        exit;
    }

    private function validateProduct(): bool
    {
        $this->call->library('form_validation');

        $this->form_validation
            ->name('product_name')
            ->required('Product name is required.')
            ->min_length(2, 'Product name must be at least 2 characters.');

        $this->form_validation
            ->name('description')
            ->required('Description is required.');

        $this->form_validation
            ->name('price')
            ->required('Price is required.')
            ->numeric('Price must be a number.')
            ->greater_than_equal_to(0, 'Price cannot be negative.');

        $this->form_validation
            ->name('quantity')
            ->required('Quantity is required.')
            ->numeric('Quantity must be a number.')
            ->greater_than_equal_to(0, 'Quantity cannot be negative.');

        return $this->form_validation->run();
    }

    private function productPayload(): array
    {
        return [
            'product_name' => trim((string) $this->request->post('product_name', '')),
            'description'  => trim((string) $this->request->post('description', '')),
            'price'        => number_format((float) $this->request->post('price', 0), 2, '.', ''),
            'quantity'     => (int) $this->request->post('quantity', 0),
        ];
    }
}
