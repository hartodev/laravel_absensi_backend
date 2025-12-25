<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * LIST CATATAN USER
     */
    public function index(Request $request)
    {
        $notes = Note::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($notes);
    }

    /**
     * SIMPAN CATATAN BARU
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'note' => 'required|string',
        ]);

        $note = Note::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'note' => $request->note,
        ]);

        return response()->json([
            'message' => 'Catatan berhasil dibuat',
            'data' => $note
        ], 201);
    }

    /**
     * DETAIL CATATAN
     */
    public function show(Request $request, $id)
    {
        $note = Note::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return response()->json($note);
    }

    /**
     * UPDATE CATATAN
     */
    public function update(Request $request, $id)
    {
        $note = Note::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'note' => 'required|string',
        ]);

        $note->update([
            'title' => $request->title,
            'note' => $request->note,
        ]);

        return response()->json([
            'message' => 'Catatan berhasil diperbarui',
            'data' => $note
        ]);
    }

    /**
     * HAPUS CATATAN
     */
    public function destroy(Request $request, $id)
    {
        $note = Note::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $note->delete();

        return response()->json([
            'message' => 'Catatan berhasil dihapus'
        ]);
    }
}
