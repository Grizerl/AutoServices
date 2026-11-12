<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Models\SubscriptionPlan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/** Admin: subscription plans shown on the public pricing page. */
class PlanController extends Controller
{
    public function index(): View
    {
        return view('admin.plans.index', [
            'plans' => SubscriptionPlan::query()->withCount('subscriptions')->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.plans.create');
    }

    public function store(PlanRequest $request): RedirectResponse
    {
        SubscriptionPlan::create($request->validated());

        return redirect()->route('plans.index')->with('success', 'The plan has been created.');
    }

    public function edit(SubscriptionPlan $plan): View
    {
        return view('admin.plans.edit', ['plan' => $plan]);
    }

    public function update(PlanRequest $request, SubscriptionPlan $plan): RedirectResponse
    {
        $plan->update($request->validated());

        return redirect()->route('plans.index')->with('success', 'The plan has been updated.');
    }

    public function destroy(SubscriptionPlan $plan): RedirectResponse
    {
        // existing subscriptions keep a snapshot of the plan name and price
        $plan->delete();

        return redirect()->route('plans.index')->with('success', 'The plan has been deleted. Existing subscriptions keep their data.');
    }
}
