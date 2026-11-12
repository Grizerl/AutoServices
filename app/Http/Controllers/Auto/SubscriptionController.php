<?php

namespace App\Http\Controllers\Auto;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscribeRequest;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/** Public subscription plans, checkout and confirmation. */
class SubscriptionController extends Controller
{
    public function plans(Request $request): View
    {
        return view('auto.pages.plan', [
            'plans' => SubscriptionPlan::active()->ordered()->get(),
            'period' => $this->period($request),
        ]);
    }

    public function checkout(Request $request, SubscriptionPlan $plan): View
    {
        abort_unless($plan->is_active, 404);

        return view('auto.subscriptions.checkout', [
            'plan' => $plan,
            'period' => $this->period($request),
        ]);
    }

    public function store(SubscribeRequest $request, SubscriptionPlan $plan): RedirectResponse|JsonResponse
    {
        abort_unless($plan->is_active, 404);

        $data = $request->validated();

        $subscription = Subscription::create([
            'subscription_plan_id' => $plan->id,
            'plan_name' => $plan->name,
            'billing_period' => $data['billing_period'],
            'price' => $plan->priceFor($data['billing_period']), // price is frozen at request time
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'car' => $data['car'],
            'notes' => $data['notes'] ?? null,
        ]);

        // AJAX submit: return the confirmation markup so the page does not reload
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Your subscription request has been received.',
                'reference' => $subscription->reference,
                'html' => view('auto.subscriptions._summary', ['subscription' => $subscription])->render(),
            ]);
        }

        return redirect()->route('plan.thanks', $subscription->reference);
    }

    public function thanks(string $reference): View
    {
        $subscription = Subscription::where('reference', $reference)->firstOrFail();

        return view('auto.subscriptions.thanks', ['subscription' => $subscription]);
    }

    private function period(Request $request): string
    {
        return $request->query('period') === Subscription::PERIOD_YEARLY
            ? Subscription::PERIOD_YEARLY
            : Subscription::PERIOD_MONTHLY;
    }
}
