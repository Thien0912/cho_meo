<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    // Hiển thị danh sách chi tiêu
    public function index()
    {
        $expenses = Expense::all();
        return view('admin.expenses.index', compact('expenses'));
    }

    // Hiển thị form tạo chi tiêu mới
    public function create()
    {
        return view('admin.expenses.create');
    }

    // Lưu chi tiêu mới
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        Expense::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense created successfully.');
    }

    // Hiển thị form chỉnh sửa chi tiêu
    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        return view('admin.expenses.edit', compact('expense'));
    }

    // Cập nhật chi tiêu
    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $expense = Expense::findOrFail($id);
        $expense->update([
            'description' => $request->description,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense updated successfully.');
    }

    // Xóa chi tiêu
    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('admin.expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
