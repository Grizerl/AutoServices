<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RepairRequest;
use App\Models\Repair;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RepairController extends Controller
{
    public function index(): View
    {
        return view('admin.repair.index', [
            'repair' => Repair::latest('id')->paginate(15),
        ]);
    }

    public function show(Repair $repair): View
    {
        return view('admin.repair.view', ['repair' => $repair]);
    }

    public function edit(Repair $repair): View
    {
        return view('admin.repair.edit', ['repair' => $repair]);
    }

    public function update(RepairRequest $request, Repair $repair): RedirectResponse
    {
        $data = $request->validated();

        $repair->update([
            'name' => $data['name'],
            'telephone' => $data['phone'],
            'car' => $data['car'],
            'comment' => $data['problem'],
            'price' => $data['price'],
            'done' => $data['done'],
        ]);

        return redirect()->route('repair.index')->with('success', 'The repair request has been updated.');
    }

    public function destroy(Repair $repair): RedirectResponse
    {
        $repair->delete();

        return redirect()->route('repair.index')->with('success', 'The repair request has been deleted.');
    }
}
