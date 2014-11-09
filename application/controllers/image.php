<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Image extends App_Controller {
    public function __construct() {
       
        $this->models[] = 'user';

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
        
    }
    
    public function index($start = 0) {

       if($this->user->logged_in!==TRUE)
            redirect('/authentication/log_in');
        
        if ($this->input->post('btn_upload')) {
            $this->upload();
        }

        $this->load->library('pagination');

        $c_paginate['base_url'] = site_url('image/index');
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

        $this->load->view('images/index', $this->data);
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
                'width' => 100,
                'height' => 100,
                'new_image' => $new_image
            );

            $this->load->library('image_lib', $c_img_lib);
            $this->image_lib->resize();
        } else {
            $this->data['error'] = $this->upload->display_errors();
        }
    }

    public function delete($ori_img) {
        unlink($this->data['dir']['original'] . $ori_img);
        unlink($this->data['dir']['thumb'] . 'thumb_' . $ori_img);
        redirect('/image');
    }

    public function gallery($start = 0) {

        try {

            $this->load->library('pagination');

            $c_paginate['base_url'] = site_url('image/index');
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
            
            $this->load->view('images/gallery', $this->data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */