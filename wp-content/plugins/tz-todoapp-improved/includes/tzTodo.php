<?php

class tzTodo {

    protected $option_name = 'tz-todo';

    protected $data = array(
        'website_url' => '',
        'address'     => '',
        'phone1'      => '',
        'phone2'      => '',
        'hotline'     => '',
        'copyright'   => '',
        'marquee_str' => '',  // chu chay o trang chu
        'bankname'    => '',
        'banknumber'  => '',
        'bankaccount' => '',
    );

    public function __construct() {

        add_action('init', array($this, 'init'));
        add_filter("manage_tz_todo_posts_columns", array($this, 'change_columns'));

        // The two last optional arguments to this function are the
        // priority (10) and number of arguments that the function expects (2):
        add_action("manage_posts_custom_column", array($this, "custom_columns"), 10, 2);

        // These hooks will handle AJAX interactions. We need to handle
        // ajax requests from both logged in users and anonymous ones:
        add_action('wp_ajax_nopriv_tz_ajax', array($this, 'ajax'));
        add_action('wp_ajax_tz_ajax', array($this, 'ajax'));

        // Admin sub-menu
        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_menu', array($this, 'add_page'));

        // Listen for the activate event
        register_activation_hook(TZ_TODO_FILE, array($this, 'activate'));

        // Deactivation plugin
        register_deactivation_hook(TZ_TODO_FILE, array($this, 'deactivate'));
    }

    public function activate() {
        update_option($this->option_name, $this->data);
    }

    public function deactivate() {
        delete_option($this->option_name);
    }

    public function init() {

        // When a URL like /todo is requested from the,
        // blog (the URL is customizable) we will directly
        // include the index.php file of the application and exit
        $result = get_option('tz-todo');

        if (preg_match('/\/' . preg_quote($result['website_url']) . '\/?$/', $_SERVER['REQUEST_URI'])) {

			// This will show the stylesheet in wp_head() in the app/index.php file
	        wp_enqueue_style('stylesheet', plugins_url('tz-todoapp/app/assets/css/styles.css'));

			// This will show the scripts in the footer
	        wp_deregister_script('jquery');
	        wp_enqueue_script('jquery', 'http://code.jquery.com/jquery-1.8.2.min.js', array(), false, true);
	        wp_enqueue_script('script', plugins_url('tz-todoapp/app/assets/js/script.js'), array('jquery'), false, true);

            require TZ_TODO_PATH . '/app/index.php';
            exit;
        }

        $this->add_post_type();
    }

    // White list our options using the Settings API
    public function admin_init() {
        register_setting('todo_list_options', $this->option_name, array($this, 'validate'));
    }

    // Add entry in the settings menu
    public function add_page() {
        // add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);
        add_options_page('Thông Tin Site', 'Thông Tin Site', 'manage_options', 'todo_list_options', array($this, 'options_do_page'));
    }

    // Print the menu page itself
    public function options_do_page() {
        $options = get_option($this->option_name);
        ?>
        <div class="wrap">
            <h2>Thông Tin Site</h2>
            <form method="post" action="options.php">
                <?php settings_fields('todo_list_options'); ?>
                <table class="form-table">
                    <tr valign="top"><th scope="row">WebSite URL:</th>
                        <td><input type="text" style="width: 50%" name="<?php echo $this->option_name?>[website_url]" value="<?php echo $options['website_url']; ?>" /></td>
                    </tr>
                    <tr valign="top"><th scope="row">Địa Chỉ:</th>
                        <td><input type="text" style="width: 50%" name="<?php echo $this->option_name?>[address]" value="<?php echo $options['address']; ?>" /></td>
                    </tr>
                    <tr valign="top"><th scope="row">Điện Thoại 1:</th>
                        <td><input type="text" style="width: 50%" name="<?php echo $this->option_name?>[phone1]" value="<?php echo $options['phone1']; ?>" /></td>
                    </tr>
                    <tr valign="top"><th scope="row">Điện Thoại 2:</th>
                        <td><input type="text" style="width: 50%" name="<?php echo $this->option_name?>[phone2]" value="<?php echo $options['phone2']; ?>" /></td>
                    </tr>
                    <tr valign="top"><th scope="row">Hotline (24/7):</th>marquee_str
                        <td><input type="text" style="width: 50%" name="<?php echo $this->option_name?>[hotline]" value="<?php echo $options['hotline']; ?>" /></td>
                    </tr>
                    <tr valign="top"><th scope="row">Bản Quyền:</th>
                        <td><input type="text" style="width: 50%" name="<?php echo $this->option_name?>[copyright]" value="<?php echo $options['copyright']; ?>" /></td>
                    </tr>
                    <tr valign="top"><th scope="row">Chữ Chạy:</th>
                        <td><input type="text" style="width: 50%" name="<?php echo $this->option_name?>[marquee_str]" value="<?php echo $options['marquee_str']; ?>" /></td>
                    </tr>
                    <tr valign="top"><th scope="row">Tên Ngân Hàng:</th>
                        <td><input type="text" style="width: 50%" name="<?php echo $this->option_name?>[bankname]" value="<?php echo $options['bankname']; ?>" /></td>
                    </tr>
                    <tr valign="top"><th scope="row">Số Tài Khoản:</th>
                        <td><input type="text" style="width: 50%" name="<?php echo $this->option_name?>[banknumber]" value="<?php echo $options['banknumber']; ?>" /></td>
                    </tr>
                    <tr valign="top"><th scope="row">Người Giao Dịch:</th>
                        <td><input type="text" style="width: 50%" name="<?php echo $this->option_name?>[bankaccount]" value="<?php echo $options['bankaccount']; ?>" /></td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                </p>
            </form>
        </div>
        <?php
    }

