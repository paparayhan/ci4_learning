<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PostModel;

class Post extends BaseController
{
    protected $model;
    public function __construct(){
        $this->model= new PostModel();
        $this->helpers = ['form','url'];
    }
    public function index()
    {
        $data = [
            'posts' => $this->model->paginate(10),
            'pager' => $this->model->pager,
            'title' => 'POST LIST'
        ];

        return view('posts/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Create new post'];

        return view('posts/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost(['title', 'content', 'status']);

        if (! $this->validateData($data, $this->model->validationRules)) {
            return $this->create();
        }

        $post = $this->validator->getValidated();

        $save = $this->model->save([
            'title' => $post['title'],
            'content' => $post['content'],
            'status' => $post['status'],
            'slug' => url_title(strtolower($post['title'])),
        ]);

        session()->setFlashdata('success', 'Post has been added successfully.');
        return redirect()->to(base_url('post'));
    }

    public function edit($id)
    {
        $post = $this->model->find($id);

        if (empty($post)) {
            session()->setFlashdata('error','Post not found');
            return redirect()->back();
        }

        $data = [
            'title' => 'Edit Post',
            'post' => $post
        ];

        return view('posts/edit', $data);

    }

    public function update($id)
    {
        $post = $this->model->find($id);

        if (empty($post)) {
            session()->setFlashdata('error','Post not found');
            return redirect()->back();
        }

        $data = $this->request->getPost(['title', 'content', 'status']);

        if (! $this->validateData($data, $this->model->validationRules)) {
            return $this->create();
        }

        $updatedPost = $this->validator->getValidated();

        $update = $this->model->update($post['id'], $updatedPost);

        if ($update) {
            session()->setFlashdata('success', 'Post has been updated successfully');
            return redirect()->to(base_url('post'));
        } else {
            session()->setFlashdata('error', 'Some problems occured, please try again.');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
       

        if (empty($id)) {
            return redirect()->to(base_url('post'));
        }

        $delete = $this->model->delete($id);

        if ($delete) {
            session()->setFlashdata('success', 'Post has been removed successfully.');
            return redirect()->to(base_url('post'));
        } else {
            session()->setFlashdata('error', 'Some problems occured, please try again.');
            return redirect()->to(base_url('post'));
        }

    }
}
