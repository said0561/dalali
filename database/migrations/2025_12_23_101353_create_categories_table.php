<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable(); // Kwa ajili ya Bootstrap icons
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }



        // Ukurasa wa kuonyesha watumiaji wote
    public function userIndex() {
        $users = User::with(['role', 'region'])->latest()->paginate(20);
        $roles = \App\Models\Role::all(); // Kwa ajili ya machaguo ya Role kwenye Edit Modal
        $regions = \App\Models\Region::all(); // Kwa ajili ya machaguo ya Mkoa
        
        return view('admin.users.index', compact('users', 'roles', 'regions'));
    }

    // Function ya kuhifadhi mabadiliko ya mtumiaji
    public function userUpdate(Request $request, $id) {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:users,phone,'.$id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|min:6|confirmed', // 'confirmed' inamaanisha uwe na input ya password_confirmation
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->role_id = $request->role_id;
        $user->region_id = $request->region_id;
        
        if($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        
        $user->save();
        return back()->with('success', 'Taarifa za ' . $user->name . ' zimesasishwa kikamilifu.');
    }
};
