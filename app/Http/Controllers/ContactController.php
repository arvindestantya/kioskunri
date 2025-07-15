<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Contact::query()->with('faculty');

        if (!$user->hasRole('Super Admin')) {
            $query->where('faculty_id', $user->faculty_id);
        }

        $contacts = $query->latest()->get();

        return view('admin.contacts.index', compact('contacts'));
    }

    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.contacts.create', compact('faculties'));
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        $facultyId = $user->hasRole('Super Admin') ? $request->faculty_id : $user->faculty_id;

        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'jenis_kontak' => [
                'required',
                'string',
                'max:255',
                Rule::unique('contacts')->where('faculty_id', $facultyId),
            ],
            'detail' => 'required|string|max:255',
        ]);
        
        Contact::create([
            'jenis_kontak' => $request->jenis_kontak,
            'detail' => $request->detail,
            'faculty_id' => $facultyId,
        ]);
        
        return redirect()->route('contacts.index')->with('success', 'Kontak Informasi berhasil ditambahkan.');
    }
    
    public function edit(Contact $contact)
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.contacts.edit', compact('contact', 'faculties'));
    }
    
    public function update(Request $request, Contact $contact)
    {
        $user = Auth::user();
        $facultyId = $user->hasRole('Super Admin') ? $request->faculty_id : $user->faculty_id;

        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'jenis_kontak' => [
                'required',
                'string',
                'max:255',
                Rule::unique('contacts')->where('faculty_id', $facultyId)->ignore($contact->id),
            ],
            'detail' => 'required|string',
        ]);

        $contact->update($request->all());

        return redirect()->route('contacts.index')->with('success', 'Kontak Informasi berhasil diperbarui.');
    }

    public function destroy(Contact $contact)
    {
        $user = auth()->user();
        if (!$user->hasRole('Super Admin') && $contact->faculty_id !== $user->faculty_id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Kontak berhasil dihapus.');
    }
}