    public function validate($input) {

        $valid = array();
        $valid['website_url'] = sanitize_text_field($input['website_url']);
        $valid['address']     = sanitize_text_field($input['address']);
        $valid['phone1']      = sanitize_text_field($input['phone1']);
        $valid['phone2']      = sanitize_text_field($input['phone2']);
        $valid['hotline']     = sanitize_text_field($input['hotline']);
        $valid['copyright']   = sanitize_text_field($input['copyright']);
        $valid['marquee_str'] = sanitize_text_field($input['marquee_str']);
        $valid['bankname']    = sanitize_text_field($input['bankname']);
        $valid['banknumber']  = sanitize_text_field($input['banknumber']);
        $valid['bankaccount'] = sanitize_text_field($input['bankaccount']);

   //      if (strlen($valid['website_url']) == 0) {
   //          add_settings_error(
   //                  'todo_url', 					// setting title
   //                  'todourl_texterror',			// error ID
   //                  'Please enter a valid URL',		// error message
   //                  'error'							// type of message
   //          );

			// # Set it to the default value
			// $valid['website_url'] = $this->data['website_url'];
   //      }
   //      if (strlen($valid['address']) == 0) {
   //          add_settings_error(
   //                  'todo_title',
   //                  'todotitle_texterror',
   //                  'Please enter a title',
   //                  'error'
   //          );

			// $valid['address'] = $this->data['address'];
   //      }

        return $valid;
    }


    // This method is called when an
    // AJAX request is made to the plugin

    public function ajax() {
        $id = -1;
        $data = '';
        $verb = '';

        $response = array();

        if (isset($_POST['verb'])) {
            $verb = $_POST['verb'];
        }

        if (isset($_POST['id'])) {
            $id = (int) $_POST['id'];
        }

        if (isset($_POST['data'])) {
            $data = wp_strip_all_tags($_POST['data']);
        }

        $post = null;

        if ($id != -1) {
            $post = get_post($id);

            // Make sure that the passed id actually
            // belongs to a post of the tz_todo type

            if ($post && $post->post_type != 'tz_todo') {
                exit;
            }
        }

        switch ($verb) {
            case 'save':

                $todo_item = array(
                    'post_title' => $data,
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_type' => 'tz_todo',
                );

                if ($post) {

                    // Adding an id to the array will cause
                    // the post with that id to be edited
                    // instead of a new entry to be created.

                    $todo_item['ID'] = $post->ID;
                }

                $response['id'] = wp_insert_post($todo_item);
                break;

            case 'check':

                if ($post) {
                    update_post_meta($post->ID, 'status', 'Completed');
                }

                break;

            case 'uncheck':

                if ($post) {
                    delete_post_meta($post->ID, 'status');
                }

                break;

            case 'delete':
                if ($post) {
                    wp_delete_post($post->ID);
                }
                break;
        }

        // Print the response as json and exit
        header("Content-type: application/json");
        die(json_encode($response));
    }

    private function add_post_type() {

        // The register_post_type function
        // will make a new Todo item entry
        // in the wordpress admin menu

        register_post_type('tz_todo', array(
            'labels' => array(
                'name' => __('Todo items'),
                'singular_name' => __('Todo item')
            ),
            'public' => true,
            'supports' => array('title') // Only a title is allowed for this type
                )
        );
    }

    public function change_columns($cols) {

        // We need to customize the columns
        // shown when viewing the Todo items
        // post type to include a status field

        $cols = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Task'),
            'status' => __('Status'),
            'date' => __('Date'),
        );

        return $cols;
    }

    public function custom_columns($column, $post_id) {

        // Add content to the status column

        switch ($column) {

            case "status":
                // We are requesting the status meta item

                $status = get_post_meta($post_id, 'status', true);

                if ($status != 'Completed') {
                    $status = 'Not completed';
                }

                echo $status;

                break;
        }
    }

}
