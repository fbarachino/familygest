<?php

namespace App\Modules\FamilyMembers\Controllers;

use App\Modules\FamilyMembers\Models\FamilyMember;
use App\Modules\FamilyMembers\Requests\StoreFamilyMemberRequest;
use App\Modules\FamilyMembers\Requests\UpdateFamilyMemberRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FamilyMemberApiController extends Controller
{
    public function index(): JsonResponse
    {
        $members = FamilyMember::orderBy('cognome')->orderBy('nome')->get();

        return response()->json($members);
    }

    public function store(StoreFamilyMemberRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('family-members', 'public');
        }

        $member = FamilyMember::create($data);

        return response()->json($member, 201);
    }

    public function show(FamilyMember $familyMember): JsonResponse
    {
        return response()->json($familyMember);
    }

    public function update(UpdateFamilyMemberRequest $request, FamilyMember $familyMember): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($familyMember->foto) {
                Storage::disk('public')->delete($familyMember->foto);
            }

            $data['foto'] = $request->file('foto')->store('family-members', 'public');
        }

        $familyMember->update($data);

        return response()->json($familyMember);
    }

    public function destroy(FamilyMember $familyMember): JsonResponse
    {
        if ($familyMember->foto) {
            Storage::disk('public')->delete($familyMember->foto);
        }

        $familyMember->delete();

        return response()->json(null, 204);
    }
}
