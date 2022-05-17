<?php

include_once(DIR_APPLICATION . 'controller/extension/Classes/CustomSession.php');

/**
 * Subscription controller
 */
class ControllerExtensionModuleCustomSubscription extends Controller
{
    /**
     * Subscription template rendering
     *
     * @return void
     */
    public function index()
    {

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

        $data['_tokenSubscription'] = $this->_tokenSubscription();

        // Rturn template for rendering if user is not logged
        if (!$this->customer->isLogged()) {
            return $this->load->view('extension/module/custom_subscription', $data);
        }
    }

    /**
     * Add email to the database
     *
     * @return void
     */
    public function addEmail()
    {
        $json = array();

        // Load model
        $this->load->model('extension/module/custom_subscription');

        if (isset($this->request->post['email'])) {
            $email = $this->request->post['email'];
        } else {
            $email = '';
        }

        if (empty($email)) {
            $json['error'] = "Please, fill email address";
        } else {

            if ($this->isValidEmail($email)) {
                $this->model_extension_module_custom_subscription->add($email);
                $json['success'] = "Email address has been added successfully";
            } else {
                $json['error'] = "Wrong email!";
            }
        }

        $this->response->addHeader('Content-type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    /**
     * Validate email
     *
     * @param String $email
     * @return Bool
     */
    public function isValidEmail(String $email): Bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Generate token
     * @private
     * @return mixed
     */
    public function _tokenSubscription()
    {
        if (!CustomSession::has("token_subscription")) {
            $randomToken = str_replace("=", "", base64_encode(openssl_random_pseudo_bytes(32)));
            CustomSession::add("token_subscription", $randomToken);
        }

        return CustomSession::get("token_subscription");
    }

    /**
     * Verify token
     * @param $requestToken
     * @param $regenerate
     * @return boolean
     */
    public function verifyCSRFTokenSubscription($requestToken, $regenerate = true)
    {
        if (CustomSession::has("token_subscription") && CustomSession::get("token_subscription") === $requestToken) {
            if ($regenerate) {
                CustomSession::remove("token_subscription");
            }
            return true;
        }
        return false;
    }
}
