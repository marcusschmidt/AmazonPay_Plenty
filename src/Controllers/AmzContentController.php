<?php

namespace AmazonLoginAndPay\Controllers;

use AmazonLoginAndPay\Helpers\AlkimAmazonLoginAndPayHelper;
use AmazonLoginAndPay\Helpers\AmzCheckoutHelper;
use AmazonLoginAndPay\Helpers\AmzTransactionHelper;
use AmazonLoginAndPay\Services\AmzBasketService;
use AmazonLoginAndPay\Services\AmzCustomerService;
use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\Http\Response;
use Plenty\Plugin\Templates\Twig;

class AmzContentController extends Controller
{
    public $configRepo;
    public $response;
    public $request;
    public $helper;
    public $transactionHelper;
    public $checkoutHelper;
    public $basketService;
    public $customerService;

    public function __construct(Response $response, Request $request, AlkimAmazonLoginAndPayHelper $helper, AmzTransactionHelper $transactionHelper, AmzCheckoutHelper $checkoutHelper, AmzBasketService $basketService, AmzCustomerService $customerService)
    {
        $this->response          = $response;
        $this->request           = $request;
        $this->helper            = $helper;
        $this->transactionHelper = $transactionHelper;
        $this->checkoutHelper    = $checkoutHelper;
        $this->basketService     = $basketService;
        $this->customerService   = $customerService;
        $this->helper->getAccessToken();
    }

    public function amazonCheckoutAction(Twig $twig)
    {
        $this->checkoutHelper->setPaymentMethod();
        $userData     = $this->helper->getFromSession('amzUserData');
        $basket       = $this->checkoutHelper->getBasketData();
        $templateData = [
            'userData' => $userData,
            'currency' => $basket["currency"],
            'error'    => $this->helper->getFromSession('amazonCheckoutError')
        ];
        if ($mfcError = $this->request->get('AuthenticationStatus')) {
            switch ($mfcError) {
                case 'Abandoned':
                    $templateData['error'] = 'MfaAbandoned';
                    break;
                case 'Failure':
                    $this->helper->scheduleNotification($this->helper->translate('AmazonLoginAndPay::AmazonPay.errorMfaFailed'));

                    return $this->response->redirectTo('basket');
                    break;
            }
        }

        return $twig->render('AmazonLoginAndPay::content.amazon-checkout', $templateData);
    }

    public function amazonCheckoutWalletAction(Twig $twig)
    {
        $this->checkoutHelper->setPaymentMethod();
        $userData     = $this->helper->getFromSession('amzUserData');
        $basket       = $this->checkoutHelper->getBasketData();
        $templateData = [
            'userData'   => $userData,
            'currency'   => $basket["currency"],
            'walletOnly' => 1
        ];

        return $twig->render('AmazonLoginAndPay::content.amazon-checkout', $templateData);
    }

    public function amazonLoginProcessingAction(Twig $twig)
    {
        return $twig->render('AmazonLoginAndPay::content.amazon-login-processing', []);
        /*
        //TODO: decide whether to login or not
        $loginInfo = $this->customerService->loginWithAmazonUserData($userData);
        if (!empty($loginInfo["redirect"])) {
            return $this->response->redirectTo($loginInfo["redirect"]);
        } else {
            //TODO: decide where to go
            return $this->response->redirectTo('amazon-checkout');
        }
        */
    }

    public function amazonConnectAccountsAction(Request $request, Twig $twig)
    {
        $userData = $this->helper->getFromSession('amzUserData');
        $this->helper->log(__CLASS__, __METHOD__, 'amazonConnectAccountsAction - request', [$request, $request->get('email'), $request->get('password')]);
        if (($email = $request->get('email')) && ($password = $request->get('password'))) {
            $connectInfo = $this->customerService->connectAccounts($userData, $email, $password);
            if ($connectInfo["success"]) {
                return $this->response->redirectTo('amazon-checkout');
            }
        }
        $templateData = [
            'email' => $userData["email"]
        ];

        return $twig->render('AmazonLoginAndPay::content.amazon-connect-accounts', $templateData);
    }

    public function amazonCheckoutProceedAction()
    {
        $orderReferenceId = $this->helper->getFromSession('amzOrderReference');
        $walletOnly       = $this->helper->getFromSession('amzInvalidPaymentOrderReference') == $orderReferenceId;
        $this->helper->log(__CLASS__, __METHOD__, 'is wallet only?', $walletOnly);
        //if ($this->helper->getFromConfig('submitOrderIds') != 'true' || $walletOnly) {
        $amount = null;
        if ($walletOnly) {
            $amount = $this->transactionHelper->getAmountFromOrderRef($orderReferenceId);
        }
        $return = $this->checkoutHelper->doCheckoutActions($amount, 0, $walletOnly);
        $this->helper->log(__CLASS__, __METHOD__, 'checkout actions response', $return);
        if (!empty($return["redirect"])) {
            return $this->response->redirectTo($return["redirect"]);
        }

        /*
        } else {

            $basketItems = $this->basketService->getBasketItems();
            $this->helper->log(__CLASS__, __METHOD__, 'set basket items to session', $basketItems);
            $this->helper->setToSession('amzCheckoutBasket', $basketItems);
            $this->helper->log(__CLASS__, __METHOD__, 'set basket items to session - done', $basketItems);
        }
        */

        return $this->response->redirectTo('place-order');
    }

    public function amazonCronAction()
    {
        return '';
    }

}
