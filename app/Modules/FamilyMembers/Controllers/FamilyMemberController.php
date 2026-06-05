<?php

namespace App\Modules\FamilyMembers\Controllers;

use App\Models\User;
use App\Modules\FamilyMembers\Models\FamilyMember;
use App\Modules\FamilyMembers\Requests\StoreFamilyMemberRequest;
use App\Modules\FamilyMembers\Requests\UpdateFamilyMemberRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FamilyMemberController extends Controller
{
    public function index(): View
    {
        $members = FamilyMember::orderBy('cognome')->orderBy('nome')->paginate(15);

        return view('family-members::index', compact('members'));
    }

    public function create(): View
    {
        $relazioni = [
            'padre', 'madre', 'figlio', 'figlia',
            'nonno', 'nonna', 'zio', 'zia',
            'cugino', 'cugina', 'altro',
        ];

        return view('family-members::create', compact('relazioni'));
    }

    public function store(StoreFamilyMemberRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('family-members', 'public');
        }

        $data['user_id'] = $this->resolveUserId($data);

        FamilyMember::create($data);

        return redirect()->route('family-members.index')
            ->with('success', 'Membro della famiglia aggiunto con successo.');
    }

    public function show(FamilyMember $familyMember): View
    {
        return view('family-members::show', compact('familyMember'));
    }

    public function edit(FamilyMember $familyMember): View
    {
        $relazioni = [
            'padre', 'madre', 'figlio', 'figlia',
            'nonno', 'nonna', 'zio', 'zia',
            'cugino', 'cugina', 'altro',
        ];

        return view('family-members::edit', compact('familyMember', 'relazioni'));
    }

    public function update(UpdateFamilyMemberRequest $request, FamilyMember $familyMember): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($familyMember->foto) {
                Storage::disk('public')->delete($familyMember->foto);
            }

            $data['foto'] = $request->file('foto')->store('family-members', 'public');
        }

        $data['user_id'] = $this->resolveUserId($data);

        $familyMember->update($data);

        return redirect()->route('family-members.index')
            ->with('success', 'Membro della famiglia aggiornato con successo.');
    }

    private function resolveUserId(array $data): ?int
    {
        if (empty($data['email'])) {
            return null;
        }

        return User::where('email', $data['email'])->value('id');
    }

    public function destroy(FamilyMember $familyMember): RedirectResponse
    {
        if ($familyMember->foto) {
            Storage::disk('public')->delete($familyMember->foto);
        }

        $familyMember->delete();

        return redirect()->route('family-members.index')
            ->with('success', 'Membro della famiglia eliminato con successo.');
    }
}
