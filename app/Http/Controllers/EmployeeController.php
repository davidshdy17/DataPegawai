<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // tampilkan nama pegawai dan gunakan paginasi agar halaman tidak terlalu panjang
        $employees = Employee::paginate(5);
        return view('employees.index', compact('employees'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // buat halaman create
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi data yang akan diinput
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'required|string|max:20|unique:employees,nip',
            'email' => 'required|email|max:100|unique:employees,email',
            'jabatan' => 'required|string|max:100',
            'alamat' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        if($request->hasFile('foto')){
            $path = $request->file('foto')->store('employees', 'public');

            $validated['foto'] = $path;
        }

        // simnpan data yang sudah di validasi ke database
        Employee::create($validated);
        // redirect ke index
        return redirect()->route('employees.index')-> with('success', 'Data Karyawan telah ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // cari data karyawan berdasarkan id
        $employee = Employee::findOrFail($id);
        // tampilkan data karyawan berdasarkan id yang sesuai
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // cari id karyawan yang indgin diedit
        $employee = Employee::findOrFail($id);
        // tampilkan halaman edit dengan data pegawai
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        // 1. Cari pegawai berdasarkan ID
        $employee = Employee::findOrFail($id);

        // 2. Validasi data
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'required|string|max:20|unique:employees,nip,' . $employee->id,
            'email' => 'required|email|max:100|unique:employees,email,' . $employee->id,
            'jabatan' => 'required|string|max:100',
            'alamat' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // 3. Simpan path foto lama
        $fotoLama = $employee->foto;
        $fotoBaru = null;

        // 4. Upload foto baru jika pengguna memilih file
        if ($request->hasFile('foto')) {
            $fotoBaru = $request->file('foto')->store('employees', 'public');

            // Masukkan path foto baru ke data yang divalidasi
            $validated['foto'] = $fotoBaru;
        }

        // 5. Update data pegawai
        try {
            $employee->update($validated);
        } catch (\Throwable $e) {
            // Bersihkan file baru jika update database gagal
            if ($fotoBaru) {
                Storage::disk('public')->delete($fotoBaru);
            }

            throw $e;
        }

        // 6. Hapus foto lama setelah update berhasil
        if ($fotoBaru && $fotoLama && $fotoLama !== $fotoBaru) {
            Storage::disk('public')->delete($fotoLama);
        }

        // 7. Redirect dengan pesan sukses
        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari data pegawai
        $employee = Employee::findOrFail($id);

        // Simpan path foto sebelum record dihapus
        $foto = $employee->foto;

        // Hapus data dari database
        $employee->delete();

        // Hapus file foto jika ada
        if ($foto && Storage::disk('public')->exists($foto)) {
            Storage::disk('public')->delete($foto);
        }

        return redirect()
            ->route('employees.index')
            ->with('success', 'Data karyawan berhasil dihapus');
    }

    public function search(Request $request)
    {
        $keyword = $request->validate([
            'q' => 'nullable|string|max:100',
        ]);

        $q = $keyword['q'] ?? '';

        $employees = Employee::query()
            ->where(function ($query) use ($q) {
                $pattern = '%' . $q . '%';

                $query->where('nama', 'like', $pattern)
                    ->orWhere('nip', 'like', $pattern)
                    ->orWhere('jabatan', 'like', $pattern);
            })
            ->orderBy('id', 'desc')
            ->limit(20)
            ->get(['id', 'nip', 'nama', 'email', 'jabatan', 'alamat']);

        return response()->json($employees);
    }
}
