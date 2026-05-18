<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseCategory;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        // Menggunakan Query Builder untuk fitur Pencarian & Filter
        $query = Expense::with('category')->orderBy('tanggal', 'desc');

        if ($request->filled('kategori')) {
            $query->where('expense_category_id', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('deskripsi', 'like', '%' . $request->search . '%');
        }

        $pengeluaran = $query->get();
        $kategori = ExpenseCategory::where('status_aktif', true)->get();

        $totalPengeluaran = $pengeluaran->sum('nominal');
        $jumlahPengeluaran = $pengeluaran->count();

        return view('expense.index', compact('pengeluaran', 'kategori', 'totalPengeluaran', 'jumlahPengeluaran'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['nama_kategori' => 'required|string|max:255']);
        ExpenseCategory::create([
            'nama_kategori' => $request->nama_kategori,
            'status_aktif' => $request->has('status_aktif') ? true : false,
        ]);
        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'nominal' => 'required|numeric|min:0',
        ]);

        Expense::create($request->all());
        return back()->with('success', 'Pengeluaran berhasil dicatat!');
    }

    // --- FUNGSI BARU UNTUK EDIT & HAPUS ---
    public function updateExpense(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->update($request->all());
        return back()->with('success', 'Data pengeluaran berhasil diubah!');
    }

    public function destroyExpense($id)
    {
        Expense::findOrFail($id)->delete();
        return back()->with('success', 'Data pengeluaran berhasil dihapus!');
    }

    public function print(Request $request)
    {
        $query = Expense::with('category')->orderBy('tanggal', 'desc');
        if ($request->filled('kategori')) $query->where('expense_category_id', $request->kategori);
        if ($request->filled('search')) $query->where('deskripsi', 'like', '%' . $request->search . '%');

        $pengeluaran = $query->get();
        $totalPengeluaran = $pengeluaran->sum('nominal');

        // Buatlah view baru 'expense.print' untuk tampilan cetak nanti
        return view('expense.print', compact('pengeluaran', 'totalPengeluaran'));
    }
}
