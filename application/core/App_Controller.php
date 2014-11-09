<?php
/**
 * A base controller for CodeIgniter with view autoloading, layout support,
 * model loading, helper loading, asides/partials and per-controller 404
 *
 * @link http://github.com/jamierumbelow/codeigniter-base-controller
 * @copyright Copyright (c) 2012, Jamie Rumbelow <http://jamierumbelow.net>
 */

class App_Controller extends CI_Controller
{

    /* --------------------------------------------------------------
     * VARIABLES
     * ------------------------------------------------------------ */
    
    protected $js=array(
        'vendor/jquery/jquery-1.11.1.js',
        'vendor/skrollr/skrollr.js',
    );
    protected $min_js=array();
    
    protected $css = array('css/application.css');
    
    protected $min_css = array();
    protected $less_css = array();

    protected $asides = array(
        'head_tags'=>'layouts/asides/head_tags',
        'nav'=>'layouts/asides/nav',
        'footer'=>'layouts/asides/footer',
    );

    protected $meta=array();

    protected $helpers = array('html','url','string','config');

    /**
     * The current request's view. Automatically guessed
     * from the name of the controller and action
     */
    protected $view = '';

    /**
     * An array of variables to be passed through to the
     * view, layout and any asides
     */
    protected $data = array(
        'page_header'=>FALSE,
        'page'=>FALSE,
    );

    /**
     * The name of the layout to wrap around the view.
     */
    protected $layout;

    /**
     * A list of models to be autoloaded
     */
    protected $models = array('user','configuration','content');

    /**
     * A formatting string for the model autoloading feature.
     * The percent symbol (%) will be replaced with the model name.
     */
    protected $model_string = '%_model';
    
    protected $title;
    
    protected $authenticate=FALSE;

    protected $authentication_redirect='/authentication/log_in';

    protected $errors;

    protected $notifications;

    protected $content_pages;

    /* --------------------------------------------------------------
     * GENERIC METHODS
     * ------------------------------------------------------------ */

    /**
     * Initialise the controller, tie into the CodeIgniter superobject
     * and try to autoload the models and helpers
     */
    public function __construct()
    {
        parent::__construct();

        $db_config=$this->config->item('database');
        $this->load->database($db_config);

        $this->config->load('app',TRUE);

        $this->_load_helpers();
        $this->_load_models();
        $this->_load_configuration();

        $this->data['nav_data']=$this->content->get_nav_data();
        $this->data['footer_data']=$this->content->get_footer_data();

        if($this->authenticate() === FALSE)
            redirect($this->authentication_redirect);
    }

    public function _parse_content($content,$limit=FALSE)
    {
        $this->load->helper('text');
        $content=strip_tags($content,'<p><a><img><b><i><u><strong><em><div><h1><h2><h3><h4><h5><h6>');
        $content=str_replace('<p>&nbsp;</p>','',$content);
        return $limit ? word_limiter($content,$limit) : $content;
    }

    // load custom configuration from database
    protected function _load_configuration()
    {
        $this->configuration->load();
    }

    /*
     * Output json and die, great for AJAX handlers
     */ 
    public function _json($data)
    {
        header('Content-type: application/json');
        echo json_encode($data);
        die;
    }

    /**
     * Ensure the user has access to this page
     */
    protected function authenticate()
    {
        if(!$this->authenticate)
            return TRUE;
        if($this->user->has_role($this->authenticate))
            return TRUE;

        return FALSE;
    }

    /* --------------------------------------------------------------
     * VIEW RENDERING
     * ------------------------------------------------------------ */
    
