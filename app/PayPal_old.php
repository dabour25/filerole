<?php

namespace App;

use Omnipay\Omnipay;

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

        $gateway->setUsername('hossamwheed93-facilitator_api1.gmail.com');
        $gateway->setPassword('W27PD22TUMCDKL5T');
        $gateway->setSignature('AgViFM39DaPhAL5ZmmhicxyF.lJiAY7oKRV3Wvu0XvER0FjzMl7fBoTR');
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
        return route('paypal.checkout.cancelled', $order);
    }

    /**
     * @param $order
     */
    public function getReturnUrl($external_req_id,$price,$name,$email,$org)
    {

      return url("payment_completed/$external_req_id/$price/$name/$email/$org");
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
