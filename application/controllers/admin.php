<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends App_Controller {

    //protected $layout='layouts/administration';
    protected $authenticate = 'administrator';
    
    public function __construct() {
        $this->models[] = 'content';
        $this->models[] = 'blog';
        $this->models[] = 'news_feed';

        $this->data=array_merge($this->data,array(
            'dir' => array(
                'original' => 'assets/uploads/original/',
                'thumb' => 'assets/uploads/thumbs/'
            ),
            'total' => 0,
            'images' => array(),
            'error' => ''
        ));

        parent::__construct();

        $this->asides['notifications'] = 'asides/notifications';
        $this->js[] = '/plugins/tinymce/js/tinymce/tinymce.min.js';
        $this->js[] = '/plugins/fancybox2/jquery.fancybox.pack.js';
        $this->js[] = '/plugins/jquery-ui/js/jquery-ui-1.10.3.custom.min.js';
        $this->css[] = '/plugins/jquery-ui/css/smoothness/jquery-ui.min.css';
        $this->js[] = 'js/admin.js';
        //$this->less_css[] = 'admin.less';
        // array_unshift($this->css,'css/admin.css');
        $this->css[] = 'css/admin.css';

        $this->data['nav_data']=array(
            'admin'=>array(
                'title'=>'Dashboard',
            ),
            'admin/gallery'=>array(
                'title'=>'Manage Gallery',
            ),
            'authentication/log_out'=>array('title'=>'Log Out'),
        );
    }

    public function index() {
        try {
            $post = $this->input->post();
            if (is_array($post))
                $post = array_map('trim', $post);

            if (isset($post['action'])) {
                $action = $post['action'];
                unset($post['action']);

                if ($action === 'Save Content') {
                    $this->content->update($post);
                } elseif ($action === 'Add New Page') {
                    $this->content->insert($post);
                } elseif ($action === 'Delete Page') {
                    $this->content->delete($post['name']);
                } elseif ($action === 'Save Configuration') {
                    $this->configuration->save($post);
                } elseif ($action === 'Save Color Scheme') {
                    $this->configuration->set_colors($post);
                } elseif ($action === 'Save Social Media') {
                    $this->configuration->set_social_media($post);
                }
            }
        } catch (Exception $e) {
            $this->errors[] = $e->getMessage();
        }

        $this->data['content'] = $this->content->get_all();
        $this->data['configuration'] = $this->configuration->get_all();
        $this->data['colors'] = $this->configuration->get_colors();
        $this->data['social_media'] = $this->configuration->get_social_media();
    }

    public function homepage_image()
    {
        $successful_upload=FALSE;

        if($this->input->post())
        {
            $this->load->library('form_validation');
            $this->load->library('upload',array(
                'upload_path'=>'assets/img/layout',
                'file_name'=>'homepage-intro.png',
                'overwrite'=>TRUE,
                'allowed_types'=>'jpg|jpeg|bmp|gif|png',
            ));

            $successful_upload=$this->upload->do_upload('image');

            //$uploaded_image_data=$this->upload->data();

            // if($uploaded_image_data['is_image']!=1)
            // {
            //     $this->form_validation->set_error('The uploaded file must be an image.');
            // }

            // if($uploaded_image_data['image_width']<1200)
            // {
            //     $this->form_validation->set_error('The uploaded image must be at least 1200px wide.');
            // }

            // if($uploaded_image_data['image_height']<900)
            // {
            //     $this->form_validation->set_error('The uploaded image must be at least 900px tall.');
            // }

            // // If there are no errors
            // if($this->upload->do_upload('image') && count($this->form_validation->get_errors())==0)
            // {
            //     $image_lib_config=array(
            //         'source_image'=>'assets/img/layout/homepage-intro_tmp.png',
            //         'new_image'=>'assets/img/layout/homepage-intro_tmp2.png',
            //     );

            //     $use_y=FALSE;
            //     $w=$uploaded_image_data['image_width'];
            //     $h=$uploaded_image_data['image_height'];
            //     $ratio=$h/$w;

            //     if($ratio<.75)
            //     {
            //         $use_y=TRUE;
            //     }

            //     if($use_y)
            //     {
            //         $image_lib_config['height']=900;
            //     }
            //     else
            //     {
            //         $image_lib_config['width']=1200;
            //     }

            //     $this->load->library('image_lib',$image_lib_config);
            //     $this->image_lib->resize();
            // }
        }

        $this->data['successful_upload']=$successful_upload;
    }

    public function blog() {
        $this->layout = 'blank';
        $this->authenticate = 'blogger';
        $this->data['blogs'] = $this->blog->get_all();
    }

    public function news_feed() {
        $this->layout = 'blank';
        $this->authenticate = 'blogger';
        $this->data['news'] = $this->news_feed->get_all();
    }

    public function blog_add() {
        $this->layout = 'blank';
        $this->authenticate = 'blogger';
        $this->load->library('valid');
        $post = $this->input->post();
        if (empty($post))
            redirect('/admin/blog/');
        $err = $this->valid->validate(
                $post, array(
            array('name', ''),
            array('content', '')
                )
        );


        if ($err) {
            $this->data = array_merge($this->data, $post);
            $this->errors[] = $err;
        } else {
            $this->blog->create($post['name'], $post['content']);
            $this->notifications[] = 'Blog Posted!';
        }

        $this->blog();
        $this->view = 'admin/blog';
    }

    public function news_feed_add() {
        $this->layout = 'blank';
        $this->authenticate = 'blogger';
        $this->load->library('valid');
        $post = $this->input->post();
        if (empty($post))
            redirect('/admin/news_feed/');
        $err = $this->valid->validate(
                $post, array(
            array('name', ''),
            array('content', '')
                )
        );


        if ($err) {
            $this->data = array_merge($this->data, $post);
            $this->errors[] = $err;
        } else {
            $this->news_feed->create($post['name'], $post['content']);
            $this->notifications[] = 'News Posted!';
        }

        $this->news_feed();
        $this->view = 'admin/news_feed';
    }

    public function blog_edit($id) {
        $this->layout = 'blank';
        $this->authenticate = 'blogger';
        $this->load->library('valid');
        $post = $this->input->post();
        if (empty($post)) {
            $blog = $this->blog->get($id);
            $this->data = array_merge($this->data, $blog);
            return;
        }
        $err = $this->valid->validate(
                $post, array(
            array('name', ''),
            array('content', '')
                )
        );
        if ($err) {
            $this->data = array_merge($this->data, $post);
            $this->data['id'] = $id;
            $this->errors[] = $err;
        } else {
            $this->db->where('id', $id)->update('blog', $post);
            $this->notifications[] = 'Changes Saved!';
        }

        $this->blog();
        $this->view = 'admin/blog';
    }

    public function news_feed_edit($id) {
        $this->layout = 'blank';
        $this->authenticate = 'blogger';
        $this->load->library('valid');
        $post = $this->input->post();
        if (empty($post)) {
            $blog = $this->news_feed->get($id);
            $this->data = array_merge($this->data, $blog);
            return;
        }
        $err = $this->valid->validate(
                $post, array(
            array('name', ''),
            array('content', '')
                )
        );
        if ($err) {
            $this->data = array_merge($this->data, $post);
            $this->data['id'] = $id;
            $this->errors[] = $err;
        } else {
            $this->db->where('id', $id)->update('news_feed', $post);
            $this->notifications[] = 'Changes Saved!';
        }

        $this->news_feed();
        $this->view = 'admin/news_feed';
    }

    public function blog_delete($id) {
        $this->layout = 'blank';
        $this->authenticate = 'blogger';
        $this->db->where('id', $id)->delete('blog');
        $this->notifications[] = 'Blog Deleted!';
        $this->blog();
        $this->view = 'admin/blog';
    }

    public function news_feed_delete($id) {
        $this->layout = 'blank';
        $this->authenticate = 'blogger';
        $this->db->where('id', $id)->delete('news_feed');
        $this->notifications[] = 'News Deleted!';
        $this->news_feed();
        $this->view = 'admin/news_feed';
    }

    public function gallery($start = 0) {

        if ($this->user->logged_in !== TRUE)
            redirect('/authentication/log_in');

        if ($this->input->post('btn_upload')) {
            $this->upload();
        }

        $this->load->library('pagination');

        $c_paginate['base_url'] = site_url('admin/gallery');
        $c_paginate['per_page'] = '9';
        $finish = $start + $c_paginate['per_page'];

        if (is_dir($this->data['dir']['thumb'])) {
            $i = 0;
            if ($dh = opendir($this->data['dir']['thumb'])) {
                while (($file = readdir($dh)) !== false) {
                    // get file extension
                    $ext = strrev(strstr(strrev($file), ".", TRUE));
                    if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
                        if ($start <= $this->data['total'] && $this->data['total'] < $finish) {
                            $this->data['images'][$i]['thumb'] = $file;
                            $this->data['images'][$i]['original'] = str_replace('thumb_', '', $file);
                            $i++;
                        }
                        $this->data['total']++;
                    }
                }
                closedir($dh);
            }
        }

        $c_paginate['total_rows'] = $this->data['total'];

        $this->pagination->initialize($c_paginate);

        //$this->load->view('admin/gallery', $this->data);
    }

        private function upload() {
        $c_upload['upload_path'] = $this->data['dir']['original'];
        $c_upload['allowed_types'] = 'gif|jpg|png|jpeg|x-png';
        $c_upload['max_size'] = '5000';
        $c_upload['max_width'] = '1600';
        $c_upload['max_height'] = '1200';
        $c_upload['remove_spaces'] = TRUE;

        $this->load->library('upload', $c_upload);

        if ($this->upload->do_upload()) {

            $img = $this->upload->data();

            // create thumbnail
            $new_image = $this->data['dir']['thumb'] . 'thumb_' . $img['file_name'];

            $c_img_lib = array(
                'image_library' => 'gd2',
                'source_image' => $img['full_path'],
                'maintain_ratio' => TRUE,
                'width' => 200,
                'height' => 200,
                'new_image' => $new_image
            );

            $this->load->library('image_lib', $c_img_lib);
            $this->image_lib->resize();
        } else {
            $this->data['error'] = $this->upload->display_errors();
        }
    }

    public function gallery_img_delete($ori_img) {
        unlink($this->data['dir']['original'] . $ori_img);
        unlink($this->data['dir']['thumb'] . 'thumb_' . $ori_img);
        redirect('admin/gallery');
    }
    
    
}

/* End of file administration.php */
/* Location: ./application/controllers/administration/administration.php */