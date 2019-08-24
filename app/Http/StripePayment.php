<?php
/**
 * This file is a part of MicroDreamIT
 * (c) Shahanur Sharif <shahanur.sharif@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * or visit https://microdreamit.com
 * Created by Shahanur Sharif.
 * User: sharif
 * Date: 9/9/2018
 * Time: 12:52 PM
 */

namespace App\Http;


class StripePayment
{

    public $plans = [
        'free' => 'prod_DaiMaYobtRD9dX',
        'personal' => [
            'monthly' => 'plan_DZVlj0v1oZMooz',
            'yearly' => 'plan_DZVly4oUGKBed8'
        ],
        'corporate' => [
            'monthly' => 'plan_DaFlTgxr0G3BSD',
            'yearly' => 'plan_DaFmEGhXpsR1LP'
        ]
    ];

    public $requestedPlanId;


    public function __construct()
    {
        $this->getPlanId($this->plans);

    }

    public function swap()
    {


        if (auth()->user()->subscriptions && !auth()->user()->subscription(request()->input('planName') . ' ' . request()->input('planType'))) {

            auth()->user()->subscription(auth()->user()->subscriptions[0]['name'])->swap($this->requestedPlanId)
                ->update(
                    [
                        'name' => request()->input('planName') . ' ' . request()->input('planType')
                    ]);
        }


    }

    public function createCustomer()
    {


        if (!auth()->user()->stripe_id) {
            $this->newSubscription_with_charge();
        }

        elseif (auth()->user()->stripe_id && !auth()->user()->card_brand){
            $this->newSubscription_with_charge();
        }

        return request()->all();

    }

    /**
     * @param $plans
     */
    private function getPlanId($plans)
    {
        foreach ($plans as $plan => $values) {
            if ($plan == request()->input('planName')) {
                if ($values) {
                    foreach ($values as $planType => $stripe_id) {
                        if ($planType == request()->input('planType')) {
                            $this->requestedPlanId = $stripe_id;
                        }
                    }
                }
            }
        }
    }

    public function createOrUpdateCustomer()
    {
        if (auth()->user()->stripe_id) {
            auth()->user()->updateCard(request()->input('id'));
            return response()->json([
                'message'=>[
                    'type'=>'success',
                    'message'=>'card has been updated successfully'
                ]
            ]);
        }
    }

    protected function newSubscription_with_charge()
    {
        auth()->user()
            ->newSubscription(request()->input('planName') . ' ' . request()->input('planType'), $this->requestedPlanId)
            ->create(request()->input('token')['id'], ['email' => auth()->user()->email]);
    }


}