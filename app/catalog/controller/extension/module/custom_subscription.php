<?php
/**
 * Subscription controller
 */
class ControllerExtensionModuleCustomSubscription extends Controller {
    /**
     * Subscription template rendering
     *
     * @return void
     */
	public function index() {

        // Check existing of the template file
        if (!file_exists((DIR_TEMPLATE . 
            $this->config->get('config_theme') . 
            '/template/extension/module/custom_subscription.tpl'))) {
            return;
        }

        // Load language
		$this->load->language('extension/module/custom_subscription');
        
        // Language translations
        $data['heading_title'] = $this->language->get('heading_title');
        
        $data['text_email'] = $this->language->get('text_email');
        $data['text_placeholder'] = $this->language->get('text_placeholder');

        $data['btn_subscription'] = $this->language->get('btn_subscription');

        // Rturn template for rendering
        return $this->load->view('extension/module/custom_subscription', $data);
	}
}
