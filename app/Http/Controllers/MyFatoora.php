<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class MyFatoora extends Controller
{
    private $testmode = false;
    private $token = null;
    public function __construct()
    {
        if ($this->testmode || url('/') == 'http://mohame.test') {
            /**Demo test */
            $this->merchant_username = 'apiaccount@myfatoorah.com';
            $this->merchant_password = 'api12345*';
            $url = parse_url("https://apidemo.myfatoorah.com");
        }else{
            /**Real info */
            $this->merchant_username = 'ardhwatalab@gmail.com';
            $this->merchant_password = 'Yy123456%';
            $url = parse_url("https://apisa.myfatoorah.com");
            $this->token = 'Bearer vPJCKsDL8oQAyckBFPe3wBq8vpH0xUB2nracnOh9SCrx80Gk91uyLHMqwMQRNOcpeBXqJLcUPR_9aZDunQ1WDV38tph-AusaccJgc2gxtRtC9YSMgSTwnko61xglyYnNsbba6obmDWRZtr3lfweU9P77aAyNISypvJtQ7FQzlKk8rUZ6QSazPdx7yHP5ofErmLCsBCJnJPrf-VUFU05UmsPUuq9f5uNMnoZZbtYNjDEhkCl9u4qdJ1Vk5_YT3vFKr5lgmHHWoro85YCUfUZEbuntD6D-XxiUPPCRYU_GxKi7lA5etijelL9RoLOLoHZdDAUOKWptxkmOZzm8doo89PXhefB0bjzfaSuf0ZtQhtfDSJoySOzhdd5isI6aRCVatY518eghv2arYQO3pCEpTM07MRmNC_CQddZfA_NQY7BavB-jSZrlgW6DWkQx6DUtAsuT3FR7idb4rVL6mHnxGoM9gNtL1o89H0390iFtfI5eHeGB3cRheGfU6M5FXsZjdNqWmdFesyoN1yMggNiOcneYNEXR0IakHBoqX_AiaHZ9A206PPG_osft_X0MlOKfqbdDK2xL68mwFAojz1LvidZGvFCJr5ShQEiS-3v0b5YUkkY0SMrPSsEg94MTeals_t_7pfOsbuwQvDEx3g9CiF3xhpPPUIPQ4DToanwsnqCMMCHv';
        }
        $this->gateway_url = $url['scheme'] . '://' . $url['host'];
    }

    public function index()
    {
        return view('site.fatoorah');
    }
    public function getToken()
    {
        $url_token = $this->gateway_url . '/Token';
        $client_id = $this->merchant_username;
        $client_secret = $this->merchant_password;
        $params = "grant_type=password"
            . "&username=" . $client_id
            . "&password=" . $client_secret;

        $curl = curl_init($url_token);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        $json_response = curl_exec($curl);
        $response = json_decode($json_response, true);
        if (!empty($response['access_token'])) {
            $this->token = $response['token_type'] . ' ' . $response['access_token'];
            return response()->json(['status' => 'success', 'token' => $this->token]);
        }
    }

    public function getProducts()
    {
        $url = $this->gateway_url . '/Products/List';
        $this->getToken();
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: $this->token",
        ));

        $json_response = curl_exec($curl);
        $err = curl_error($curl);
        $response = json_decode($json_response, true);
        curl_close($curl);
        return $response;
    }

    public function createProductInvoice($params = null)
    {
        if (!$params) {
            $params = request()->all();
        }
        $params_string = json_encode($params);
        $url = $this->gateway_url . '/ApiInvoices/Create';
        $this->getToken();
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params_string);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Content-Length: ' . strlen($params_string), 'Accept: application/json', 'Authorization: ' . $this->token));

        $json_response = curl_exec($curl);
        $err = curl_error($curl);
        $response = json_decode($json_response, true);
        curl_close($curl);
        return $response;
    }

    public function create_product($params = null)
    {
        if (!$params) {
            $params = request()->all();
        }
        $params_string = json_encode($params);
        $url = $this->gateway_url . '/Products/Create';
        $this->getToken();

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params_string);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Content-Length: ' . strlen($params_string), 'Accept: application/json', 'Authorization: ' . $this->token));

        $json_response = curl_exec($curl);
        $err = curl_error($curl);
        $response = json_decode($json_response, true);
        curl_close($curl);

        return $response;
    }

    public function callback()
    {
        $paymentId = $_REQUEST['paymentId'];
        $url = $this->gateway_url . '/ApiInvoices/Transaction/' . $paymentId;
        $this->getToken();
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: $this->token",
        ));

        $json_response = curl_exec($curl);
        $err = curl_error($curl);
        $response = json_decode($json_response, true);
        curl_close($curl);

        if ($response['Error'] == null) {
            return 'success';
        }
        return 'faliure';
    }

    public function confirm()
    {
        $t = time();
        $url = $this->gateway_url;
        $this->load->model('checkout/order');

        $products = $this->cart->getProducts();
        if (isset($_SESSION['default']['shipping_method'])) {
            unset($_SESSION['default']['shipping_method']);
        }

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        // generate token
        // check currency in myfatoorah
        $this->getToken();

        $this->language->load('extension/payment/myfatoorah');
        $currencyIso = $this->checkCountryAndCurrency($order_info['currency_code']);
        if (!$currencyIso) {
            // go to checkout and err msg Curreny not supported with payment gateway
            $this->session->data['error'] = $order_info['currency_code'] . ' ' . $this->language->get('curreny_error');
            $this->response->redirect('index.php?route=checkout/checkout');
        }
        //

        $the_total = 0;
        $invoiceItemsArr = array();
        foreach ($products as $product) {
            if (trim($product['name']) == '') {
                continue;
            }

            $invoiceItemsArr[] = array('ProductId' => '', 'ProductName' => $product['name'], 'Quantity' => $product['quantity'], 'UnitPrice' => $product['price'] * $order_info['currency_value']);
            $the_total += $product['price'] * $order_info['currency_value'];
        }
        $total = $this->cart->gettotal();
        // Totals
        $this->load->model('setting/extension');

        $totals = array();
        $taxes = $this->cart->getTaxes();
        $total = 0;

        // Because __call can not keep var references so we put them into an array.
        $total_data = array(
            'totals' => &$totals,
            'taxes' => &$taxes,
            'total' => &$total,
        );
        // get discount, taxes, shipping, total and subtotal prices

        if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
            $sort_order = array();

            $results = $this->model_setting_extension->getExtensions('total');

            foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
            }

            array_multisort($sort_order, SORT_ASC, $results);

            foreach ($results as $result) {
                if ($this->config->get('total_' . $result['code'] . '_status')) {
                    $this->load->model('extension/total/' . $result['code']);

                    // We have to put the totals in an array so that they pass by reference.
                    $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                }
            }

            $sort_order = array();

            foreach ($totals as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
            }

            array_multisort($sort_order, SORT_ASC, $totals);
        }

        $subTotal = $totalPrice = null;
        foreach ($totals as $total) {
            if ($total['code'] == 'sub_total') {
                $subTotal = $total['value'];
            } else if ($total['code'] == 'total') {
                $totalPrice = $total['value'];
            } else {

                $invoiceItemsArr[] = array('ProductId' => '', 'ProductName' => $total['title'], 'Quantity' => 1, 'UnitPrice' => $total['value'] * $order_info['currency_value']);
            }
        }

        $fname = $this->customer->getFirstName();
        $lname = $this->customer->getLastName();
        $name = isset($fname, $lname) ? $fname . $lname : $this->session->data['guest']['lastname'] . $this->session->data['guest']['firstname'];

        $gemail = $this->customer->getEmail();
        $email = isset($gemail) ? $gemail : $this->session->data['guest']['email']; //"harbourspace@gmail.com";

        $gtelephone = $this->customer->getTelephone();
        $telephone = isset($gtelephone) ? $gtelephone : $this->session->data['guest']['telephone']; //"1234567890";

        $lang = $this->language->get('code');
        $language = 2;
        if ($lang == 'ar') {
            $language = 1;
        }
        // json data
        $curl_data = '{
            "InvoiceValue": ' . $t . ',
            "CustomerName": "' . $name . '",
            "CustomerBlock": "",
            "CustomerStreet": "",
            "CustomerHouseBuildingNo": "string",
            "CustomerCivilId": "2",
            "CustomerAddress": "string",
            "CustomerReference": "' . $order_info['order_id'] . '",
            "DisplayCurrencyIso":"' . $currencyIso . '",
            "CountryCodeId": 0,
            "CustomerMobile": "' . $this->checkTelephone($telephone) . '",
            "CustomerEmail": "' . $email . '",
            "SendInvoiceOption": 1,
            "InvoiceItemsCreate": ' . json_encode($invoiceItemsArr) . ',
            "CallBackUrl": "' . htmlentities($this->url->link('extension/payment/myfatoorah/callback')) . '",
            "Language": ' . $language . ',
            "ExpireDate": "' . gmdate("D, d M Y H:i:s", time() + 7 * 24 * 60 * 60) . '",
                "ApiCustomFileds": "string",
                "ErrorUrl": "' . htmlentities($this->url->link('extension/payment/myfatoorah/callback')) . '"
        }';

        $api_invoice = $this->gateway_url . '/ApiInvoices/CreateInvoiceIso';
        $result = '';
        do {
            $retry = false;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_invoice);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_data);

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Accept: application/json",
                "Authorization: $this->token",
            ));

            $res = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $err = curl_error($ch);
            $result = json_decode($res);

            if ($httpcode === 401) { // unauthorized
                $this->getToken();
                $retry = true;
            }
            curl_close($ch);
        } while ($retry);

        if (isset($result->IsSuccess) && $result->IsSuccess) {
            foreach ($result->PaymentMethods as $PaymentMethod) {
                if ($PaymentMethod->PaymentMethodCode === $this->config->get('myfatoorah_payment_type')) {
                    $redirectUrl = $PaymentMethod->PaymentMethodUrl;
                }
            }
            if ($redirectUrl == '' || $this->api_gateway_payment === 'myfatoorah') {
                $redirectUrl = $result->RedirectUrl;
            }
            $this->response->redirect($redirectUrl);
        } else {
            foreach ($result->FieldsErrors as $error) {
                if ($error->Name == 'CustomerMobile') {
                    $this->session->data['error'] = $this->language->get('Phone_error');
                } else {
                    $this->session->data['error'] = $error->Name . ' ' . $error->Error;

                }
            }
            $this->response->redirect('index.php?route=checkout/checkout');
        }

    }

    private function log($message)
    {
        if ($this->logging) {
            $this->log->write($message);
        }
    }

}
