@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-teal-50 py-12 flex justify-center items-center font-sans">
    <div class="w-full max-w-2xl px-4">
        <div class="bg-white border-4 border-black p-8 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]">
            <h1 class="text-3xl font-black uppercase mb-6 border-b-4 border-black pb-4 text-center">UPLOAD ITEM KE INVENTORY</h1>

            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block font-black uppercase mb-1">Nama Item</label>
                    <input type="text" name="item_name" class="w-full border-4 border-black p-3 font-bold focus:bg-yellow-50" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-black uppercase mb-1">Game</label>
                        <select name="game" class="w-full border-4 border-black p-3 font-bold">
                            <option value="Valorant">Valorant</option>
                            <option value="CS2">CS2</option>
                            <option value="Ragnarok">Ragnarok</option>
                            <option value="Tower of Fantasy">Tower of Fantasy</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-black uppercase mb-1">Kategori</label>
                        <select name="category" class="w-full border-4 border-black p-3 font-bold">
                            <option value="Account">Account</option>
                            <option value="Skin">Skin</option>
                            <option value="Currency">Currency</option>
                            <option value="Item">Item</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-black uppercase mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full border-4 border-black p-3 font-bold"></textarea>
                </div>

                <div>
                    <label class="block font-black uppercase mb-1">Gambar</label>
                    <input type="file" name="image" class="w-full border-4 border-black p-2 bg-gray-100 font-bold" required>
                </div>

                <button type="submit" class="w-full py-4 bg-black text-white font-black text-xl border-4 border-transparent hover:bg-white hover:text-black hover:border-black transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,0.5)] hover:shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] uppercase">
                    SIMPAN KE INVENTORY
                </button>
            </form>
        </div>
    </div>
</div>
@endsection