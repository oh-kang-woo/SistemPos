<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseCategory;

class ExpenseController extends Controller
{
    public function index()
    {
        $pengeluaran = Expense::with('category')->orderBy('tanggal', 'desc')->get();
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
            // tambahkan validasi lampiran jika perlu
        ]);

        Expense::create($request->all());
        return back()->with('success', 'Pengeluaran berhasil dicatat!');
    }
}
