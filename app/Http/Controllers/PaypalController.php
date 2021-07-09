<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PayPal\Api\PaymentExecution;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class PaypalController extends Controller
{
    private $apiContext;
    private $secret;
    private $clientId;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     //preparing the configurations for paypal once class initiated
        $this->clientId = config("paypal.client_id");
        $this->secret = config("paypal.secret");
        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->clientId, $this->secret));
        $this->apiContext->setConfig(config('paypal.settings'));
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function checkout(Request $request): ?string
    {
        //check if user select items to buy or not
        $this->validate($request, [
            'items' => 'present|array',
        ]);

        //get items as array from the request
        $assets = json_encode($request->items);
        $mr = json_decode($assets, true);

        //definitions of arrays will be used later
        $total = array();
        $item = array();
        $i = 0;

        foreach ($mr as $value) {
            //adding the total price of each item in array
            $total[$i] = $value['Quantity'] * $value['Price'];
            //array of object of items and set their attributes
            $item[$i] = new Item();
            $item[$i]->setName($value['name'])
                ->setCurrency('USD')
                ->setQuantity($value['Quantity'])
                ->setPrice($value['Price']);
            array_push($item, $item[$i]);
            $i++;
        }
        array_pop($item);

        //calculate total price of whole items
        $total = array_sum($total);

         //but items in item list
        $itemList = new ItemList();
        $itemList->setItems($item);

        //set the payment methode
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        //set the currency and total price
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($total);

        //creating transaction object and set its attributes
        $transaction = new Transaction();
        $transaction->setItemList($itemList);
        $transaction->setAmount($amount)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        //creating redirect url of canceling and submit payment
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("http://127.0.0.1:80/api/status")
            ->setCancelUrl("http://127.0.0.1:80/api/cancelled");

        //creating the object of payment and its attributes
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        //execute the payment
        try {
            $payment->create($this->apiContext);
        } catch (Exception $ex) {
            print_r($ex->getMessage());
            print_r($ex->getData());
            die($ex);
        }
        //if payment succeeded redirect to approval
        $approvalUrl = $payment->getApprovalLink();
        //note: if you want to redirect to url immediately use return redirect
        return  ($approvalUrl);
    }

    public function cancelled(): JsonResponse
    {
        return response()->json([
            'payment' => 'payment has been canceld', 201]);
    }

    public function status(Request $request): JsonResponse
    {
        //check if there is payment to execute or not
        if (empty($request->input('PayerID') || empty($request->input('token')))) {
            return response()->json([
                'payment' => 'payment field', 404]);
        }
        //get payment and payer id and create object execution
        $paymentId = $request->get('paymentId');
        $payment = Payment::get($paymentId, $this->apiContext);
        $payerId = $request->get('PayerID');
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        //execute the payment
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() == 'approved') {
            //construct array of items from transaction object
            $arr = $result->toArray();
            $trn = $arr['transactions'];
            $trn = $trn['0'];
            $trn = $trn ['item_list'];
            $trn1 = $trn['items'];

            //get the item from database
            foreach ($trn1 as $value) {
                $result = Product::where('name', 'like', '%' . $value['name'] . '%')->get();
                //if item (product) found then reduce counter by quantity
                if (count($result) !== 0) {
                    foreach ($result as $object) {
                        $product = Product::find($object->id);
                        $product->counter -= $value['quantity'];
                        $product->save();
                    }
                }



            }
        }
        return response()->json([
        'payment' => 'payment succeeded',201]);
    }
}
