<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MembersRequest;
use App\Models\Members;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MembersController extends Controller
{
    public function index(): View
    {
        return view('admin.members.index', [
            'members' => Members::latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.members.create');
    }

    public function store(MembersRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Members::create([
            'name' => $data['name'],
            'phone_number' => $data['phone'],
            'age' => $data['age'],
            'place_of_residence' => $data['residence'],
            'role' => $data['role'],
            'img' => $request->file('image')->store(Members::IMAGE_DIRECTORY, Members::IMAGE_DISK),
        ]);

        return redirect()->route('members.index')->with('success', 'The member has been added.');
    }

    public function show(Members $member): View
    {
        return view('admin.members.views', ['member' => $member]);
    }

    public function edit(Members $member): View
    {
        return view('admin.members.edit', ['member' => $member]);
    }

    public function update(MembersRequest $request, Members $member): RedirectResponse
    {
        $data = $request->validated();

        $attributes = [
            'name' => $data['name'],
            'phone_number' => $data['phone'],
            'age' => $data['age'],
            'place_of_residence' => $data['residence'],
            'role' => $data['role'],
        ];

        if ($request->hasFile('image')) {
            $member->deleteImageFile();
            $attributes['img'] = $request->file('image')->store(Members::IMAGE_DIRECTORY, Members::IMAGE_DISK);
        }

        $member->update($attributes);

        return redirect()->route('members.index')->with('success', 'The member has been updated.');
    }

    public function destroy(Members $member): RedirectResponse
    {
        $member->deleteImageFile();
        $member->delete();

        return redirect()->route('members.index')->with('success', 'The member has been deleted.');
    }
}
