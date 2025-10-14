<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans     = Plan::orderBy('id', 'desc')->paginate(getPaginate());
        $pageTitle = "Manage Plan";
        return view('admin.plan.index', compact('pageTitle', 'plans'));
    }

    public function save(Request $request, $id = 0)
    {
        $request->validate([
            'name'     => 'required|max:40|unique:plans,name,' . $id,
            'price'    => 'required|numeric|gte:0',
            'duration' => 'required|integer|gt:0',
            'job_post' => 'required|integer|gt:0',
            'featured_job_post' => 'required|integer|gte:0',
        ]);

        if ($id) {
            $plan    = Plan::findOrFail($id);
            $message = "Plan updated successfully";
        } else {
            $plan    = new Plan;
            $message = "Plan added successfully";
        }

        $plan->name     = $request->name;
        $plan->price    = $request->price;
        $plan->job_post = $request->job_post;
        $plan->featured_job_post = $request->featured_job_post;
        $plan->duration = $request->duration;
        $plan->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return Plan::changeStatus($id);
    }

    public function planSubscriberList($id = 0)
    {
        if ($id) {
            $plan          = Plan::findOrFail($id);
            $subscriptions = Subscription::where('plan_id', $plan->id);
            $pageTitle     = $plan->name . " - subscribers list";
        } else {
            $subscriptions = Subscription::filter(['employer_id']);
            $pageTitle     = " Plan subscribers list";
        }
        $subscriptions = $subscriptions->latest()->with('employer', 'plan')->paginate(getPaginate());
        return view('admin.plan.subscriber', compact('pageTitle', 'subscriptions'));
    }
}
