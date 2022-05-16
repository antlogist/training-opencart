<?php

/**
 * Controller for email collection
 */
class ControllerExtensionModuleCustomSubscription extends Controller
{

    /**
     * Errors array
     *
     * @var array
     */
    private $error = array();

    /**
     * Basic function of the controller
     * Collect information for the rendering
     * Process requests
     *
     * @return void
     */
    public function index()
    {

        // Load translation
        $this->load->language('extension/module/custom_subscription');

        // Set title
        $this->document->setTitle($this->language->get('heading_title'));

        // Load model
        $this->load->model('extension/module');

        // If post request was validated
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            // If no module ID -> add new module else get id from the request and edit current module
            if (!isset($this->request->get['module_id'])) {
                $this->model_extension_module->addModule('custom_subscription', $this->request->post);
            } else {
                $this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
            }

            // Add success message to the session
            $this->session->data['success'] = $this->language->get('text_success');

            // Redirect to the url answer
            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
        }

        // Title
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        // Form fields
        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_status'] = $this->language->get('entry_status');

        // Buttons
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        // If error property 'warning'
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        // If error property 'name'
        if (isset($this->error['name'])) {
            $data['error_name'] = $this->error['name'];
        } else {
            $data['error_name'] = '';
        }

        // Breadcrumbs init
        $data['breadcrumbs'] = array();

        // Set breadcrumbs home link and text
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        // Set breadcrumbs extension link and text
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
        );

        // Set breadcrumbs module link and text
        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/custom_subscription', 'token=' . $this->session->data['token'], true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/custom_subscription', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
            );
        }

        // Set action link
        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('extension/module/custom_subscription', 'token=' . $this->session->data['token'], true);
        } else {
            $data['action'] = $this->url->link('extension/module/custom_subscription', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
        }

        // Set cancel link
        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

        // If request contains module id and request method is not a post
        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
        }

        // Set name field
        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }

        // Set status field
        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = '';
        }

        // Load header, left column and footer
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        // Return data to the view for rendering
        $this->response->setOutput($this->load->view('extension/module/custom_subscription', $data));
    }

    /**
     * User permission and name property validation
     *
     * @return void
     */
    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/custom_subscription')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        return !$this->error;
    }

    /**
     * Create table
     *
     * @return void
     */
	public function install() {
		$this->load->model('extension/module/custom_subscription');

		$this->model_extension_module_custom_subscription->install();
	}

    /**
     * Drop table
     *
     * @return void
     */
	public function uninstall() {
		$this->load->model('extension/module/custom_subscription');

		$this->model_extension_module_custom_subscription->uninstall();
	}
}