    protected function _load_data()
    {
        // Set the basic data
        $this->data['css'] = $this->css;
        //$this->data['min_css'] = $this->min_css;
        $this->data['less_css'] = $this->less_css;
        $this->data['js'] = $this->js;
       // $this->data['min_js'] = $this->min_js;
        $this->data['site_name'] = $this->config->item('site_name');
        $this->data['base_url'] = $this->config->item('base_url');
        $this->data['meta'] = $this->config->item('meta');
        $this->data['copyright'] = $this->config->item('copyright');
        $this->data['ga_code'] = $this->config->item('ga_code');
        
        // Set the global data
        $this->data['slug_id_string']=implode('-',$this->uri->rsegment_array());
        $this->data['logged_in']=$this->user->logged_in;
        $this->data['user']=$this->session->userdata('user');
        $this->data['errors']=$this->errors;
        $this->data['notifications']=$this->notifications;
        
        $this->data['content_pages'] = $this->content->get_pages();
        $this->data['social_media'] = $this->configuration->get_social_media();

        $this->data['app_title']=$this->config->item('app_title','app');
        $this->data['page_title']=$this->title;
        $this->data['title']=parse_string($this->config->item('title_format','app'),array(
            'app_title'=>$this->config->item('app_title','app'),
            'page_title'=>$this->title,
        ));

        $this->data['meta']=array_merge($this->config->item('default_meta','app'),$this->meta);
        $this->data['css']=$this->css;
        $this->data['js']=$this->js;

        $this->data['asset_path']=$this->config->item('assets_path','app');
        $this->data['uri_string']=implode('-',$this->uri->rsegment_array());
        $this->data['is_homepage']=( $this->data['uri_string']==='site-index' );
    }
    
    /**
     * Override CodeIgniter's despatch mechanism and route the request
     * through to the appropriate action. Support custom 404 methods and
     * autoload the view into the layout.
     */
    public function _remap($method)
    {
        if (method_exists($this, $method))
        {
            call_user_func_array(array($this, $method), array_slice($this->uri->rsegments, 2));
        }
        else
        {
            if (method_exists($this, '_404'))
            {
                call_user_func_array(array($this, '_404'), array($method));
            }
            else
            {
                show_404(strtolower(get_class($this)).'/'.$method);
            }
        }

        $this->_load_view();
    }

    /**
     * Automatically load the view, allowing the developer to override if
     * he or she wishes, otherwise being conventional.
     */
    protected function _load_view()
    {
        // Check for authentication
        if($this->authenticate===TRUE && $this->user->logged_in!==TRUE)
            redirect('login');
        
        // If $this->view == FALSE, we don't want to load anything
        if ($this->view !== FALSE)
        {
            // Populate data that exists for every page
            $this->_load_data();

            // Do we have any asides? Load them.
            if (!empty($this->asides))
            {
                foreach ($this->asides as $name => $file)
                {
                    $this->data['yield_'.$name] = $this->load->view($file, $this->data, TRUE);
                }
            }
            // If $this->view isn't empty, load it. If it isn't, try and guess based on the controller and action name
            $view = (!empty($this->view)) ? $this->view : $this->router->directory . $this->router->class . '/' . $this->router->method;

            // Load the view into $yield
            $this->data['yield'] = $this->load->view($view, $this->data, TRUE);

            $layout = FALSE;

            // If we didn't specify the layout, try to guess it
            if (!isset($this->layout))
            {
                if (file_exists(APPPATH . 'views/layouts/' . $this->router->class . '.php'))
                {
                    $layout = 'layouts/' . $this->router->class;
                }
                else
                {
                    $layout = 'layouts/application';
                }
            }

            // If we did, use it
            else if ($this->layout !== FALSE)
            {
                $layout = 'layouts/' . $this->layout;
            }

            // If $layout is FALSE, we're not interested in loading a layout, so output the view directly
            if ($layout == FALSE)
            {
                $this->output->set_output($this->data['yield']);
            }

            // Otherwise? Load away :)
            else
            {
                $this->load->view($layout, $this->data);
            }
        }
    }

    /* --------------------------------------------------------------
     * MODEL LOADING
     * ------------------------------------------------------------ */

    /**
     * Load models based on the $this->models array
     */
    private function _load_models()
    {
        foreach ($this->models as $model)
        {
            $this->load->model($this->_model_name($model), $model);
        }
    }

    /**
     * Returns the loadable model name based on
     * the model formatting string
     */
    protected function _model_name($model)
    {
        return str_replace('%', $model, $this->model_string);
    }

    /* --------------------------------------------------------------
     * HELPER LOADING
     * ------------------------------------------------------------ */

    /**
     * Load helpers based on the $this->helpers array
     */
    private function _load_helpers()
    {
        foreach ($this->helpers as $helper)
        {
            $this->load->helper($helper);
        }
    }
}