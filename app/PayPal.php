<?php

namespace App;

use Omnipay\Omnipay;
use App\PaymentSetup;
use Auth;

/**
 * Class PayPal
 * @package App
 */
class PayPal
{
    /**
     * @return mixed
     */
    public function gateway()
    {
        $gateway = Omnipay::create('PayPal_Express');
        $username=PaymentSetup::where(['gateway' => 'paypal', 'org_id' => Auth::guard('customers')->user()->org_id])->value('acc_name');
        $password=PaymentSetup::where(['gateway' => 'paypal', 'org_id' => Auth::guard('customers')->user()->org_id])->value('acc_password');
        $signature=PaymentSetup::where(['gateway' => 'paypal', 'org_id' => Auth::guard('customers')->user()->org_id])->value('acc_signature');
        $gateway->setUsername($username);
        $gateway->setPassword($password);
        $gateway->setSignature($signature);
        $gateway->setTestMode('sandbox');

        return $gateway;
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function purchase(array $parameters)
    {
        $response = $this->gateway()
            ->purchase($parameters)
            ->send();

        return $response;
    }

    /**
     * @param array $parameters
     */
    public function complete(array $parameters)
    {
        $response = $this->gateway()
            ->completePurchase($parameters)
            ->send();

        return $response;
    }

    /**
     * @param $amount
     */
    public function formatAmount($amount)
    {
        return number_format($amount, 2, '.', '');
    }

    /**
     * @param $order
     */
    public function getCancelUrl($order)
    {
        return url("payment/cancelled");
        // return route('paypal.checkout.cancelled', $order);
    }

    /**
     * @param $order
     */
    public function getReturnUrl($external_req_id,$price,$name,$email,$org,$support_email)
    {

      return url("payment_completed/$external_req_id/$price/$name/$email/$org/$support_email");
        // return route('paypal.checkout.completed', $external_req_id);
    }

    /**
     * @param $order
     */
    public function getNotifyUrl($order)
    {
        $env = config('services.paypal.sandbox') ? "sandbox" : "live";

        return route('webhook.paypal.ipn', [$order, $env]);
    }
}
