@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-yellow-400 border-3 border-black shadow-neo p-4">
            <h4 class="font-bold text-sm">TOTAL USERS</h4>
            <p class="text-4xl font-black mt-2">1,204</p>
        </div>

        <div class="bg-teal-400 border-3 border-black shadow-neo p-4">
            <h4 class="font-bold text-sm">NEW ORDERS</h4>
            <p class="text-4xl font-black mt-2">56</p>
        </div>
        
        <div class="bg-red-400 border-3 border-black shadow-neo p-4 text-white"> <h4 class="font-bold text-sm text-black">REVENUE</h4>
            <p class="text-4xl font-black mt-2 text-black">$8,400</p>
        </div>
    </div>

    <x-neo-card title="Recent Activity">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b-3 border-black">
                    <th class="py-3 font-black">USER</th>
                    <th class="py-3 font-black">ACTION</th>
                    <th class="py-3 font-black">DATE</th>
                    <th class="py-3 font-black text-right">STATUS</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b-2 border-gray-200 hover:bg-yellow-50">
                    <td class="py-3 font-bold">Thalibul Ichlas</td>
                    <td class="py-3">Login</td>
                    <td class="py-3">10 Jan 2024</td>
                    <td class="py-3 text-right">
                        <span class="bg-green-300 border-2 border-black px-2 py-1 text-xs font-bold">ACTIVE</span>
                    </td>
                </tr>
                <tr class="hover:bg-yellow-50">
                    <td class="py-3 font-bold">Arik asep</td>
                    <td class="py-3">Purchase</td>
                    <td class="py-3">11 Jan 2024</td>
                    <td class="py-3 text-right">
                        <span class="bg-yellow-300 border-2 border-black px-2 py-1 text-xs font-bold">PENDING</span>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div class="mt-6 flex gap-4">
            <x-neo-button color="yellow">View All</x-neo-button>
            <x-neo-button color="white">Export PDF</x-neo-button>
        </div>
    </x-neo-card>
@endsection